<?php

require_once('helpers.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user']) && isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {  //проверяем залогинены или нет и есть ли ID пользователя

	$_SESSION['post_comment_error'] = "";

	$sql = "SELECT id, user_id
			FROM post
			WHERE id = ?;";
	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, 'i', $_POST['post_id']);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$result = mysqli_fetch_array($res, MYSQLI_ASSOC);
	$post_exists = !empty($result);

	$comment_text = trim($_POST['comment_text']);
	$len = mb_strlen($comment_text);

	if ($len > 3) {
		if ($post_exists) {
			$sql = "INSERT INTO comment (comment_content, user_id, post_id)
					VALUES (?,?,?);";
			$stmt = mysqli_prepare($con, $sql);
			mysqli_stmt_bind_param($stmt, 'sii', $_POST['comment_text'], $_SESSION['user_data']['id'], $_POST['post_id']);
			$comment_added = mysqli_stmt_execute($stmt);

			$return_page = "profile.php?user_id=".$result['user_id'];
			header("Location: $return_page");
			exit();
		}
	} else {
		$_SESSION['post_comment_error'] = 'Комментарий не должен быть пустым или быть короче четырех символов';
		$return_page = $_SERVER['HTTP_REFERER'];
		header("Location: $return_page");
		exit();
	}
}

header("Location: index.php");
exit();

?>