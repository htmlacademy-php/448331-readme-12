<?php

require_once('helpers.php');
require_once('functions.php');

const ITEMS_PER_PAGE = 6;

if (isset($_SESSION['user'])) {

    $current_page = ($_GET['page'] >= 1) ? (int) $_GET['page'] : 1;
    $items_offset = ($current_page - 1) * ITEMS_PER_PAGE;

    $content_type_filter = "";
    if (is_numeric($_GET['content_id'])) {
        $content_type_filter = "WHERE post.content_type = ?";
        $this_page_link = $_SERVER['SCRIPT_NAME']. '?id=' .$_GET['content_id'];
    } else {
        $this_page_link = $_SERVER['SCRIPT_NAME'].'?';
    }

    $sql_posts_amount_count = "SELECT COUNT(*) AS posts_count
                               FROM post
                               $content_type_filter;";

    $sql_posts_select = "SELECT post_header AS header, class AS type, post_content AS content, login AS user_name, avatar, post_date, link, image, post.id AS post_id, user.id AS author_id, COUNT(likes.user_id) AS likes_amount, COUNT(comment.user_id) AS comments_amount
                        FROM post
                        JOIN user ON post.user_id = user.id
                        JOIN content_type ON post.content_type = content_type.id
                        LEFT JOIN likes ON post.id = likes.post_id
                        LEFT JOIN comment ON post.id = comment.post_id
                        $content_type_filter
                        GROUP BY post.id
                        ORDER BY view_count
                        LIMIT " . ITEMS_PER_PAGE .
                        " OFFSET ?;";

    $stmt = mysqli_prepare($con, $sql_posts_select);
    
    if ($content_type_filter) {
        $stmt_posts_count = mysqli_prepare($con, $sql_posts_amount_count);
        mysqli_stmt_bind_param($stmt_posts_count, 'i', $_GET['content_id']);
        mysqli_stmt_execute($stmt_posts_count);
        $res = mysqli_stmt_get_result($stmt_posts_count);
        $posts_amount = mysqli_fetch_all($res, MYSQLI_ASSOC);
    	mysqli_stmt_bind_param($stmt, 'ii', $_GET['content_id'], $items_offset);
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $items_offset);
        $posts_amount = mysqli_query($con, $sql_posts_amount_count); //запрос без подстановки внешних параметров
        $posts_amount = mysqli_fetch_all($posts_amount, MYSQLI_ASSOC);
    }

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $posts_array = mysqli_fetch_all($res,  MYSQLI_ASSOC);


    $pages_amount = ceil($posts_amount[0]['posts_count'] / ITEMS_PER_PAGE);
    $pages_amount = ($pages_amount > 1) ? $pages_amount : 1;

    $sql_content_types_select = "SELECT type, class, id
                                 FROM content_type;";
    $sql_array = mysqli_query($con, $sql_content_types_select);
    $content_types = mysqli_fetch_all($sql_array,  MYSQLI_ASSOC);
    $page_content = include_template('main.php', ['posts_array' => $posts_array,
                                                'content_types' => $content_types,
                                                 'current_page' => $current_page, 
                                                 'pages_amount' => $pages_amount, 
                                               'this_page_link' => $this_page_link]);
    $layout_content = include_template('layout.php', ['page_content' => $page_content, 'page_title' => 'readme: популярное', 'is_auth' => true]);
    print($layout_content);
} else {
    header("Location: /");
    die();
}

?>