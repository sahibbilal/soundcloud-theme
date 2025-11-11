<?php
// get-download-links.php
// 🎧 SoundCloud Downloader backend (file-backed SSE progress)
// Drop in place of your existing file. Sends SSE progress to sc_progress_{id}.log and auto-downloads the ZIP.

// -----------------------------
// Config & helpers
// -----------------------------
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

while (ob_get_level() > 0) ob_end_flush();
ob_implicit_flush(true);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit(0); // CORS preflight

set_time_limit(0);
ignore_user_abort(true);

$CLIENT_ID = "MaZ7bR62GvbulJgV8EUjQnHfbZGDEKaI"; // SoundCloud client id

/* ---------- Helpers ---------- */
function resolveRedirect($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_NOBODY => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_HEADER => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => "Mozilla/5.0"
    ]);
    $headers = curl_exec($ch);
    curl_close($ch);
    if (!$headers) return $url;
    preg_match('/Location:\s*(.*)\s*/i', $headers, $matches);
    return isset($matches[1]) ? trim($matches[1]) : $url;
}


function fetchJson($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => "Mozilla/5.0"
    ]);
    $resp = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($resp === false || $status >= 400) return null;
    $decoded = json_decode($resp, true);
    return $decoded === null ? null : $decoded;
}

function getPlaylistInfo($url, $clientId) {
    $resolveUrl = "https://api-v2.soundcloud.com/resolve?url=" . urlencode($url) . "&client_id={$clientId}";
    return fetchJson($resolveUrl);
}

function getTrackInfo($trackId, $clientId) {
    $url = "https://api-v2.soundcloud.com/tracks/{$trackId}?client_id={$clientId}";
    return fetchJson($url);
}

function getStreamUrl($track, $clientId) {
    if (!isset($track['media']['transcodings'])) {
        $track = getTrackInfo($track['id'], $clientId);
        if (!$track) return null;
    }
    $transcodings = $track['media']['transcodings'] ?? [];
    if (empty($transcodings)) return null;
    $progressive = null;
    foreach ($transcodings as $t) {
        if (($t['format']['mime_type'] ?? '') === 'audio/mpeg' && ($t['format']['protocol'] ?? '') === 'progressive') {
            $progressive = $t;
            break;
        }
    }
    $selected = $progressive ?: $transcodings[0];
    $data = fetchJson($selected['url'] . "?client_id={$clientId}");
    return $data['url'] ?? null;
}

function safeFilename($name) {
    $name = preg_replace('/[\\\/:*?"<>|]+/', '_', $name);
    $name = trim($name);
    if ($name === '') return 'file';
    return $name;
}

// -----------------------------
// Router
// -----------------------------
$method = $_SERVER['REQUEST_METHOD'];
$type = $_GET['type'] ?? null;

// ---------- Fetch playlist/track metadata (frontend posts to get-download-links.php) ----------
if ($method === 'POST' && $type === null) {
    $input = json_decode(file_get_contents('php://input'), true);
    $url = $input['url'] ?? null;
    if (!$url) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(["error" => "Missing SoundCloud URL"]);
        exit;
    }

    // resolve redirected short URLs first
    $resolved = resolveRedirect($url);
    $clientId = $CLIENT_ID;
    $playlist = getPlaylistInfo($resolved, $clientId);

    if (!$playlist) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "Playlist/track not found or SoundCloud API failed"]);
        exit;
    }

    // If single track, convert to a playlist-like structure so frontend can handle uniformly
    if (($playlist['kind'] ?? '') === 'track') {
        $playlist['tracks'] = [$playlist];
    } elseif (!isset($playlist['tracks']) || count($playlist['tracks']) === 0) {
        header('Content-Type: application/json');
        echo json_encode(["error" => "No tracks found"]);
        exit;
    }

    $tracks = [];
    foreach ($playlist['tracks'] as $track) {
        $fullTrack = $track;
        if (empty($track['title']) || empty($track['media'])) {
            $refetched = getTrackInfo($track['id'], $clientId);
            if ($refetched) $fullTrack = $refetched;
        }
        $streamUrl = getStreamUrl($fullTrack, $clientId);
        $tracks[] = [
            "id" => $fullTrack['id'],
            "title" => $fullTrack['title'] ?? "Untitled Track",
            "artist" => $fullTrack['user']['username'] ?? "Unknown Artist",
            "duration" => isset($fullTrack['duration']) ? round($fullTrack['duration'] / 1000) : null,
            "genre" => $fullTrack['genre'] ?? null,
            "permalink" => "https://soundcloud.com/" . ($fullTrack['user']['permalink'] ?? "") . "/" . ($fullTrack['permalink'] ?? ""),
            "artwork" => isset($fullTrack['artwork_url']) ? str_replace("-large", "-t500x500", $fullTrack['artwork_url']) : (isset($fullTrack['user']['avatar_url']) ? str_replace("-large", "-t500x500", $fullTrack['user']['avatar_url']) : null),
            "streamUrl" => $streamUrl
        ];
    }

    $cover = isset($playlist["tracks"][0]['artwork_url']) ? str_replace("-large", "-t500x500", $playlist["tracks"][0]['artwork_url']) : (isset($playlist['user']['avatar_url']) ? str_replace("-large", "-t500x500", $playlist['user']['avatar_url']) : null);

    header('Content-Type: application/json');
    echo json_encode([
        "title" => $playlist['title'] ?? ($tracks[0]['title'] ?? 'SoundCloud'),
        "description" => $playlist['description'] ?? '',
        "artwork" => $cover,
        "profilePic" => (isset($playlist['user']['avatar_url']) ? str_replace("-large", "-t500x500", $playlist['user']['avatar_url']) : null),
        "author" => $playlist['user']['username'] ?? "Unknown User",
        "trackCount" => count($tracks),
        "tracks" => $tracks
    ]);
    exit;
}

// ---------- Download single track (direct streaming) ----------
if ($type === 'track' && isset($_GET['url'])) {
    $url = $_GET['url'];
    $title = $_GET['title'] ?? 'track';
    $safeTitle = safeFilename($title) . ".mp3";

    // Stream the remote file to the client
    header("Content-Type: audio/mpeg");
    header("Content-Disposition: attachment; filename=\"{$safeTitle}\"");

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HEADER => false,
        CURLOPT_BUFFERSIZE => 8192,
        CURLOPT_NOPROGRESS => false,
        CURLOPT_USERAGENT => "Mozilla/5.0"
    ]);
    $fp = fopen("php://output", "wb");
    if ($fp === false) {
        http_response_code(500);
        echo "Unable to open output stream.";
        exit;
    }
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    exit;
}


// Default: not found
http_response_code(404);
header('Content-Type: application/json');
echo json_encode(["error" => "Invalid request"]);
exit;
?>
