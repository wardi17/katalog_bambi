<?php
// proxy.php?id=1eMlayPh1HGPZmsjydLGc5PUvSVCz8GVf
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) exit('Missing file ID');

$url = "https://drive.google.com/uc?export=download&id=" . $id;

// Set header streaming
header("Content-Type: video/mp4");
header("Content-Disposition: inline; filename=\"video.mp4\"");
readfile($url);
?>
