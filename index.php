<?php
require_once('helpers.php');
$is_auth = rand(0, 1);

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$posts_array = array(
    array('header' => 'Цитата', 'type' => 'post-quote', 'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих', 'user_name' => 'Лариса', 'avatar' => 'userpic-larisa-small.jpg'),
    array('header' => 'Сахара', 'type' => 'post-text', 'content' => 'Сахара располагается на Сахарской плите — северо-западной части древней Африканской платформы. Вдоль центральной части плиты с запада на восток протягивается Центрально-Сахарская зона поднятий, где на поверхность выходит докембрийский кристаллический фундамент: Регибатский массив на западе отделён Танезруфтским прогибом от нагорья Ахаггар, состоящего из чередующихся горстов и грабенов. Далее к востоку простираются массивы Тибести, Эль-Увайнат, Эль-Эглаб, а также западный выступ Нубийско-Аравийского щита (хребет Этбай).', 'user_name' => 'Владик', 'avatar' => 'userpic.jpg'),
    array('header' => 'Наконец, обработал фотки!', 'type' => 'post-photo', 'content' => 'rock-medium.jpg', 'user_name' => 'Виктор', 'avatar' => 'userpic-mark.jpg'),
    array('header' => 'Моя мечта', 'type' => 'post-photo', 'content' => 'coast-medium.jpg', 'user_name' => 'Лариса', 'avatar' => 'userpic-larisa-small.jpg'),
    array('header' => 'Лучшие курсы', 'type' => 'post-link', 'content' => 'www.htmlacademy.ru', 'user_name' => 'Владик', 'avatar' => 'userpic.jpg')
);

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

$page_content = include_template('main.php', ['posts_array' => $posts_array]);
$layout_content = include_template('layout.php', ['page_content' => $page_content, 'page_title' => 'readme: популярное']);
print($layout_content);

?>