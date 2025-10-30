<?php
// ========== download-playlist.php ==========
// download-playlist.php
session_start();
header("Access-Control-Allow-Origin: *");

// Accept 'file' param (basename of zip) for compatibility with the frontend
$file = isset($_GET['file']) ? basename($_GET['file']) : null;
if(!$file){
    http_response_code(400);
    echo "Missing file parameter";
    exit;
}

// $tmpZip = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $file;
$tmpDir = __DIR__ . "/tmp";
$tmpZip = $tmpDir . "/" . $file;

if(!file_exists($tmpZip)){
    http_response_code(404);
    echo "File not found";
    exit;
}

// Force download
header('Content-Description: File Transfer');
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($tmpZip));

// Stream the file
$fp = fopen($tmpZip, 'rb');
if ($fp) {
    while (!feof($fp)) {
        echo fread($fp, 8192);
        flush();
    }
    fclose($fp);
}
exit;
?>
