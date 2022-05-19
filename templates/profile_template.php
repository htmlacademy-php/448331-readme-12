    <main class="page__main page__main--profile">
      <h1 class="visually-hidden">Профиль</h1>
      <div class="profile profile--default">
        <div class="profile__user-wrapper">
          <div class="profile__user user container">
            <div class="profile__user-info user__info">
              <div class="profile__avatar user__avatar">
                <img class="profile__picture user__picture" src="/img/<?= $user_profile_data['avatar'] ?>" alt="Аватар пользователя">
              </div>
              <div class="profile__name-wrapper user__name-wrapper">
                <span class="profile__name user__name"><?= $user_profile_data['login'] ?></span>
                <time class="profile__user-time user__time" datetime="<?= $user_profile_data['registration_date'] ?>"> <?= mb_substr(post_date_ago($user_profile_data['registration_date']), 0, -6) ?> на сайте</time>
              </div>
            </div>
            <div class="profile__rating user__rating">
              <p class="profile__rating-item user__rating-item user__rating-item--publications">
                <span class="user__rating-amount"><?= $user_profile_data['publications'] ?></span>
                <span class="profile__rating-text user__rating-text"><?= get_noun_plural_form($user_profile_data['publications'], 'публикация', 'публикации', 'публикаций') ?></span>
              </p>
              <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                <span class="user__rating-amount"><?= $user_profile_data['subscribers'] ?></span>
                <span class="profile__rating-text user__rating-text"><?= get_noun_plural_form($user_profile_data['subscribers'], 'подписчик', 'подписчика', 'подписчиков') ?></span>
              </p>
            </div>

            <div class="profile__user-buttons user__buttons">
              <?php if ($is_subscribed): ?>
              <a class="profile__user-button user__button user__button--subscription button button--main" href="subscription.php?user_id=<?= $user_profile_data['id'] ?>&action=unsubscribe">Отписаться</a>
              <a class="profile__user-button user__button user__button--writing button button--green" href="messages.php">Сообщение</a>
              <?php else: ?> 
              <a class="profile__user-button user__button user__button--subscription button button--main" href="subscription.php?user_id=<?= $user_profile_data['id'] ?>&action=subscribe">Подписаться</a>
              <?php endif; ?>       
            </div>

          </div>
        </div>
        <div class="profile__tabs-wrapper tabs">
          <div class="container">
            <div class="profile__tabs filters">
              <b class="profile__tabs-caption filters__caption">Показать:</b>
              <ul class="profile__tabs-list filters__list tabs__list">
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button filters__button--active tabs__item tabs__item--active button">Посты</a>
                </li>
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button tabs__item button" href="#">Лайки</a>
                </li>
                <li class="profile__tabs-item filters__item">
                  <a class="profile__tabs-link filters__button tabs__item button" href="#">Подписки</a>
                </li>
              </ul>
            </div>
            <div class="profile__tab-content">
              <section class="profile__posts tabs__content tabs__content--active">
                <h2 class="visually-hidden">Публикации</h2>

                  <?php foreach ($posts_array as $post_index => $post_content): ?>

                    <?php if ($post_content['content_type'] == 3): ?>
                    <article class="profile__post post post-photo">
                      <header class="post__header">
                        <h2><a href="#"><?= $post_content['post_header'] ?></a></h2>
                      </header>
                      <div class="post__main">
                        <div class="post-photo__image-wrapper">
                          <img src="img/<?= $post_content['image'] ?>" alt="Фото от пользователя" width="760" height="396">
                        </div>
                      </div>

                    <?php elseif ($post_content['content_type'] == 1): ?>
                    <article class="profile__post post post-text">
                      <header class="post__header">
                        <h2><a href="#"><?= $post_content['post_header'] ?></a></h2>
                      </header>
                      <div class="post__main">
                        <p>
                          <?= $post_content['post_content'] ?>
                        </p>
                        <a class="post-text__more-link" href="#">Читать далее</a>
                      </div>

                    <?php elseif ($post_content['content_type'] == 4): ?>
                    <article class="profile__post post post-video">
                      <header class="post__header">
                        <h2><a href="#"><?= $post_content['post_header'] ?></a></h2>
                      </header>
                      <div class="post__main">
                        <div class="post-video__block">
                          <div class="post-video__preview">
                            <img src="img/<?= $post_content['image'] ?>" alt="Превью к видео" width="760" height="396">
                          </div>
                          <div class="post-video__control">
                            <button class="post-video__play post-video__play--paused button button--video" type="button"><span class="visually-hidden">Запустить видео</span></button>
                            <div class="post-video__scale-wrapper">
                              <div class="post-video__scale">
                                <div class="post-video__bar">
                                  <div class="post-video__toggle"></div>
                                </div>
                              </div>
                            </div>
                            <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button"><span class="visually-hidden">Полноэкранный режим</span></button>
                          </div>
                          <button class="post-video__play-big button" type="button">
                            <svg class="post-video__play-big-icon" width="27" height="28">
                              <use xlink:href="#icon-video-play-big"></use>
                            </svg>
                            <span class="visually-hidden">Запустить проигрыватель</span>
                          </button>
                        </div>
                      </div>

                    <?php elseif ($post_content['content_type'] == 2): ?>
                    <article class="profile__post post post-quote">
                      <header class="post__header">
                        <h2><a href="#"><?= $post_content['post_header'] ?></a></h2>
                      </header>
                      <div class="post__main">
                        <blockquote>
                          <p>
                            <?= $post_content['post_content'] ?>
                          </p>
                          <cite><?= $post_content['quite_author'] ?></cite>
                        </blockquote>
                      </div>
                    
                    <?php elseif ($post_content['content_type'] == 5): ?>
                    <article class="profile__post post post-link">
                      <header class="post__header">
                        <h2><a href="#"><?= $post_content['post_header'] ?></a></h2>
                      </header>
                      <div class="post__main">
                        <div class="post-link__wrapper">
                          <a class="post-link__external" href="<?= $post_content['link'] ?>" title="Перейти по ссылке">
                            <div class="post-link__icon-wrapper">
                              <img src="img/logo-vita.jpg" alt="Иконка">
                            </div>
                            <div class="post-link__info">
                              <h3><?= $post_content['post_header'] ?></h3>
                              <p><?= $post_content['post_content'] ?></p>
                              <span><?= $post_content['link'] ?></span>
                            </div>
                            <svg class="post-link__arrow" width="11" height="16">
                              <use xlink:href="#icon-arrow-right-ad"></use>
                            </svg>
                          </a>
                        </div>
                      </div>
                    <?php endif; ?>

                       <footer class="post__footer">
                        <div class="post__indicators">
                          <div class="post__buttons">
                            <a class="post__indicator post__indicator--likes button" href="like.php?post_id=<?= $post_content['id'] ?>" title="Лайк">
                              <svg class="post__indicator-icon" width="20" height="17">
                                <use xlink:href="#icon-heart"></use>
                              </svg>
                              <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                                <use xlink:href="#icon-heart-active"></use>
                              </svg>
                              <span><?= $post_content['likes'] ?></span>
                              <span class="visually-hidden">количество лайков</span>
                            </a>
                            <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                              <svg class="post__indicator-icon" width="19" height="17">
                                <use xlink:href="#icon-repost"></use>
                              </svg>
                              <span>5</span>
                              <span class="visually-hidden">количество репостов</span>
                            </a>
                          </div>
                          <time class="post__time" datetime="<?= $post_content['post_date'] ?>"><?= post_date_ago($post_content['post_date']) ?></time>
                        </div>
                        <ul class="post__tags">
                          <?php foreach ($post_content['hashtag'] as $key => $value): ?>
                            <li><a href="#">#<?= $value[0] ?></a></li>
                          <?php endforeach; ?>
                        </ul>
                      </footer>

                      <div class="comments">
                        <div class="comments__list-wrapper">

                          <ul class="comments__list">
                            <?php foreach ($post_content['comments'] as $key => $value): ?>
                            <li class="comments__item user">
                              <div class="comments__avatar">
                                <a class="user__avatar-link" href="profile.php?user_id=<?= $value['id'] ?>">
                                  <img class="comments__picture" src="img/<?= $value['avatar'] ?>" alt="Аватар пользователя">
                                </a>
                              </div>
                              <div class="comments__info">
                                <div class="comments__name-wrapper">
                                  <a class="comments__user-name" href="profile.php?user_id=<?= $value['id'] ?>">
                                    <span><?= $value['login'] ?></span>
                                  </a>
                                  <time class="comments__time" datetime="<?= $value['comment_date'] ?>"><?= post_date_ago($value['comment_date']) ?></time>
                                </div>
                                <p class="comments__text">
                                  <?= $value['comment'] ?>
                                </p>
                              </div>
                            </li>
                            <?php endforeach; ?>
                          </ul>

                          <a class="comments__more-link" href="#">
                            <span>Показать все комментарии</span>
                            <sup class="comments__amount"><?= count($post_content['comments']) ?></sup>
                          </a>
                        </div>
                      </div>
                      <form class="comments__form form" action="add_comment.php" method="post">
                        <div class="comments__my-avatar">
                          <img class="comments__picture" src="img/<?= $_SESSION['user_data']['avatar'] ?>" alt="Аватар пользователя" width="40" height="40">
                        </div>
                        <textarea class="comments__textarea form__textarea" placeholder="Ваш комментарий" name="comment_text"></textarea>
                        <label class="visually-hidden">Ваш комментарий</label>
                        <button class="comments__submit button button--green" type="submit">Отправить</button>
                        <input type="hidden" name="post_id" value="<?= $post_content['id'] ?>">
                      </form>
                      </article>
                  <?php endforeach; ?>
              </section>

              <section class="profile__likes tabs__content">
                <h2 class="visually-hidden">Лайки</h2>

                <ul class="profile__likes-list">
                  <?php foreach ($user_likes_data as $like_index => $like_content): ?>
                    <li class="post-mini post-mini--<?= $like_content['content_type'] ?> post user">
                      <div class="post-mini__user-info user__info">
                        <div class="post-mini__avatar user__avatar">
                          <a class="user__avatar-link" href="profile.php?user_id=<?= $like_content['user_id'] ?>">
                            <img class="post-mini__picture user__picture" src="img/<?=$like_content['avatar']?>" alt="Аватар пользователя">
                          </a>
                        </div>
                        <div class="post-mini__name-wrapper user__name-wrapper">
                          <a class="post-mini__name user__name" href="profile.php?user_id=<?= $like_content['user_id'] ?>">
                            <span><?=$like_content['login']?></span>
                          </a>
                          <div class="post-mini__action">
                            <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                            <time class="post-mini__time user__additional" datetime="<?=$like_content['like_date']?>"><?= post_date_ago($like_content['like_date']) ?></time>
                          </div>
                        </div>
                      </div>
                      <div class="post-mini__preview">
                        <a class="post-mini__link" href="post.php?post_id=<?=$like_content['post_id']?>" title="Перейти на публикацию">

                          <?php if ($like_content['content_type'] == 'photo'): ?>
                          <div class="post-mini__image-wrapper">
                            <img class="post-mini__image" src="img/rock-small.png" width="109" height="109" alt="Превью публикации">
                          </div>
                          <span class="visually-hidden">Фото</span>

                          <?php elseif ($post_content['content_type'] == 'text'): ?>
                          <span class="visually-hidden">Текст</span>
                          <svg class="post-mini__preview-icon" width="20" height="21">
                            <use xlink:href="#icon-filter-text"></use>
                          </svg>

                          <?php elseif ($post_content['content_type'] == 'video'): ?>
                          <div class="post-mini__image-wrapper">
                            <img class="post-mini__image" src="img/coast-small.png" width="109" height="109" alt="Превью публикации">
                            <span class="post-mini__play-big">
                              <svg class="post-mini__play-big-icon" width="12" height="13">
                                <use xlink:href="#icon-video-play-big"></use>
                              </svg>
                            </span>
                          </div>
                          <span class="visually-hidden">Видео</span>

                          <?php elseif ($post_content['content_type'] == 'quote'): ?>
                          <span class="visually-hidden">Цитата</span>
                          <svg class="post-mini__preview-icon" width="21" height="20">
                            <use xlink:href="#icon-filter-quote"></use>
                          </svg>

                          <?php elseif ($post_content['content_type'] == 'link'): ?>
                          <span class="visually-hidden">Ссылка</span>
                          <svg class="post-mini__preview-icon" width="21" height="18">
                            <use xlink:href="#icon-filter-link"></use>
                          </svg>
                          <?php endif; ?>
                        </a>
                      </div>
                    </li>
                    <?php endforeach; ?>
                </ul>

              </section>

              <section class="profile__subscriptions tabs__content">
                <h2 class="visually-hidden">Подписки</h2>
                <ul class="profile__subscriptions-list">

                  <?php foreach ($subscribers as $subscriber): ?>
                  <li class="post-mini post-mini--photo post user">
                    <div class="post-mini__user-info user__info">
                      <div class="post-mini__avatar user__avatar">
                        <a class="user__avatar-link" href="profile.php?user_id=<?= $subscriber['id'] ?>">
                          <img class="post-mini__picture user__picture" src="img/<?= $subscriber['avatar'] ?>" alt="Аватар пользователя">
                        </a>
                      </div>
                      <div class="post-mini__name-wrapper user__name-wrapper">
                        <a class="post-mini__name user__name" href="profile.php?user_id=<?= $subscriber['id'] ?>">
                          <span><?= $subscriber['login'] ?></span>
                        </a>
                        <time class="post-mini__time user__additional" datetime="<?= $subscriber['registration_date'] ?>"><?= mb_substr(post_date_ago($subscriber['registration_date']), 0, -6) ?> на сайте</time>
                      </div>
                    </div>
                    <div class="post-mini__rating user__rating">
                      <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                        <span class="post-mini__rating-amount user__rating-amount"><?= $subscriber['publications'] ?></span>
                        <span class="post-mini__rating-text user__rating-text"><?= get_noun_plural_form($subscriber['publications'], 'публикация', 'публикации', 'публикаций') ?></span>
                      </p>
                      <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="post-mini__rating-amount user__rating-amount"><?= $subscriber['subscribers'] ?></span>
                        <span class="post-mini__rating-text user__rating-text"><?= get_noun_plural_form($subscriber['subscribers'], 'подписчик', 'подписчика', 'подписчиков') ?></span>
                      </p>
                    </div>
                    <div class="post-mini__user-buttons user__buttons">
                      <?php if (empty($subscriber['is_subscribed'])): ?> 
                      <button class="post-mini__user-button user__button user__button--subscription button button--main" type="button">Подписаться</button>
                      <?php else: ?>
                      <button class="post-mini__user-button user__button user__button--subscription button button--quartz" type="button">Отписаться</button>
                      <?php endif; ?>
                    </div>
                  </li>
                  <?php endforeach; ?>

                </ul>
              </section>
            </div>
          </div>
        </div>
      </div>
    </main>
