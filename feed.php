<?php

require_once('helpers.php');
require_once('functions.php');

if (isset($_SESSION['user_data']['id'])) {
	// код запроса к БД на выборку релевантных постов
	$sql = " SELECT post.id AS id, post_date, post_header, post_content, quote_author, image, video, link, content_type, login, avatar, author_id,  COUNT(comment.user_id) AS comments, COUNT(likes.post_id) AS likes
		    FROM post 
		    LEFT JOIN comment ON comment.post_id = post.id
		    LEFT JOIN likes ON comment.post_id = likes.post_id
		    JOIN user ON post.user_id = user.id
		    JOIN subscription ON user.id = subscription.author_id
		    WHERE subscriber_id = ?
		    GROUP BY post.id;";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_data']['id']);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $feed_posts_array = mysqli_fetch_all($res, MYSQLI_ASSOC);

	$page_content = include_template('feed_template.php', ['feed_posts' => $feed_posts_array]);
	$layout_content = include_template('layout.php', ['page_content' => $page_content, 'page_title' => 'readme: популярное', 'is_auth' => true]);
	print($layout_content);
} else {
	header("Location: /");
	die();
}



?>