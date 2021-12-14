<?php

require_once('helpers.php');
require_once('functions.php');

if (isset($_SESSION['user'])) {

    $content_type_filter = "";
    if (is_numeric($_GET['content_id'])) {
        $content_type_filter = "WHERE content_type.id = ?";
    } 

    $sql_posts_select = "SELECT post_header AS header, class AS type, post_content AS content, login AS user_name, avatar, post_date, link, image, post.id
                        FROM post
                        JOIN user ON post.user_id = user.id
                        JOIN content_type ON post.content_type = content_type.id
                        $content_type_filter
                        ORDER BY view_count;";

    $stmt = mysqli_prepare($con, $sql_posts_select);

    if ($content_type_filter) {
    	mysqli_stmt_bind_param($stmt, 'i', $_GET['content_id']);
    }


    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $posts_array = mysqli_fetch_all($res,  MYSQLI_ASSOC);

    $sql_content_types_select = "SELECT type, class, id
                                 FROM content_type;";
    $sql_array = mysqli_query($con, $sql_content_types_select);
    $content_types = mysqli_fetch_all($sql_array,  MYSQLI_ASSOC);

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

    $page_content = include_template('main.php', ['posts_array' => $posts_array, 'content_types' => $content_types]);
    $layout_content = include_template('layout.php', ['page_content' => $page_content, 'page_title' => 'readme: популярное', 'is_auth' => true]);
    print($layout_content);
} else {
    header("Location: /");
    die();
}

?>