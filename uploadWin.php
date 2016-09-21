<?php

$datas = json_decode(file_get_contents('php://input'));
$name = addslashes($datas[0]);

$server = "localhost";
$user = "sudoku";
include("../../sudokupw.php"); //password file
$conn = new mysqli($server, $user, $pw, "sudoku");

if ($name != "") {
	$sql = "INSERT INTO leaderboard (name) VALUES ('". $name ."')";
	$results = mysqli_query($conn, $sql);
	if (!$results) {
		echo mysqli_error($conn);
	}
}
$sql = "SELECT * FROM leaderboard";
$results = mysqli_query($conn, $sql);
if (!$results) {
	echo mysqli_error($conn);
}

$leaderboard = array();
while ($row = mysqli_fetch_assoc($results)) {
	array_push($leaderboard, array($row['name'], $row['timestamp']));
}


echo json_encode($leaderboard);
?>