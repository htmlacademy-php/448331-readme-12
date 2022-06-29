<?php

require_once('helpers.php');
require_once('functions.php');
require_once('mailer.php');

$post_exists = 0;

if (isset($_SESSION['user'])) {
    if (is_numeric($_GET['post_id'])) {
      $post_id = $_GET['post_id'];
      $sql_post_content = "SELECT post_header AS header, class AS type, post_content AS content, login AS user_name, avatar, post_date, link, image, post.id, post.user_id AS user_id, COUNT(likes.post_id) AS likes_amount, COUNT(comment.id) AS comments_amount, post.view_count AS view_count
                            FROM post
                            JOIN user ON post.user_id = user.id
                            LEFT JOIN likes ON post.id = likes.post_id
                            LEFT JOIN comment ON post.id = comment.post_id
                            JOIN content_type ON post.content_type = content_type.id
                            WHERE post.id = ?
                            GROUP BY post.id;";

      $stmt = mysqli_prepare($con, $sql_post_content);// пробная часть с подготовленными выражениями
      mysqli_stmt_bind_param($stmt, 'i', $post_id);
      mysqli_stmt_execute($stmt);
      $res = mysqli_stmt_get_result($stmt);
      $post_exists = mysqli_num_rows($res);
    }

    if (!$post_exists) {
      http_response_code(404);
      exit;
    } else {
      $post_content_array = mysqli_fetch_assoc($res);
      $post_content_array['comments'] = post_comments_list($post_content_array['id'], $con);
      $user_id = $post_content_array['user_id'];

      $sql_subscribers_amount = "SELECT COUNT(*)
                                 FROM subscription
                                 WHERE author_id = ?;";

      $stmt = mysqli_prepare($con, $sql_subscribers_amount);
      mysqli_stmt_bind_param($stmt, 'i', $user_id);
      mysqli_stmt_execute($stmt);
      $sql_array = mysqli_stmt_get_result($stmt);
      $subscribers_amount = mysqli_fetch_row($sql_array);

      $sql_publications_amount = "SELECT COUNT(*)
                                  FROM post
                                  WHERE user_id = ?;";

      $stmt = mysqli_prepare($con, $sql_publications_amount);
      mysqli_stmt_bind_param($stmt, 'i', $user_id);
      mysqli_stmt_execute($stmt);
      $sql_array = mysqli_stmt_get_result($stmt);
      $publications_amount = mysqli_fetch_row($sql_array);

      $detailed_post_content = include_template('post_details_'.$post_content_array['type'].'_block.php', ['post_array' => $post_content_array]);
      $page_content = include_template('post_view.php', ['post_content' => $post_content_array, 'inner_content' => $detailed_post_content, 'subscribers_amount' => $subscribers_amount, 'publications_amount' => $publications_amount]);
      print($page_content);
      die();
    }
}

header("Location: /");
die();

?>


