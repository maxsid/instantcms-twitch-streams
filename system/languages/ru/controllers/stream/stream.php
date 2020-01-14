<?php

define('LANG_STREAM_ADD', 'Добавить канал');
define('LANG_STREAM_YOUR_CHANNEL','Ваш канал');
define('LANG_STREAM_YOUR_CHANNELS','Ваши каналы');
define('LANG_STREAM_ADDING_CHANNEL','Добавление канала %s');
define('LANG_STREAM_ADDED_CHANNEL_IS_SUCCESS','Канал %s успешно добавлен. Заполните форму и канал станет активным.');
define('LANG_STREAM_NAME_TWITCH_CHANNEL','Имя Twitch канала');
define('LANG_STREAM_CAPTION_CHANNEL_NAME','Канал: %s');
define('LANG_STREAM_DELETE_CHANNEL','Удалить канал');
define('LANG_STREAM_DELETE_CHANNEL_CANCELLED','Удаление не подтверждено. Канал не удален.');
define('LANG_STREAM_DELETING_CHANNEL','Вы уверены что хотите удалить канал %s?');
define('LANG_STREAM_DELETED_CHANNEL_IS_SUCCESS','Канал успешно удален');
define('LANG_STREAM_CONTROLLER', 'Стримы');
define('LANG_STREAM_CHANNELS','Каналы');
define('LANG_STREAM_TO_CHANNEL','К каналу');
define('LANG_STREAM_ALL_CHANNELS', 'Все каналы');
define('LANG_STREAM_ONLINE_CHANNELS','Каналы в сети');
define('LANG_STREAM_OFFLINE_CHANNELS', 'Каналы не в сети');
define('LANG_STREAM_USER_CHANNELS','Каналы пользователя');
define('LANG_STREAM_TITLE', 'Название канала');
define('LANG_STREAM_URL', 'Ссылка на канал');
define('LANG_STREAM_DESCRIPTION', 'Описание канала');
define('LANG_STREAM_LOGO', 'Логотип канала');
define('LANG_STREAM_RECOMMENDED_RATIO','рекомендуемое соотношение 16:9');
define('LANG_STREAM_EDIT', 'Редактировать канал');
define('LANG_STREAM_AUTHENTICATION', 'Разрешения Twitch аккаунта');
define('LANG_STREAM_SET_TWITCH_CLIENT_ID','Изменить Twitch ClientID');
define('LANG_STREAM_SET_TWITCH_CLIENT_ID_IS_SUCCESS', 'ClientID и Client Secret успешно изменены!');
define('LANG_STREAM_SET_AUTHENTICATION_IS_SUCCESS', 'Доступ к вашему Twitch аккаунту успешно получен!');
define('LANG_STREAM_MISSING_SCOPE','Для выполнения этого действия нужны следующие разрешения: %s. <a href="%s">Получить</a>');
define('LANG_STREAM_MISSING_TWITCH_CONNECT','Для выполнения операции требуется доступ к вашему аккаунту Twitch. <a href="%s">Подключить</a>');
define('LANG_STREAM_CHANNEL', 'Канал');
define('LANG_STREAM_CHANNEL_BAN', 'Забанить канал');
define('LANG_STREAM_CHANNEL_DESCRIPTION','Описание канала');
define('LANG_STREAM_CHANNEL_BAN_IS_ACCESS','Канал %s успешно забанен');
define('LANG_STREAM_CHANNEL_UNBAN_IS_ACCESS','Канал %s успешно разбанен');
define('LANG_STREAM_CHANNEL_BAN_REASON','Причина блокировки');
define('LANG_STREAM_BAN_OWNER','Забанил канал');
define('LANG_STREAM_MISSING_CHANNELS','Пусто');
define('LANG_STREAM_ADD_CHANNEL_DATE','Добавлен');
define('LANG_STREAM_BANNED','Забанен');
define('LANG_STREAM_UNBAN','Разбанить');
define('LANG_STREAM_BANNED_CHANNELS','Забаненные каналы');
define('LANG_STREAM_UNPIN','Открепить канал');
define('LANG_STREAM_UNPINED','Канал успешно откреплен');
define('LANG_STREAM_OWNER', 'Владелец');
define('LANG_STREAM_ADDED_TIME','Зарегистрирован');
define('LANG_STREAM_DISPLAYED_NAME','Отображаемое имя');
define('LANG_STREAM_ACTIVE','Активирован');
define('LANG_STREAM_PIN_CHANNEL','Закрепить канал');
define('LANG_STREAM_PINNED_IS_SUCCESS','Позиция %s успеншно закреплена');
define('LANG_STREAM_PINNED_POSITION','Позиция');
define('LANG_STREAM_PINNED_CHANNELS','Закрепленные каналы');
define('LANG_STREAM_PINNED','Закрепленаня позиция');
define('LANG_STREAM_PINNED_HINT','Чем ниже число, тем больше приоритет канала. 0 - не закреплено');
define('LANG_STREAM_CHANGING_PIN_POSITION','Изменение закрепленной позиции канала %s');
define('LANG_STREAM_ERROR_ACCESS_DENIED', 'Ошибка доступа!');
define('LANG_STREAM_ERROR_ACCESS_MISSING', 'Соединение с Twitch не установлено!');
define('LANG_STREAM_ERROR_BAD_REQUEST', 'Получен отказ от сервера Twitch. Попробуйте позже или обратитесь к администратору.');
define('LANG_STREAM_ERROR_CHANNEL_NOT_FOUND', 'Канал %s не найден на Twitch.');
define('LANG_STREAM_ERROR_CHANNEL_UNPROCESSABLE_ENTITY','Канал с именем %s не допустим на Twitch');
define('LANG_STREAM_ERROR_UNAUTHORIZED','Вы не авторизованы. <a href="%s">Авторизоваться</a>');
define('LANG_STREAM_ERROR_NO_MORE_CHANNEL','Вы имеете максимум возможных каналов. Чтобы добавить новый, удалите предыдущий.');
define('LANG_STREAM_ERROR_CHANNEL_THIS_NAME_REGISTERED','Канал %s уже зарегистрирован на сайте.');
define('LANG_STREAM_ERROR_MISSING_AUTH_INFO','Отсутсвуют необходимые данные');
define('LANG_STREAM_ERROR_CHANNEL_IS_BANNED','Канал %s забанен. Причина: %s');
define('LANG_STREAM_ERROR_CHANNEL_IS_BANNED_FULL','Канал %s <b>забанен</b> %s.<br>Причина блокировки:<br> %s');
define('LANG_STREAM_ERROR_CHANNEL_IS_BANNED_ADMIN_FULL','Канал %s <b>забанен</b> %s.<br>Причина блокировки:<br> %s.<br><b><a href="%s">Разбанить</a></b>');
define('LANG_STREAM_SCOPE_INFO_USER_READ', 'USER_READ: Просмотр адреса электронной почты');
define('LANG_STREAM_SCOPE_INFO_USER_BLOCKS_EDIT','USER_BLOCK_EDIT: Блокировка пользователей от вашего имени');
define('LANG_STREAM_SCOPE_INFO_USER_BLOCKS_READ','USER_BLOCK_READ: Просмотр пользователей, которых вы заблокировали');
define('LANG_STREAM_SCOPE_INFO_USER_FOLLOWS_EDIT','USER_FOLLOW_EDIT: Управление каналами, на которые вы подписаны');
define('LANG_STREAM_SCOPE_INFO_CHANNEL_READ','CHANNEL_READ: Посмотреть адрес электронной почты и ключ потока вашего канала');
define('LANG_STREAM_SCOPE_INFO_CHANNEL_EDITOR','CHANNEL_EDITOR: Обновление названия канала, игры, статуса и других метаданных и прекращение передачи видео по запросу');
define('LANG_STREAM_SCOPE_INFO_CHANNEL_COMMERCIAL','CHANNEL_COMMERCIAL: Запустить рекламу на вашем канале');
define('LANG_STREAM_SCOPE_INFO_CHANNEL_STREAM','CHANNEL_STREAM: Повторно установить ваш ключ потока');
define('LANG_STREAM_SCOPE_INFO_CHANNEL_SUBSCRIPTIONS','CHANNEL_SUBSCRIPTIONS: Получить список всех подписчиков вашего канала');
define('LANG_STREAM_SCOPE_INFO_USER_SUBSCRIPTIONS','USER_SUBSCRIPTIONS: Просмотр платных подписок');
define('LANG_STREAM_SCOPE_INFO_CHANNEL_CHECK_SUBSCRIPTIONS','CHANNEL_CHECK_SUBSCRIPTIONS: Проверить наличие у пользователя подписки на ваш канал');
define('LANG_STREAM_SCOPE_INFO_CHAT_LOGIN','CHAT_LOGIN: Вход в раздел чата и отправка сообщений');
define('LANG_STREAM_COUNT_STREAMS_ON_PAGE','Количество стримов на странице');
define('LANG_STREAM_HIDE_CHAT','Скрывать чат');
define('LANG_STREAM_ALREADY_PINNED','Канал уже закреплен. Изминить позицию можно в админке.');
define('LANG_STREAM_ERROR_MISSING_API_KEYS','Отсутвуют ключи к API Twitch. Пожалуйста, сообщите об этом администратору сайта.');
define('LANG_STREAM_OPTIONS_PLAYER_SIZE','Размер плеера');
define('LANG_STREAM_OPTIONS_CHAT_SIZE','Размер чата');
define('LANG_STREAM_WIDTH','Ширина');
define('LANG_STREAM_HEIGHT','Высота');
define('LANG_STREAM_OPTIONS_DELETE_INACTIVE_AFTER','Удалять неактивные каналы через');
define('LANG_STREAM_OPTIONS_DELETE_INACTIVE_AFTER_HINT',"(в минутах).\n Хук - 'delete_inactive'.");
define('LANG_STREAM_OPTIONS_COUNT_ALL_CHANNELS','Всего каналов: %s');
define('LANG_STREAM_OPTIONS_COUNT_ACTIVE_CHANNELS','Активных каналов: %s');
define('LANG_STREAM_OPTIONS_COUNT_INACTIVE_CHANNELS','Неактивных каналов: %s');



/* Доступ */
define('LANG_RULE_STREAM_ADD_CHANNELS','Добавлять каналы');
define('LANG_RULE_STREAM_ADD_CHANNEL_MODE',"Добавлять каналы без аутентификации пользователя\n(Позволяет добавлять не свои каналы)");
define('LANG_RULE_STREAM_MAX_COUNT','Максимальное количество каналов');
define('LANG_RULE_STREAM_VIEW_LIST_CHANNELS','Просматривать список каналов пользователя');
define('LANG_RULE_STREAM_VIEW_INACTIVE_CHANNELS','Показывать неактивные каналы в списках(кроме online, offline и all)');
define('LANG_RULE_STREAM_DELETE_CHANNELS','Удалять каналы');
define('LANG_RULE_STREAM_EDIT_CHANNELS','Редактировать каналы');
define('LANG_RULE_STREAM_PIN_CHANNELS','Закреплять каналы');
define('LANG_RULE_STREAM_BAN_CHANNELS','Банить каналы');

