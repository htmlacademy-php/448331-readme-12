<?php

require_once('helpers.php');
require_once('functions.php');

if (isset($_SESSION['user']) && isset($_GET['post_id'])) {

	$sql = "SELECT id
			FROM post
			WHERE id = ?;";
	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, 'i', $_GET['post_id']);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
 	$post_exists = mysqli_fetch_all($res,  MYSQLI_ASSOC);
 	$post_exists = !empty($post_exists);

 	if ($post_exists) {
 		$sql = "INSERT INTO likes (user_id, post_id)
 				VALUES (?,?);";
 		$stmt = mysqli_prepare($con, $sql);
	 	mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_data']['id'], $_GET['post_id']);
	 	mysqli_stmt_execute($stmt);
	 	$refering_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "index.php";
		header("Location: $refering_page");
		exit();

 	}

} 

header("Location: index.php");
exit();

?>