<?php
include('functions.php');

$uniqid = $_GET['uniqid'];
$duration = $_POST['video_duration'];

$hours = floor($duration / 3600);
$minutes = floor(($duration / 60) - ($hours * 60));
if($hours > 0){
	$seconds = floor($duration - (($minutes * 60) + ($hours * 3600)));
}else{
	$seconds = floor($duration - ($minutes * 60));
}
if($hours > 0){
	if($minutes > 9){
		if($seconds > 9){
			$video = $hours . ":" . $minutes . ":" . $seconds;
		}else{
			$video = $hours . ":" . $minutes . ":0" . $seconds;
		}
	}else{
		if($seconds > 9){
			$video = $hours . ":0" . $minutes . ":" . $seconds;
		}else{
			$video = $hours . ":0" . $minutes . ":0" . $seconds;
		}
	}
}else{
	if($minutes > 9){
		if($seconds > 9){
			$video = $minutes . ":" . $seconds;
		}else{
			$video = $minutes . ":0" . $seconds;
		}
	}else{
		if($seconds > 9){
			$video = "0" . $minutes . ":" . $seconds;
		}else{
			$video = "0" . $minutes . ":0" . $seconds;
		}
	}
}

$sql1 = "UPDATE videoclipuri SET durata = '$video' WHERE uniqid = '$uniqid'";
mysqli_query($db, $sql1);