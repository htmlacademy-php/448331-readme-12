<?php

require_once('helpers.php');
require_once('functions.php');



if (isset($_SESSION['user']) && isset($_GET['action'])) {

	$sql = "SELECT id 
      	    FROM user
            WHERE id = ?;";
    $stmt = mysqli_prepare($con, $sql);
 	mysqli_stmt_bind_param($stmt, 'i', $_GET['user_id']);
 	mysqli_stmt_execute($stmt);
 	$res = mysqli_stmt_get_result($stmt);
 	$user_exists = mysqli_fetch_all($res,  MYSQLI_ASSOC);
 	$user_exists = !empty($user_exists);

	if (($_GET['action'] == 'subscribe') && ($user_exists)) {

	 	$sql = "INSERT INTO subscription (subscriber_id, author_id)
	            VALUES  (?,?);";
	    $stmt = mysqli_prepare($con, $sql);
	 	mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_data']['id'], $_GET['user_id']);
	 	mysqli_stmt_execute($stmt);


	} elseif (($_GET['action'] == 'unsubscribe') && ($user_exists)) {
		$sql = "DELETE FROM subscription
	 			WHERE subscriber_id = ? AND author_id = ?;";
	    $stmt = mysqli_prepare($con, $sql);
	 	mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_data']['id'], $_GET['user_id']);
	 	mysqli_stmt_execute($stmt);
	}


	$refering_page = $_SERVER['HTTP_REFERER'];	
	header("Location: $refering_page");
	exit();

} 

header("Location: index.php");
exit();

?>