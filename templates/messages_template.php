    <main class="page__main page__main--messages">
      <h1 class="visually-hidden">Личные сообщения</h1>
      <section class="messages tabs">
        <h2 class="visually-hidden">Сообщения</h2>
        <div class="messages__contacts"> <!-- блок со списком контактов-->
          <ul class="messages__contacts-list tabs__list">
            <?php foreach ($chat_mates_data as $index => $chat_mate): ?>
              <li class="messages__contacts-item <?= ($chat_mate['new_messages_amount'] > 0) ? "messages__contacts-item--new" : "" ?>">
                <a class="messages__contacts-tab <?= ($chat_mate['user_id'] == $chat_mate_id) ? "messages__contacts-tab--active tabs__item--active" : "" ?> tabs__item" href="messages.php?chat_mate_id=<?= $chat_mate['user_id'] ?>">
                  <div class="messages__avatar-wrapper">
                    <img class="messages__avatar" src="img/<?= $chat_mate['avatar'] ?>" alt="Аватар пользователя">
                    <?php if (!empty($chat_mate['new_messages_amount'])) : ?>
                    <i class="messages__indicator"><?= $chat_mate['new_messages_amount'] ?></i>
                    <?php endif; ?>
                  </div>
                  <div class="messages__info">
                  <span class="messages__contact-name">
                    <?= $chat_mate['login'] ?>
                  </span>
                    <?php if (isset($chat_mate['last_message'])): ?>
                    <div class="messages__preview">
                      <p class="messages__preview-text">
                        <?php if ($chat_mate['last_message_author_id'] == $_SESSION['user_data']['id']) : ?>
                         Вы:
                        <?php endif; ?>
                        <?= htmlspecialchars($chat_mate['last_message']) ?>
                      </p>
                      <time class="messages__preview-time" datetime="<?= $chat_mate['last_message_date'] ?>">
                        <?php
                        $today = date_create("now");
                        $today = date_format($today, 'Y-m-d');
                        $message_date = date_create($chat_mate['last_message_date']);
                        $message_date_formatted = date_format($message_date, 'Y-m-d');
                        if ($today == $message_date_formatted) {
                            $message_date = date_format($message_date, 'G:i');
                        } else {
                            $message_date = date_format($message_date, 'j F');
                        }
                        ?>
                        <?= $message_date ?>
                      </time>
                    </div>
                  <?php endif; ?>
                  </div>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php if (isset($_GET['chat_mate_id'])): ?>
        <div class="messages__chat">
          <div class="messages__chat-wrapper">
            <ul class="messages__list tabs__content tabs__content--active">
              <?php foreach ($chat_messages_array as $message_id => $message): ?>
              <li class="messages__item <?= ($message['user_id'] == $_SESSION['user_data']['id']) ? "messages__item--my" : "" ?>">
                <div class="messages__info-wrapper">
                  <div class="messages__item-avatar">
                    <a class="messages__author-link" href="profile.php?user_id=<?= $message['user_id'] ?>">
                      <img class="messages__avatar" src="img/<?= $message['avatar'] ?>" alt="Аватар пользователя">
                    </a>
                  </div>
                  <div class="messages__item-info">
                    <a class="messages__author" href="profile.php?user_id=<?= $message['user_id'] ?>">
                      <?= $message['user'] ?>
                    </a>
                    <time class="messages__time" datetime="<?= $message['message_date'] ?>">
                      <?= post_date_ago($message['message_date']) ?>
                    </time>
                  </div>
                </div>
                <p class="messages__text">
                  <?= htmlspecialchars($message['message_content']) ?>
                </p>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <div class="comments">
            <form class="comments__form form" action="messages.php" method="post">
              <div class="comments__my-avatar">
                <img class="comments__picture" src="img/<?= $_SESSION['user_data']['avatar'] ?>" alt="Аватар пользователя">
              </div>
              <div class="form__input-section  <?= (!empty($_SESSION['chat_message_error'])) ? "form__input-section--error" : "" ?>">
                <textarea class="comments__textarea form__textarea form__input"
                          placeholder="Ваше сообщение" name="message"></textarea>
                <label class="visually-hidden">Ваше сообщение</label>
                <button class="form__error-button button" type="button">!</button>
                <div class="form__error-text">
                  <h3 class="form__error-title">Ошибка валидации</h3>
                  <p class="form__error-desc"><?= $_SESSION['chat_message_error'] ?></p>
                </div>
              </div>
              <input type="hidden" name="recipient_id" value="<?= $chat_mate_id ?>">
              <button class="comments__submit button button--green" type="submit">Отправить</button>
            </form>
          </div>
        </div>
      <?php endif; ?>
      </section>
    </main>