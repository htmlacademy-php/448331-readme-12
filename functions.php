<?php

function added_photo_validation ($value) {
  if ($file_type !== 'image/gif' || $file_type !== 'image/png' || $file_type !== 'image/jpeg') {
    return 'Пожалуйста, загрузите картинку в формате Gif, PNG или JPEG';
  }
  return null;
}

function video_link_validation ($value) {
    if (empty($value)) {
        return 'Адрес ссылки на видео должен быть заполнен';
    }
    if (!filter_var($value, FILTER_VALIDATE_URL)) {
        return 'Пожалуйста, проверьте и введите корректный адрес ссылки';
    }
    $result = check_youtube_url($value);
    if ($result !== true) {
        return $result;
    }
    return NULL;
}


function photo_link_validation ($value) {
    if (!empty($_FILES['added-photo-file']['name'])) {               // работаем с файлом, проверяем , загружаем
      $tmp_name = $_FILES['added-photo-file']['tmp_name'];
      $path = 'uploads/'.$_FILES['added-photo-file']['name'];
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $file_type = finfo_file($finfo, $tmp_name);
        if (!in_array($file_type, ALLOWED_IMAGE_TYPES)) {
        return 'Загрузите картинку в допустимом формате';
       } else {
        return null;
       }
    }

    if (empty($value)) {
        return 'Адрес ссылки должен быть заполнен';
    }
    if (!filter_var($value, FILTER_VALIDATE_URL)) {
        return 'Введите корректный адрес ссылки';
    }

    $link = $value;
    $file_info = pathinfo($link);

    if (!in_array($file_info['extension'], ALLOWED_IMAGE_TYPES)) {
        return 'Недопустимый формат изображения';
    } elseif (!file_get_contents($link)) {
        return "Не удалось скачать изображение";
    } 
    return null;
}

function not_empty_field($value) {
    if (empty($value)) {
        return 'Поле должно быть заполнено';
    }
    return null;
}


function validate_tags($value): ?string {             // функция валидации тегов
    if (empty($value)) {
        return 'Поле должно быть заполнено';
    }

    $tag_array = array_filter(explode(' ', $value));

    foreach ($tag_array as $tag) {
        if (!boolval(preg_match('/^[a-zA-Zа-яёА-ЯЁ0-9_]+$/u', $tag))) {
            return 'Введите корректный тег';
        }
    }

    return null;
}

function getPostVal($name) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    } else {
        return "";
    }
}

function is_error_field ($value) {
    if (empty($value)) {
        return null;
    } else {
        return 'form__input-section--error';
    }
}

function is_active_form ($value1, $value2) {
    if ($value1 == $value2) {
        return 'filters__button--active tabs__item--active';
    }
}

function add_hashtag ($tag_name, $con, $new_post_id) {
    $sql = "SELECT id
            FROM hashtag
            WHERE hashtag_name LIKE ?;"; // возможно надо like
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $tag_name);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $hashtag_id = mysqli_fetch_row($res);

    if (!$hashtag_id) {
        $sql = "INSERT INTO hashtag (hashtag_name)
                VALUES (?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 's', $tag_name);
        mysqli_stmt_execute($stmt);
        $hashtag_id = mysqli_insert_id($con);
    }

    $sql = "INSERT INTO tag_in_post (tag_id, post_id)
                 VALUES ( ?, ?);";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $hashtag_id, $new_post_id);
    mysqli_stmt_execute($stmt);
}

function registration_email_validation ($email, $con) {
    if (empty($email)) {
        return 'Поле должно быть заполнено';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Вы ввели некорректный e-mail адрес';
    } else {
        $sql = "SELECT id
                FROM user
                WHERE email = ?;";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) > 0) {
            return 'Пользователь с этим email уже зарегистрирован';
    }
    }
    return null;
}

function registration_login_validation ($login, $con) {
    if (!empty($login)) {
        $sql = "SELECT COUNT(*)
                FROM user
                WHERE login = ?;";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 's', $login);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $login_exist = mysqli_fetch_row($res);

        if ($login_exist) {
        return 'Пользователь с этим именем уже зарегистрирован';
        }
    return null;
    } else {
        return 'Поле с именем пользователя должно быть заполнено';
    }
}

function registration_password_validation ($password) {
    if (!empty($password) && !empty($_POST['password-repeat'])) {
        if ($password !== $_POST['password-repeat']) {
            return 'Пароли не совпадают';
        } else {
            return null;
        }
    } else {
        return 'Оба поля с паролем должны быть заполнены';
    }
}

?>