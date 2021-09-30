<?php
require_once('helpers.php');
require_once('functions.php');
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$con = mysqli_connect("localhost", "mysql", "mysql", "readme", 3306);
mysqli_set_charset($con, "utf8");


$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {     // если форма отправлена, а не первый раз открываем страницу
	$new_user_data = $_POST;
	define ('ALLOWED_MIME_IMAGE_TYPES', ['image/gif', 'image/jpeg', 'image/png']);
	$rules = [                                            
	  'email' => function($value, $con) {
	      return registration_email_validation($value, $con);
	  },
	  'login' => function($value, $con) {
	      return registration_login_validation($value, $con);
	  },
	  'password' => function($value) {
	      return registration_password_validation($value);
	  }
	];

    foreach ($new_user_data as $key => $value) {    // проверяем отправленную форму на соответствие правилам
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule($value, $con);
        }
    }

    if (!empty($_FILES['userpic-file']['name'])) {
      $tmp_name = $_FILES['userpic-file']['tmp_name'];
      if (in_array(mime_content_type($tmp_name), ALLOWED_MIME_IMAGE_TYPES)) {
      	 $path = 'img/'.$_FILES['userpic-file']['name'];
     	 move_uploaded_file($tmp_name, $path);
      	 $new_user_data['avatar'] = $_FILES['added-photo-file']['name'];
      } else {
      	$errors['image'] = 'Загруженное изображение имеет недопустимый формат.';
      }
    }

    $errors = array_filter($errors);

  if (!empty($errors)) {      // если были ошибки, загружаем страницу и показываем ошибки

    $page_content = include_template('registration.php', ['errors' => $errors]);
    print($page_content);
    exit();

  } else {
  	  $password = password_hash($new_user_data['password'], PASSWORD_DEFAULT);
	  $sql_user_add_query = "INSERT INTO user (registration_date, email, login, password, avatar)
	                         VALUES (NOW(), ?, ?, ?, ?)";
	  $stmt = mysqli_prepare($con, $sql_user_add_query);
	  mysqli_stmt_bind_param($stmt, 'ssss', $new_user_data['email'], $new_user_data['login'], $password, $new_user_data['avatar']);
	  $res = mysqli_stmt_execute($stmt);
	  if ($res && empty($errors)) {
	  header("Location: index.php");
	  exit();
  }
  }                  

}

$page_content = include_template('registration.php', ['errors' => $errors]);
print($page_content);

?>