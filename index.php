<?php

require_once('helpers.php');

if (!isset($_SESSION['user'])) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
		$authentication_data = $_POST;
		$errors = [];
		$required = ['login', 'password'];

		foreach ($required as $field) {
		    if (empty($authentication_data[$field])) {
		        $errors[$field] = 'Это поле необходимо заполнить';
	        }
   		}
   		if (empty($errors)) {
   			$sql = "SELECT id, login, password, avatar
   				    FROM user
   				    WHERE login = ?
   				    LIMIT 1;";
   			$stmt = mysqli_prepare($con, $sql);
   			mysqli_stmt_bind_param($stmt, 's', $authentication_data['login']);
   			mysqli_stmt_execute($stmt);
   			$res = mysqli_stmt_get_result($stmt);
   			$user_data = mysqli_fetch_array($res, MYSQLI_ASSOC);
   			if (empty($user_data['password'])) {
   				$errors['login'] = 'Вы ввели неверное имя пользователя или пароль.';
   			} elseif (password_verify($authentication_data['password'], $user_data['password'])) {
   				$_SESSION['user'] = $authentication_data['login'];
   				$_SESSION['user_data'] = $user_data;
   				header("Location: feed.php");
   				exit();
   			} else {
   				$errors['password'] = 'Вы ввели неверное имя пользователя или пароль';
   			}
   		}
	} else {
		$page_content = include_template('login.php', ['errors' => $errors]);
		print($page_content);	
	}

} else {
	header("Location: feed.php");
	exit();
}



?>