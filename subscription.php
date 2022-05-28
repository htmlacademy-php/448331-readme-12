<?php

require_once('helpers.php');
require_once('functions.php');
require_once('mailer.php');

if (isset($_SESSION['user']) && isset($_GET['action'])) {

	$sql = "SELECT id, email, login
      	    FROM user
            WHERE id = ?;";
    $stmt = mysqli_prepare($con, $sql);
 	mysqli_stmt_bind_param($stmt, 'i', $_GET['user_id']);
 	mysqli_stmt_execute($stmt);
 	$res = mysqli_stmt_get_result($stmt);
 	$user_exists = mysqli_fetch_all($res,  MYSQLI_ASSOC);

	if (isset($_GET['action']) && ($_GET['action'] == 'subscribe') && !empty($user_exists)) {

	 	$sql = "INSERT INTO subscription (subscriber_id, author_id)
	            VALUES  (?,?);";
	    $stmt = mysqli_prepare($con, $sql);
	 	mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_data']['id'], $_GET['user_id']);
	 	mysqli_stmt_execute($stmt);

	 	$message = new Email();
        $message->to($user_exists[0]['email']);
        $message->from("info@readme.net");
        $message->subject("У вас новый подписчик");
        $message->text("Здравствуйте, ".$user_exists[0]['login'].". На вас подписался новый пользователь ".$_SESSION['user'].". Вот ссылка на его профиль: \profile.php?user_id=".$_SESSION['user_data']['id']);
        $mailer = new Mailer($mail_transport);
        $mailer->send($message);


	} elseif (isset($_GET['action']) && ($_GET['action'] == 'unsubscribe') && !empty($user_exists)) {
		$sql = "DELETE FROM subscription
	 			WHERE subscriber_id = ? AND author_id = ?;";
	    $stmt = mysqli_prepare($con, $sql);
	 	mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_data']['id'], $_GET['user_id']);
	 	mysqli_stmt_execute($stmt);
	}


	$refering_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "index.php";	
	header("Location: $refering_page");
	exit();

}

header("Location: index.php");
exit();

?>