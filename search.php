<?php

require_once('helpers.php');
require_once('functions.php');

if (isset($_SESSION['user'])) {

	if (isset($_GET['search_query'])) {

		$query = trim($_GET['search_query']);
		$original_query = $query;

		if (substr($query, 0,1) == '#') {
			$query = substr($query, 1);

			$sql = "SELECT post.id AS id, post_date, post_header, post_content, quote_author, image, video, link, content_type, login, avatar, author_id,  COUNT(comment.user_id) AS comments, COUNT(likes.post_id) AS likes
				    FROM post 
				    LEFT JOIN comment ON comment.post_id = post.id
				    LEFT JOIN likes ON comment.post_id = likes.post_id
				    JOIN user ON post.user_id = user.id
				    JOIN subscription ON user.id = subscription.author_id
				    JOIN tag_in_post ON post.id = tag_in_post.post_id
				    JOIN hashtag ON hashtag.id = tag_in_post.tag_id
				    WHERE hashtag_name = ?
				    GROUP BY post.id
				    ORDER BY post_date;";
		} elseif ($query != "") {
			$sql = "SELECT post.id AS id, post_date, post_header, post_content, quote_author, image, video, link, content_type, login, avatar, author_id,  COUNT(comment.user_id) AS comments, COUNT(likes.post_id) AS likes
				    FROM post 
				    LEFT JOIN comment ON comment.post_id = post.id
				    LEFT JOIN likes ON comment.post_id = likes.post_id
				    JOIN user ON post.user_id = user.id
				    JOIN subscription ON user.id = subscription.author_id
				    WHERE MATCH (post_header, post_content) AGAINST(?)
				    GROUP BY post.id;";
		}

		$stmt = mysqli_prepare($con, $sql);
	    mysqli_stmt_bind_param($stmt, 's', $query);
	    mysqli_stmt_execute($stmt);
	    $res = mysqli_stmt_get_result($stmt);
	    $search_result_posts_array = mysqli_fetch_all($res, MYSQLI_ASSOC);

	    $page_content = include_template('search_results.php', ['search_posts' => $search_result_posts_array, 'query' => $original_query]);
	    $layout_content = include_template('layout.php', ['page_content' => $page_content, 'page_title' => 'readme: страница результатов поиска', 'is_auth' => true, 'query' => $original_query]);
		print($layout_content);
	}
} else {
	header("Location: /");
	exit();
}
?>