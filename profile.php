<?php

require_once('helpers.php');
require_once('functions.php');
require_once('mailer.php');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_SESSION['user']) && isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {  //проверяем залогинены или нет и есть ли ID пользователя

		$sql = "SELECT subscriber_id
				FROM subscription
				WHERE subscriber_id = ? AND author_id = ?;";
		$stmt = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($stmt,'ii', $_SESSION['user_data']['id'], $_GET['user_id']);
		mysqli_stmt_execute($stmt);
		$res = mysqli_stmt_get_result($stmt);
		$result = mysqli_fetch_array($res, MYSQLI_ASSOC);
		$is_subscribed = !empty($result);


	  $sql = "SELECT user.id AS id, login, avatar, registration_date, COUNT(DISTINCT post.id) AS publications, COUNT(DISTINCT subscription.subscriber_id) AS subscribers
	      	  FROM user
	      	  LEFT JOIN post ON user.id = post.user_id
	      	  LEFT JOIN subscription ON user.id = subscription.author_id
	          WHERE user.id = ?
	          GROUP BY login;";
	  $stmt = mysqli_prepare($con, $sql);
	  mysqli_stmt_bind_param($stmt, 'i', $_GET['user_id']);
	  mysqli_stmt_execute($stmt);
	  $res = mysqli_stmt_get_result($stmt);
	  $user_profile_data = mysqli_fetch_assoc($res);    //выборка данных по пользователю


	 $sql = "SELECT post.id AS id, post_date, post_header, post_content, quote_author, image, video, link, content_type, COUNT(likes.post_id) AS likes 
	  	     FROM post 
		     LEFT JOIN likes ON post.id = likes.post_id
		     JOIN user ON post.user_id = user.id
		     WHERE post.user_id = ?
		     GROUP BY post.id
		     ORDER BY post_date;";
	  $stmt = mysqli_prepare($con, $sql);
	  mysqli_stmt_bind_param($stmt, 'i', $_GET['user_id']);
	  mysqli_stmt_execute($stmt);
	  $res = mysqli_stmt_get_result($stmt);
	  $posts_array = mysqli_fetch_all($res, MYSQLI_ASSOC);    
	  foreach ($posts_array as $key => $post) {
	  	$hashtags_list = hashtag_list($post['id'], $con);
	  	$posts_array[$key]['hashtag'] = $hashtags_list;
	  } 
	  foreach ($posts_array as $key => $post) {
	  	$comments_list = post_comments_list($post['id'], $con);
	  	$posts_array[$key]['comments'] = $comments_list;
	  }  
 


	  $sql = "SELECT user.login AS login, user.avatar AS avatar, likes.like_date AS like_date, post.post_content AS content, content_type.class AS content_type, post.id AS post_id, user.id AS user_id
	      	  FROM user
	      	  JOIN post ON user.id = post.user_id
	      	  JOIN likes ON post.id = likes.post_id
	      	  JOIN content_type ON content_type.id = post.content_type
	          WHERE post.user_id = ?
	          ORDER BY likes.like_date;";
	  $stmt = mysqli_prepare($con, $sql);
	  mysqli_stmt_bind_param($stmt, 'i', $_GET['user_id']);
	  mysqli_stmt_execute($stmt);
	  $res = mysqli_stmt_get_result($stmt);
	  $user_likes_data = mysqli_fetch_all($res,  MYSQLI_ASSOC);    //выборка данных лайков постов с данными лайкнувшего


	  $sql = "SELECT user.id AS id, login, avatar, registration_date, COUNT(DISTINCT post.id) AS publications, (SELECT COUNT(*) FROM subscription WHERE subscription.author_id = user.id) AS subscribers, (SELECT COUNT(*) FROM subscription WHERE subscription.author_id = user.id AND subscription.subscriber_id = ?) AS is_subscribed
	      	  FROM subscription
	      	  LEFT JOIN user ON subscription.subscriber_id = user.id
	      	  LEFT JOIN post ON user.id = post.user_id
	          WHERE subscription.author_id = ?
	          GROUP BY login;";
	  $stmt = mysqli_prepare($con, $sql);
	  mysqli_stmt_bind_param($stmt, 'ii', $_SESSION['user_data']['id'], $_GET['user_id']);
	  mysqli_stmt_execute($stmt);
	  $res = mysqli_stmt_get_result($stmt);
	  $subscribers = mysqli_fetch_all($res,  MYSQLI_ASSOC);    //выборка данных подписчиков с проверкой взаимной подписки

	$page_content = include_template('profile_template.php', ['user_profile_data' => $user_profile_data, 'posts_array' => $posts_array, 'user_likes_data' => $user_likes_data, 'is_subscribed' => $is_subscribed, 'subscribers' => $subscribers]);
	$layout_content = include_template('layout.php', ['page_content' => $page_content, 'page_title' => 'readme: профиль', 'is_auth' => true]);
	print($layout_content);

} 

header("Location: index.php");
exit();

?>