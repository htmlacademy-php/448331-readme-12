<?php

require_once('helpers.php');
require_once('functions.php');
require_once('mailer.php');

if (isset($_SESSION['user'])) {

	$user_id = $_SESSION['user_data']['id'];
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$_SESSION['chat_message_error'] = "";

		if (user_id_exists_in_db($con, $_POST['recipient_id']) && ($_POST['recipient_id'] !== $user_id)){

			$message_text = trim($_POST['message']);
			$len = mb_strlen($message_text);
			if (empty($len)) {
				$_SESSION['chat_message_error'] = 'Сообщение не может быть пустым';
			} else {
				$sql = "INSERT INTO message (message_content, sender_id, recipient_id)
						VALUES (?,?,?);";
				$stmt = mysqli_prepare($con, $sql);
				mysqli_stmt_bind_param($stmt, 'sii', $_POST['message'], $_SESSION['user_data']['id'], $_POST['recipient_id']);
				mysqli_stmt_execute($stmt);
			}

			$return_page = "Location: messages.php?chat_mate_id=".$_POST['recipient_id'];
			header("Location: $return_page");
			exit();
		}
	}

	$chat_mate_id = $_GET['chat_mate_id'];
	$is_new_chat = true;

	$sql = "SELECT login, avatar, user.id AS user_id
			FROM user
			LEFT JOIN message
			ON message.sender_id = user.id OR message.recipient_id = user.id
			WHERE NOT user.id = ? AND (message.recipient_id = ? OR message.sender_id = ?) 
			GROUP BY login;";

	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, 'iii', $user_id, $user_id, $user_id);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$chat_mates_array = mysqli_fetch_all($res,  MYSQLI_ASSOC);

	if (!empty($chat_mates_array )) {

		foreach ($chat_mates_array as $index => $chat_mate) {

			if ($chat_mate['user_id'] == $chat_mate_id) {
				$is_new_chat = false;
			}

			$sql = "SELECT message_content AS message, message_date, sender_id
					FROM message
					WHERE (recipient_id = ? AND sender_id = ?) OR (recipient_id = ? AND sender_id = ?)
					ORDER BY message_date DESC
					LIMIT 1;";

			$stmt = mysqli_prepare($con, $sql);
			mysqli_stmt_bind_param($stmt, 'iiii', $user_id, $chat_mate['user_id'], $chat_mate['user_id'], $user_id);
			mysqli_stmt_execute($stmt);
			$res = mysqli_stmt_get_result($stmt);
			$last_message_data = mysqli_fetch_assoc($res);

			$chat_mates_array[$index]['last_message'] = $last_message_data['message'];
			$chat_mates_array[$index]['last_message_date'] = $last_message_data['message_date'];
			$chat_mates_array[$index]['last_message_author_id'] = $last_message_data['sender_id'];

			$sql = "SELECT COUNT(id) AS amount
					FROM message
					WHERE is_read = 0 AND (recipient_id = ? AND sender_id = ?)
					GROUP BY is_read;";

			$stmt = mysqli_prepare($con, $sql);
			mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_data']['id'], $chat_mate['user_id']);
			mysqli_stmt_execute($stmt);
			$res = mysqli_stmt_get_result($stmt);
			$unread_new_messages_amount = mysqli_fetch_assoc($res);
			$chat_mates_array[$index]['new_messages_amount'] = $unread_new_messages_amount['amount'];
		}
	}

	if ($is_new_chat) {
		$sql = "SELECT login, avatar, id AS user_id
				FROM user
				WHERE id = ?;";

		$stmt = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($stmt, 'i', $chat_mate_id);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$new_chat_mate_array = mysqli_fetch_assoc($res);
		$chat_mates_array[] = $new_chat_mate_array;
	}

	$sql = "SELECT message_date, message_content, is_read, user.id AS user_id, user.avatar AS avatar, user.login AS user
			FROM message
			JOIN user
			ON message.sender_id = user.id
	        WHERE (recipient_id = ? AND sender_id = ?) OR (recipient_id = ? AND sender_id = ?)
	        ORDER BY message_date ASC;";

	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, 'iiii', $user_id, $chat_mate_id, $chat_mate_id, $user_id);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$chat_messages_array = mysqli_fetch_all($res,  MYSQLI_ASSOC);

	$page_content = include_template('messages_template.php', ['chat_messages_array' => $chat_messages_array, 'chat_mates_data' => $chat_mates_array, 'chat_mate_id' => $chat_mate_id, 'is_new_chat' => $is_new_chat]);
	$layout_content = include_template('layout.php', ['page_content' => $page_content, 'page_title' => 'readme: личные сообщения']);
	print($layout_content);
	exit();
}
header("Location: /");
exit();

?>