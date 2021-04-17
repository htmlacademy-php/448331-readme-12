<?php
require_once('helpers.php');
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$con = mysqli_connect("localhost", "mysql", "mysql", "readme", 3306);
mysqli_set_charset($con, "utf8");

$post_id = $_GET['post_id'];

$sql_post_content = "SELECT post_header AS header, class AS type, post_content AS content, login AS user_name, avatar, post_date, link, image, post.id, user_id
                    FROM post
                    JOIN user ON post.user_id = user.id
                    JOIN content_type ON post.content_type = content_type.id
                    WHERE post.id = $post_id;";

$sql_array = mysqli_query($con, $sql_post_content);

if (!mysqli_num_rows($sql_array)) {
  http_response_code(404);
} else {
  $post_content_array = mysqli_fetch_assoc($sql_array);
  $user_id = $post_content_array['user_id'];

  $sql_subscribers_amount = "SELECT COUNT(*)
                             FROM subscription
                             WHERE author_id = $user_id;";
  $sql_array = mysqli_query($con, $sql_subscribers_amount);
  $subscribers_amount = mysqli_fetch_row($sql_array);

  $sql_publications_amount = "SELECT COUNT(*)
                              FROM post
                              WHERE user_id = $user_id;";
  $sql_array = mysqli_query($con, $sql_publications_amount);
  $publications_amount = mysqli_fetch_row($sql_array);

  $detailed_post_content = include_template('post_details_'.$post_content_array['type'].'_block.php', ['post_array' => $post_content_array]);
  $page_content = include_template('post_view.php', ['post_content' => $post_content_array, 'inner_content' => $detailed_post_content, 'subscribers_amount' => $subscribers_amount, 'publications_amount' => $publications_amount]);
  print($page_content);
}
?>


