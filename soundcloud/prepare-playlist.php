<?php
// ========== prepare-playlist.php ==========
// prepare-playlist.php
// Fixed version: writes incremental progress, calculates percent, streams to temp files (no large memory usage), creates ZIP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// echo sys_get_temp_dir();
// exit;

session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') exit;

set_time_limit(0);
ignore_user_abort(true);

// Get CLIENT_ID from WordPress REST API
function getClientIdFromAPI() {
    // Detect WordPress site URL from current request
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    
    // Extract base path (remove /wp-content/themes/sound-cloud-theme/soundcloud/prepare-playlist.php)
    $basePath = str_replace('/wp-content/themes/sound-cloud-theme/soundcloud/prepare-playlist.php', '', $script);
    $basePath = str_replace('/soundcloud/prepare-playlist.php', '', $basePath);
    $basePath = rtrim($basePath, '/');
    
    $apiUrl = $protocol . $host . $basePath . '/wp-json/soundcloud/v1/client-id';
    
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_USERAGENT => "Mozilla/5.0"
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200 && $response) {
        $data = json_decode($response, true);
        if (isset($data['client_id']) && !empty($data['client_id'])) {
            return $data['client_id'];
        }
    }
    
    // Return null if API fails or CLIENT_ID is not set
    return null;
}

$CLIENT_ID = getClientIdFromAPI();

// Validate CLIENT_ID
if (empty($CLIENT_ID)) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(["error" => "SoundCloud Client ID is not configured. Please set it in WordPress admin: Appearance → SoundCloud Settings"]);
    exit;
}

function safeFilename($name){
    return preg_replace('/[^a-zA-Z0-9\-]/', '_', trim($name));
}

function fetchJson($url){
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => "Mozilla/5.0",
        CURLOPT_TIMEOUT => 20
    ]);
    $resp = curl_exec($ch);
    curl_close($ch);
    return $resp ? json_decode($resp, true) : null;
}

function getStreamUrl($trackId, $clientId){
    $track = fetchJson("https://api-v2.soundcloud.com/tracks/{$trackId}?client_id={$clientId}");
    if(!$track || !isset($track['media']['transcodings'])) return null;
    foreach($track['media']['transcodings'] as $t){
        $mime = $t['format']['mime_type'] ?? '';
        $proto = $t['format']['protocol'] ?? '';
        if($mime === 'audio/mpeg' && $proto === 'progressive'){
            $data = fetchJson($t['url'] . "?client_id={$clientId}");
            return $data['url'] ?? null;
        }
    }
    return null;
}

// Read input
$input = json_decode(file_get_contents('php://input'), true);
$data = $input['data'] ?? null;
if(!$data || empty($data['tracks'])){
    http_response_code(400);
    echo json_encode(["error" => "Invalid playlist data"]);
    exit;
}

// $playlistTitle = safeFilename($data['title'] ?? 'playlist');
$playlistTitle = $data['title'] ?? 'playlist';

// --- Set up working temp folder ---
$tmpDir = __DIR__ . "/tmp";
if (!is_dir($tmpDir)) mkdir($tmpDir, 0777, true);
chmod($tmpDir, 0777);
$tmpZip = $tmpDir . "/" . "{$playlistTitle}.zip";

if (!is_writable($tmpDir)) {
    http_response_code(500);
    echo json_encode(["error" => "Temp directory not writable: $tmpDir"]);
    exit;
}

$tmpZip = $tmpDir . "/" . "{$playlistTitle}.zip";
$progressFile = $tmpDir . "/" . $playlistTitle . ".json";

// Initialize progress file
file_put_contents($progressFile, json_encode([
    'track' => null,
    'current' => 0,
    'total' => count($data['tracks']),
    'percent' => 0
]));

// --- Create ZIP safely ---
$zip = new ZipArchive();
$openResult = $zip->open($tmpZip, ZipArchive::CREATE | ZipArchive::OVERWRITE);
// var_dump($openResult);
// var_dump($tmpZip);
// exit;
if ($openResult !== true) {
    echo "<b>ZipArchive open failed</b> code: $openResult<br>path: $tmpZip";
    exit;
}
if ($openResult !== true) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to create zip file at: $tmpZip (code $openResult)"]);
    exit;
}


$totalTracks = count($data['tracks']);

foreach($data['tracks'] as $i => $track){
    $title = $track['title'] ?? "track_" . ($i+1);
    $trackId = $track['id'] ?? null;
    if(!$trackId) continue;

    $streamUrl = getStreamUrl($trackId, $CLIENT_ID);
    if(!$streamUrl) continue;

    $safeName = safeFilename($title) . ".mp3";
    $tmpFile = $tmpDir . '/' . uniqid('scdl_', true) . '.mp3';
    $fp = fopen($tmpFile, 'w');
    if(!$fp) continue;

    // Attempt to get content length via HEAD
    $chHead = curl_init($streamUrl);
    curl_setopt_array($chHead, [
        CURLOPT_NOBODY => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => "Mozilla/5.0",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 15
    ]);
    curl_exec($chHead);
    $contentLength = curl_getinfo($chHead, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    curl_close($chHead);

    // Keep counters for progress
    $downloaded = 0;
    $lastPercent = 0;

    $ch = curl_init($streamUrl);
    curl_setopt_array($ch, [
        CURLOPT_FILE => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => "Mozilla/5.0",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_BUFFERSIZE => 8192,
        CURLOPT_NOPROGRESS => false,
        CURLOPT_PROGRESSFUNCTION => function($resource, $download_size, $downloaded_now, $upload_size, $upload_now) use (&$downloaded, $contentLength, $title, $i, $totalTracks, $progressFile, &$lastPercent) {
            // some versions pass different args; use second/third args
            $downloaded = $downloaded_now;
            $percent = 0;
            if($contentLength && $contentLength > 0){
                $percent = (int) round(($downloaded / $contentLength) * 100);
            }
            // Only write progress if percent changed (reduces IO)
            if($percent !== $lastPercent){
                $lastPercent = $percent;
                @file_put_contents($progressFile, json_encode([
                    'track' => $title,
                    'current' => $i+1,
                    'total' => $totalTracks,
                    'percent' => $percent
                ]));
            }
        }
    ]);

    // Execute download
    $success = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    fclose($fp);

    // Add to zip (use basename so zip structure is clean)
    if($success && file_exists($tmpFile)){
        $zip->addFile($tmpFile, $safeName);
    }

    // Update progress to 100% for this track (in case HEAD didn't provide length)
    @file_put_contents($progressFile, json_encode([
        'track' => $title,
        'current' => $i+1,
        'total' => $totalTracks,
        'percent' => 100
    ]));

    // small sleep to allow SSE readers to pick up
    usleep(150000);

    // cleanup temp file
    // if(file_exists($tmpFile)) @unlink($tmpFile);
}

$zip->close();
if(!file_exists($tmpZip)){
    error_log("ZIP file not created: $tmpZip");
}

// final progress -> include zip filename so frontend can request it
file_put_contents($progressFile, json_encode([
    'track' => 'done',
    'current' => $totalTracks,
    'total' => $totalTracks,
    'percent' => 100,
    'zip' => basename($tmpZip)
]));

echo json_encode(["success" => true, "zip" => basename($tmpZip)]);
exit;

?>
