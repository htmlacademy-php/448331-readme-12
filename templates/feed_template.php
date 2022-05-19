    <main class="page__main page__main--feed">
      <div class="container">
        <h1 class="page__title page__title--feed">Моя лента</h1>
      </div>
      <div class="page__main-wrapper container">
        <section class="feed">
          <h2 class="visually-hidden">Лента</h2>
          <div class="feed__main-wrapper">
            <div class="feed__wrapper">

              <?php foreach ($feed_posts as $index => $post_content): ?>

                <?php if ($post_content['content_type'] == 3): ?>
                <article class="feed__post post post-photo">
                  <header class="post__header post__author">
                    <a class="post__author-link" href="profile.php?user_id=<?= $post_content['author_id'] ?>" title="Автор">
                      <div class="post__avatar-wrapper">
                        <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя" width="60" height="60">
                      </div>
                      <div class="post__info">
                        <b class="post__author-name"><?= $post_content['login'] ?></b>
                        <span class="post__time"><?= post_date_ago($post_content['post_date']) ?></span>
                      </div>
                    </a>
                  </header>
                  <div class="post__main">
                    <h2><a href="#"><?= $post_content['post_header'] ?></a></h2>
                    <div class="post-photo__image-wrapper">
                      <img src="img/<?= $post_content['image'] ?>" alt="Фото от пользователя" width="760" height="396">
                    </div>
                  </div>

                <?php elseif ($post_content['content_type'] == 1): ?>
                <article class="feed__post post post-text">
                  <header class="post__header post__author">
                    <a class="post__author-link" href="profile.php?user_id=<?= $post_content['author_id'] ?>" title="Автор">
                      <div class="post__avatar-wrapper">
                        <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя" width="60" height="60">
                      </div>
                      <div class="post__info">
                        <b class="post__author-name"><?= $post_content['login'] ?></b>
                        <span class="post__time"><?= post_date_ago($post_content['post_date']) ?></span>
                      </div>
                    </a>
                  </header>
                  <div class="post__main">
                    <h2><a href="#"><?= $post_content['post_header'] ?></a></h2>
                    <p>
                      <?= $post_content['post_content'] ?>
                    </p>
                    <a class="post-text__more-link" href="#">Читать далее</a>
                  </div>

                <?php elseif ($post_content['content_type'] == 4): ?>
                <article class="feed__post post post-video">
                  <header class="post__header post__author">
                    <a class="post__author-link" href="profile.php?user_id=<?= $post_content['author_id'] ?>" title="Автор">
                      <div class="post__avatar-wrapper">
                        <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя" width="60" height="60">
                      </div>
                      <div class="post__info">
                        <b class="post__author-name"><?= $post_content['login'] ?></b>
                        <span class="post__time"><?= post_date_ago($post_content['post_date']) ?></span>
                      </div>
                    </a>
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
                <article class="feed__post post post-quote">
                  <header class="post__header post__author">
                    <a class="post__author-link" href="profile.php?user_id=<?= $post_content['author_id'] ?>" title="Автор">
                      <div class="post__avatar-wrapper">
                        <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя" width="60" height="60">
                      </div>
                      <div class="post__info">
                        <b class="post__author-name"><?= $post_content['login'] ?></b>
                        <span class="post__time"><?= post_date_ago($post_content['post_date']) ?></span>
                      </div>
                    </a>
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
                <article class="feed__post post post-link">
                  <header class="post__header post__author">
                    <a class="post__author-link" href="profile.php?user_id=<?= $post_content['author_id'] ?>" title="Автор">
                      <div class="post__avatar-wrapper">
                        <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя" width="60" height="60">
                      </div>
                      <div class="post__info">
                        <b class="post__author-name"><?= $post_content['login'] ?></b>
                        <span class="post__time"><?= post_date_ago($post_content['post_date']) ?></span>
                      </div>
                    </a>
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
                  <footer class="post__footer post__indicators">
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
                      <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                        <svg class="post__indicator-icon" width="19" height="17">
                          <use xlink:href="#icon-comment"></use>
                        </svg>
                        <span><?= $post_content['comments'] ?></span>
                        <span class="visually-hidden">количество комментариев</span>
                      </a>
                      <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                        <svg class="post__indicator-icon" width="19" height="17">
                          <use xlink:href="#icon-repost"></use>
                        </svg>
                        <span>5</span>
                        <span class="visually-hidden">количество репостов</span>
                      </a>
                    </div>
                  </footer>
                </article>
              <?php endforeach; ?>

            </div>
          </div>
          <ul class="feed__filters filters">
            <li class="feed__filters-item filters__item">
              <a class="filters__button filters__button--active" href="#">
                <span>Все</span>
              </a>
            </li>
            <li class="feed__filters-item filters__item">
              <a class="filters__button filters__button--photo button" href="#">
                <span class="visually-hidden">Фото</span>
                <svg class="filters__icon" width="22" height="18">
                  <use xlink:href="#icon-filter-photo"></use>
                </svg>
              </a>
            </li>
            <li class="feed__filters-item filters__item">
              <a class="filters__button filters__button--video button" href="#">
                <span class="visually-hidden">Видео</span>
                <svg class="filters__icon" width="24" height="16">
                  <use xlink:href="#icon-filter-video"></use>
                </svg>
              </a>
            </li>
            <li class="feed__filters-item filters__item">
              <a class="filters__button filters__button--text button" href="#">
                <span class="visually-hidden">Текст</span>
                <svg class="filters__icon" width="20" height="21">
                  <use xlink:href="#icon-filter-text"></use>
                </svg>
              </a>
            </li>
            <li class="feed__filters-item filters__item">
              <a class="filters__button filters__button--quote button" href="#">
                <span class="visually-hidden">Цитата</span>
                <svg class="filters__icon" width="21" height="20">
                  <use xlink:href="#icon-filter-quote"></use>
                </svg>
              </a>
            </li>
            <li class="feed__filters-item filters__item">
              <a class="filters__button filters__button--link button" href="#">
                <span class="visually-hidden">Ссылка</span>
                <svg class="filters__icon" width="21" height="18">
                  <use xlink:href="#icon-filter-link"></use>
                </svg>
              </a>
            </li>
          </ul>
        </section>
        <aside class="promo">
          <article class="promo__block promo__block--barbershop">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
              Все еще сидишь на окладе в офисе? Открой свой барбершоп по нашей франшизе!
            </p>
            <a class="promo__link" href="#">
              Подробнее
            </a>
          </article>
          <article class="promo__block promo__block--technomart">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
              Товары будущего уже сегодня в онлайн-сторе Техномарт!
            </p>
            <a class="promo__link" href="#">
              Перейти в магазин
            </a>
          </article>
          <article class="promo__block">
            <h2 class="visually-hidden">Рекламный блок</h2>
            <p class="promo__text">
              Здесь<br> могла быть<br> ваша реклама
            </p>
            <a class="promo__link" href="#">
              Разместить
            </a>
          </article>
        </aside>
      </div>
    </main>