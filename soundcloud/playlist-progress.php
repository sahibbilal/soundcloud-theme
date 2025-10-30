<?php
// ========== playlist-progress.php ==========
/*
This SSE endpoint streams the progress JSON file written by prepare-playlist.php.
It expects a GET param 'title' (the safe playlist title used by the frontend).
*/
// ========== (the file content continues below) ==========
// ========== playlist-progress.php ==========

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header("Access-Control-Allow-Origin: *");
header('X-Accel-Buffering: no'); // Disable nginx buffering if any
@ini_set('output_buffering', 'off');
@ini_set('zlib.output_compression', false);

// turn off output buffering
while (ob_get_level() > 0) ob_end_flush();
ob_implicit_flush(true);



$playlistTitle = isset($_GET['title']) ? $_GET['title'] : 'playlist';
$tmpDir = __DIR__ . "/tmp";
$progressFile = $tmpDir . "/" . $playlistTitle . ".json";

$lastData = null;
$start = time();
// Keep the connection alive until 'done' or timeout (e.g., 15 minutes)
$timeoutSeconds = 60 * 15;

while (true) {
    if (file_exists($progressFile)) {
        $data = @file_get_contents($progressFile);
        if ($data && $data !== $lastData) {
            // SSE requires each message to be prefixed with 'data:' and end with two newlines
            echo "data: {$data}\n\n";
            flush();
            $lastData = $data;

            $arr = json_decode($data, true);
            if (isset($arr['track']) && $arr['track'] === 'done') {
                break;
            }
        }
    }

    // break on timeout
    if ((time() - $start) > $timeoutSeconds) {
        echo "data: {\"error\":\"timeout\"}\n\n";
        flush();
        break;
    }

    usleep(250000); // 0.25s
}

// close event stream
exit;


