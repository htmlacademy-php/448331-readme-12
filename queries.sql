USE readme;

INSERT INTO content_type (type, class)
	 VALUES ('Текст', 'text'),
	        ('Цитата', 'quote'),
	        ('Картинка', 'photo'),
	        ('Видео', 'video'),
	        ('Ссылка', 'link');

INSERT INTO user (registration_date, email, login, password, avatar)
     VALUES ('2019-12-01', 'bob@gmail.com', 'silent_bob', 'verysecretword', '/img/mybestphoto.jpg'),
            ('2020-02-11', 'jane_1990@mymail.com', 'pinky_jane', '456no764', '/img/12_new_avatar.jpg'),
            ('2002-06-16', 'bob@gmail.com', 'silent_bob', 'verysecretword', '/img/mybestphoto.jpg');

INSERT INTO post (post_date, post_header, post_content, quote_author, image, video, link, view_count, user_id, content_type)
     VALUES ('2019-11-02', 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, 1, 2),
            ('2019-05-09', 'Сахара', 'Сахара располагается на Сахарской плите — северо-западной части древней Африканской платформы.
            Вдоль центральной части плиты с запада на восток протягивается Центрально-Сахарская зона поднятий, где на поверхность 
            выходит докембрийский кристаллический фундамент: Регибатский массив на западе отделён Танезруфтским прогибом от нагорья
             Ахаггар, состоящего из чередующихся горстов и грабенов. Далее к востоку простираются массивы Тибести, Эль-Увайнат,
              Эль-Эглаб, а также западный выступ Нубийско-Аравийского щита (хребет Этбай).', DEFAULT, DEFAULT, DEFAULT, DEFAULT, DEFAULT, 2, 1),
            ('2020-11-02', 'Наконец, обработал фотки!', DEFAULT, DEFAULT, 'rock-medium.jpg', DEFAULT, DEFAULT, DEFAULT, 3, 3),
            ('2020-03-22', 'Моя мечта', DEFAULT, DEFAULT, 'coast-medium.jpg', DEFAULT, DEFAULT, DEFAULT, 1, 3),
            ('2020-08-28', 'Лучшие курсы', DEFAULT, DEFAULT, DEFAULT, DEFAULT, 'www.htmlacademy.ru', DEFAULT, 2, 5);

INSERT INTO comment (comment_date, comment_content, user_id, post_id)
     VALUES ('2020-05-01', 'It is awesome! I have never seen this before!', 1, 1),
            ('2020-08-07', 'This is what I told you five years ago...', 3, 2),
            ('2020-11-11', 'How can you post this!?', 2, 3);



/* Список постов с сортировкой по популярности вместе с именами авторов и типом контента */
SELECT post.post_header AS Заголовок, user.login AS Автор, content_type.type AS Тип
FROM post 
JOIN user ON post.user_id = user.id
JOIN content_type ON post.content_type = content_type.id
ORDER BY view_count;

/* Получаем список постов пользователя 2 */
SELECT post.post_header AS Заголовок, post.post_date AS Дата
FROM post 
WHERE user_id = 2;

/* Получаем список комментариев для поста 1 с указанием автора комментария */
SELECT comment.comment_content AS Комментарий, user.login AS Автор
FROM comment 
JOIN post ON comment.post_id = post.id 
JOIN user ON comment.user_id = user.id
WHERE comment.post_id = 1;

/* Добавить лайк к посту 1 от пользователя 1 */
INSERT INTO likes (user_id, post_id, like_date)
     VALUES ('1', '1', DEFAULT);

/* Подписка пользователя 1 на пользователя 2 */
INSERT INTO subscription (subscriber_id, author_id)
     VALUES ('1', '2');
