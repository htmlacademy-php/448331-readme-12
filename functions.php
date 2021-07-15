<?php

function added_photo_validation ($value) {
  if ($file_type !== 'image/gif' || $file_type !== 'image/png' || $file_type !== 'image/jpeg') {
    return 'Пожалуйста, загрузите картинку в формате Gif, PNG или JPEG';
  }
  return null;
}

function video_link_validation ($value) {
    if (empty($value)) {
        return 'Адрес ссылки на видео должен быть заполнен';
    }
    if (!filter_var($value, FILTER_VALIDATE_URL)) {
        return 'Пожалуйста, проверьте и введите корректный адрес ссылки';
    }
    $result = check_youtube_url($value);
    if ($result !== true) {
        return $result;
    }
}


function photo_link_validation ($value) {
    if (empty($value) & !isset($_FILES['added-photo-file'])) {
        return 'Адрес ссылки должен быть заполнен';
    }
    if (!filter_var($value, FILTER_VALIDATE_URL) & !isset($_FILES['added-photo-file'])) {
        return 'Введите корректный адрес ссылки';
    }

    return null;
}

function not_empty_field($value) {
    if (empty($value)) {
        return 'Поле должно быть заполнено';
    }
    return null;
}


function validate_tags($value): ?string {             // функция валидации тегов
    if (empty($value)) {
        return 'Поле должно быть заполнено';
    }

    $tag_array = array_filter(explode(' ', $value));

    foreach ($tag_array as $tag) {
        if (!boolval(preg_match('/^[a-zA-Zа-яёА-ЯЁ0-9_]+$/u', $tag))) {
            return 'Введите корректный тег';
        }
    }

    return null;
}

function getPostVal($name) {
    return $_POST[$name] ?? "";
}

function is_error_field ($value) {
    if (empty($value)) {
        return null;
    } else {
        return 'form__input-section--error';
    }
}

function is_active_form ($value1, $value2) {
    if ($value1 == $value2) {
        return 'filters__button--active tabs__item--active';
    }
}

?>