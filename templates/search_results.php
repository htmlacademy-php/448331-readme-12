<?php if (!empty($search_posts)): ?>

    <main class="page__main page__main--search-results">
      <h1 class="visually-hidden">Страница результатов поиска</h1>
      <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
          <div class="search__query container">
            <span>Вы искали:</span>
            <span class="search__query-text"><?= $query ?></span>
          </div>
        </div>
        <div class="search__results-wrapper">
          <div class="container">
            <div class="search__content">

                <?php foreach ($search_posts as $index => $post_content): ?>

                  <?php if ($post_content['content_type'] == 3): ?>
                  <article class="search__post post post-photo">
                    <header class="post__header post__author">
                      <a class="post__author-link" href="#" title="Автор">
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
                    <footer class="post__footer post__indicators">
                      <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
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

                  <?php elseif ($post_content['content_type'] == 1): ?>
                  <article class="search__post post post-text">
                    <header class="post__header post__author">
                      <a class="post__author-link" href="#" title="Автор">
                        <div class="post__avatar-wrapper">
                          <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя">
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
                    <footer class="post__footer post__indicators">
                      <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
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

                  <?php elseif ($post_content['content_type'] == 4): ?>
                  <article class="search__post post post-video">
                    <header class="post__header post__author">
                      <a class="post__author-link" href="#" title="Автор">
                        <div class="post__avatar-wrapper">
                          <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя">
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
                    <footer class="post__footer post__indicators">
                      <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
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

                  <?php elseif ($post_content['content_type'] == 2): ?>
                  <article class="search__post post post-quote">
                    <header class="post__header post__author">
                      <a class="post__author-link" href="#" title="Автор">
                        <div class="post__avatar-wrapper">
                          <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя">
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
                    <footer class="post__footer post__indicators">
                      <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
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

                  <?php elseif ($post_content['content_type'] == 5): ?>
                  <article class="search__post post post-link">
                    <header class="post__header post__author">
                      <a class="post__author-link" href="#" title="Автор">
                        <div class="post__avatar-wrapper">
                          <img class="post__author-avatar" src="img/<?= $post_content['avatar'] ?>" alt="Аватар пользователя">
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
                    <footer class="post__footer post__indicators">
                      <div class="post__buttons">
                        <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
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
                  <?php endif; ?>
                <?php endforeach; ?>
              
            </div>
          </div>
        </div>
      </section>
    </main>

<?php else: ?>

  <main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска (нет результатов)</h1>
    <section class="search">
      <h2 class="visually-hidden">Результаты поиска</h2>
      <div class="search__query-wrapper">
        <div class="search__query container">
          <span>Вы искали:</span>
          <span class="search__query-text"><?= $query ?></span>
        </div>
      </div>
      <div class="search__results-wrapper">
        <div class="search__no-results container">
          <p class="search__no-results-info">К сожалению, ничего не найдено.</p>
          <p class="search__no-results-desc">
            Попробуйте изменить поисковый запрос или просто зайти в раздел &laquo;Популярное&raquo;, там живет самый крутой контент.
          </p>
          <div class="search__links">
            <a class="search__popular-link button button--main" href="#">Популярное</a>
            <a class="search__back-link" href="#">Вернуться назад</a>
          </div>
        </div>
      </div>
    </section>
  </main>
  
<?php endif; ?>

