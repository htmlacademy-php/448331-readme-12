<?php
require_once('helpers.php');
require_once('functions.php');
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$con = mysqli_connect("localhost", "mysql", "mysql", "readme", 3306);
mysqli_set_charset($con, "utf8");

$sql_content_types_select = "SELECT id, type AS post_type, class AS post_class
                             FROM content_type;";
$content_types_array = mysqli_query($con, $sql_content_types_select);
$content_types = mysqli_fetch_all($content_types_array,  MYSQLI_ASSOC);

$active_form_type = 'text';
$errors = []; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {     // если форма отправлена, а не первый раз открываем страницу
  $post_data = $_POST;
  $active_form_type = $post_data['content-type'];
  define ('ALLOWED_IMAGE_TYPES', ['png', 'jpg', 'gif', 'image/gif', 'image/png', 'image/jpg']);


  $rules = [                                            
      'post-header' => function($value) {
          return not_empty_field($value);
      },
      'photo-link' => function($value) {
          return photo_link_validation($value);
      },
      'post-tag' => function($value) {
          return validate_tags($value);
      },
      'video-link' => function($value) {
          return video_link_validation($value);
      },
      'post-text' => function($value) {
          return not_empty_field($value);
      },
      'quote-author' => function($value) {
          return not_empty_field($value);
      }
  ];


  foreach ($post_data as $key => $value) {    // проверяем отправленную форму на соответствие правилам
      if (isset($rules[$key])) {
          $rule = $rules[$key];
          $errors[$key] = $rule($value);
      }
  }

  $errors = array_filter($errors);

  if (($active_form_type == 'photo') & empty($errors['photo-link'])) {

    if (!empty($_FILES['added-photo-file']['name']))  {   // работаем с файлом, проверяем , загружаем
                                                               
      $tmp_name = $_FILES['added-photo-file']['tmp_name'];
      $path = 'uploads/'.$_FILES['added-photo-file']['name'];
      move_uploaded_file($tmp_name, $path);
      $post_data['photo-link'] = $_FILES['added-photo-file']['name'];

    } else {      // или скачиваем файл по ссылке
                                                        
      $link = $post_data['photo-link'];
      $file_info = pathinfo($link);
      $file_path = "uploads/".$file_info['basename'];
      file_put_contents($file_path, $file);
      $post_data['photo-link'] = $file_path;
    }

  }

    

  if (!empty($errors)) {      // если были ошибки, загружаем страницу и показываем ошибки

    $page_content = include_template('post_add.php', ['content_type' => $content_types, 'active_form_type' => $active_form_type, 'errors' => $errors]);
    print($page_content);
    exit();

  }                     // если не было ошибок, добавляем записи в базу и переадресовываем на страницу поста

  $sql_add_query = "INSERT INTO post (post_date, post_header, post_content, quote_author, image, video, link, user_id, content_type)
               VALUES (NOW(), ?, ?, ?, ?, ?, ?, 1, ?)";
  $stmt = mysqli_prepare($con, $sql_add_query);
  mysqli_stmt_bind_param($stmt, 'sssssss', $post_data['post-header'], $post_data['post-text'], $post_data['quote-author'], $post_data['photo-link'], $post_data['video-link'], $post_data['post-link'], $post_data['content-id']);
    mysqli_stmt_execute($stmt);
    $new_post_id = mysqli_insert_id($con);

   $tags =  explode (' ', $post_data['post-tag']);

  foreach ($tags as $tag_name) {
    add_hashtag($tag_name, $con, $new_post_id);
  }

  header("Location: post.php?post_id=" . $new_post_id);
  exit();

} else {
  $page_content = include_template('post_add.php', ['content_type' => $content_types, 'active_form_type' => $active_form_type, 'errors' => $errors]);
  print($page_content);
}
?>