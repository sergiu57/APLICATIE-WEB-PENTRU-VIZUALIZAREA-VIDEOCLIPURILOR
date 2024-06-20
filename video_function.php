<?php
include('functions.php');
// (A) HELPER FUNCTION - SERVER RESPONSE
function verbose ($ok=1, $info="") {
  if ($ok==0) { http_response_code(400); }
  exit(json_encode(["ok"=>$ok, "info"=>$info]));
}

if (empty($_FILES) || $_FILES["file"]["error"]) {
  verbose(0, "Failed to move uploaded file.");
}

$uniqid = uniqid();
$filePath = "videoclipuri/" . $uniqid;
mkdir($filePath, 0777);
$titlu = "Videoclip fara titlu";
date_default_timezone_set('Europe/Bucharest');
$data = date("d-m-Y H:i", strtotime('now'));
$id_creator = $_SESSION['simvideo_user']['id'];

$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
$tip = "fara_restrictie";
$sql = "INSERT INTO videoclipuri (uniqid, titlu, video, data, id_creator, tip) VALUES ('$uniqid', '$titlu', '$fileName', '$data', '$id_creator', '$tip')";
mysqli_query($db, $sql);

$filePath = $filePath . DIRECTORY_SEPARATOR . $fileName;

$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
if ($out) {
  $in = @fopen($_FILES["file"]["tmp_name"], "rb");
  if ($in) { while ($buff = fread($in, 4096)) { fwrite($out, $buff); } }
  else { verbose(0, "Failed to open input stream"); }
  @fclose($in);
  @fclose($out);
  @unlink($_FILES["file"]["tmp_name"]);
} else { verbose(0, "Failed to open output stream"); }

if (!$chunks || $chunk == $chunks - 1) { rename("{$filePath}.part", $filePath); }
verbose(1, "Upload OK");