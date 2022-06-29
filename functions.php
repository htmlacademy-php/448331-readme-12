<?php

/**
 * Проверяет тип загруженной фотографии
 * @param array $value Массив с данными файла
 *
 * @return string Ошибку, если валидация не пройдена
 */
function added_photo_validation ($value) {
  if ($file_type !== 'image/gif' || $file_type !== 'image/png' || $file_type !== 'image/jpeg') {
    return 'Пожалуйста, загрузите картинку в формате Gif, PNG или JPEG';
  }
  return null;
}

/**
 * Проверяет корректность ссылки на видео
 * @param string $value Строка с адресом ссылки
 *
 * @return string Ошибку, если валидация не пройдена
 */
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

/**
 * Проверяет поле формы на заполненность
 * @param string $value Данные поля формы
 *
 * @return string Ошибку, если поле пустое
 */
function not_empty_field($value) {
    if (empty($value)) {
        return 'Поле должно быть заполнено';
    }
    return null;
}


/**
 * Валидация хеш тэга
 * @param string $value Хэш тэг
 *
 * @return string Ошибку, если поле пустое либо хэш тег не корректен
 */
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

/**
 * Валидация хеш тэга
 * @param string $value Хэш тэг
 *
 * @return string Ошибку, если поле пустое либо хэш тег не корректен
 */
function getPostVal($name) {
    if (isset($_POST[$name])) {
        return $_POST[$name];
    } else {
        return "";
    }
}

/**
 * Проверяет наличие ошибок валидации заполненного поля формы
 * @param string $value Имя поля формы
 *
 * @return string Текст ошибки валидации, если она есть
 */
function is_error_field ($value) {
    if (empty($value)) {
        return null;
    } else {
        return 'form__input-section--error';
    }
}

/**
 * Добавляет класс (делает активной) кнопку с выбранным типом добавляемого контента
 * @param string $value1 Тип контента кнопки-фильтра
 * @param string $value2 Тип контента поста, который добавляем
 *
 * @return string Класс для активной кнопки выбора типа добавляемого поста
 */
function is_active_form ($value1, $value2) {
    if ($value1 == $value2) {
        return 'filters__button--active tabs__item--active';
    }
}

/**
 * Добавляет в базу данных привязанные к посту хеш теги
 * @param string $tag_name Имя хеш тега
 * @param string $con Ресурс соединения с базой данных
 * @param string $new_post_id Id нового поста, к которому добавляем хеш теги
 *
 * @return string Класс для активной кнопки выбора типа добавляемого поста
 */
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

        if ($login_exist[0]) {
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

function post_date_ago(string $input_date) {
    $post_date_obj = date_create($input_date);
    $current_date = date_create("now");
    $date_interval = date_diff($current_date, $post_date_obj);
    $date_diff_unix = strtotime(date_interval_format($date_interval, '%Y-%M-%D %H:%I'));
    define("WEEK", '7');
    switch (true) {
        case ($date_diff_unix < strtotime('00-00-00 01:00')):
            $posted_time_ago = date_interval_format($date_interval, '%i');
            $plural_form = get_noun_plural_form($posted_time_ago, 'минута', 'минуты', 'минут');
            break;
        case ($date_diff_unix < strtotime('00-00-01 00:00')):
            $posted_time_ago = date_interval_format($date_interval, '%h'); 
            $plural_form = get_noun_plural_form($posted_time_ago, 'час', 'часа', 'часов');
            break;
        case ($date_diff_unix < strtotime('00-00-07 00:00')):
            $posted_time_ago = date_interval_format($date_interval, '%d'); 
            $plural_form = get_noun_plural_form($posted_time_ago, 'день', 'дня', 'дней');
            break;
        case ($date_diff_unix < strtotime('00-01-00 00:00')):
            $posted_time_ago = ceil(date_interval_format($date_interval, '%a') / WEEK); 
            $plural_form = get_noun_plural_form($posted_time_ago, 'неделя', 'недели', 'недель');
            break;
        default:
            $posted_time_ago = date_interval_format($date_interval, '%m'); 
            $plural_form = get_noun_plural_form($posted_time_ago, 'месяц', 'месяца', 'месяцев');
            break;
    }
    return "$posted_time_ago"." $plural_form"." назад";
}

function hashtag_list($post_id, $con) {
    $sql = "SELECT hashtag_name
            FROM tag_in_post
            JOIN hashtag ON tag_in_post.tag_id = hashtag.id
            WHERE tag_in_post.post_id = ?;";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $linked_tags = mysqli_fetch_all($res, MYSQLI_NUM);
    return $linked_tags;
}

function post_comments_list($post_id, $con) {
    $sql = "SELECT comment.comment_content AS comment, comment_date, avatar, login, user.id AS id
            FROM comment
            JOIN post ON comment.post_id = post.id
            JOIN user ON comment.user_id = user.id
            WHERE comment.post_id = ?;";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $comments_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $comments_list;
}

function string_reduce(string $string_to_cut, int $string_length = 300) {
    if (mb_strlen($string_to_cut) <= $string_length) {
        return $string_to_cut;
    }
    $article_array = explode(' ', $string_to_cut); // разбиваем строку на массив слов
    $i = 0;
    while (mb_strlen($resulted_string) < $string_length) {
        $resulted_string .= ' '.$article_array[$i];
        $i++;
    }
    return $resulted_string.'...';
}

function user_id_exists_in_db($con, int $user_id) {
    $sql = "SELECT COUNT(*)
            FROM user
            WHERE id = ?;";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user_exists = mysqli_fetch_row($res);

    return isset($user_exists[0]) && $user_exists[0] > 0;
}

?>