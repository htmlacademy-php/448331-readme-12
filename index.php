<?php
require_once('helpers.php');
$is_auth = rand(0, 1);

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$con = mysqli_connect("localhost", "mysql", "mysql", "readme", 3306);
mysqli_set_charset($con, "utf8");

$sql_posts_id_filter ="";
if ($_GET['content_id']) {
    $sql_posts_id_filter = "WHERE content_type.id = ".$_GET['content_id'];
}

$sql_posts_select = "SELECT post_header AS header, class AS type, post_content AS content, login AS user_name, avatar, post_date, link, image, post.id
                    FROM post
                    JOIN user ON post.user_id = user.id
                    JOIN content_type ON post.content_type = content_type.id
                    $sql_posts_id_filter
                    ORDER BY view_count;";

$sql_content_types_select = "SELECT type, class, id
                            FROM content_type;";

$sql_array = mysqli_query($con, $sql_posts_select);
$posts_array = mysqli_fetch_all($sql_array,  MYSQLI_ASSOC);
$sql_array = mysqli_query($con, $sql_content_types_select);
$content_types = mysqli_fetch_all($sql_array,  MYSQLI_ASSOC);


$user_name = 'Андрей'; // укажите здесь ваше имя

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
$layout_content = include_template('layout.php', ['page_content' => $page_content, 'page_title' => 'readme: популярное']);
print($layout_content);

?>