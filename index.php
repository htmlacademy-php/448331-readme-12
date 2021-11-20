<?php

session_start();

require_once('helpers.php');
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$con = mysqli_connect("localhost", "mysql", "mysql", "readme", 3306);
mysqli_set_charset($con, "utf8");

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
   			$sql = "SELECT *
   				    FROM user
   				    WHERE login = ?;";
   			$stmt = mysqli_prepare($con, $sql);
   			mysqli_stmt_bind_param($stmt, 's', $authentication_data['login']);
   			mysqli_stmt_execute($stmt);
   			$res = mysqli_stmt_get_result($stmt);
   			$password = mysqli_fetch_array($res, MYSQLI_ASSOC);
   			if (empty($password['password'])) {
   				$errors['login'] = 'Пользователь с указанным именем не существует.';
   			} elseif (password_verify($authentication_data['password'], $password['password'])) {
   				$_SESSION['user'] = $authentication_data['login'];
   				$_SESSION['user_data'] = $password;
   				header("Location: feed.php");
   				exit();
   			} else {
   				$errors['password'] = 'Введенный вами пароль не соответствует логину.';
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