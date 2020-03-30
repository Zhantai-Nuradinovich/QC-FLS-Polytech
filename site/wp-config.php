<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'std_1309' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'std_1309' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '123456789Zhantai' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'std-mysql' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'cWod@~o*JsfIpfw?4}qC+~p_Z<BU&ev:z6*?|kT}OoJA:<9$*M0v0XJee!b{P=vv' );
define( 'SECURE_AUTH_KEY',  'Gyj%2K@mTz|pq)sdCKe.DM/|:`kF}b7]{K?+xLiYzLCy4:SPrV$UAHvR(D_ e+EF' );
define( 'LOGGED_IN_KEY',    'fVj*KS-G*sgT_4r5!J;!8^~xEm*LvfpK&;XtQw/&v`Q5Zqn@bBc.^M~A,.K|oYTv' );
define( 'NONCE_KEY',        '7|ZkMQo4XBN9P*6Le1)62X^`+Cm^?/Li(qM$M!JaW#3#)(Eh~!X,+rgvR%D9,MzR' );
define( 'AUTH_SALT',        'Mig70r{+Lu^K7P,pJ^^GFd}+U].poO:{^j=p~F.U~[>%iUvS%GH}xft0Uhm2=n_?' );
define( 'SECURE_AUTH_SALT', 'TE8d}7N=!bcy7__!kkQ;!i@`ysK<`H6PKs(&-pZHP/n<L-Boe6{:B+5$HI_q]=Vy' );
define( 'LOGGED_IN_SALT',   '`b@PiCVH+Ky`w8|#BeWiW,;+5#PnNt2Utf;Bjw%gLJ~sgXJZHM(>&*_ndE_,^2*a' );
define( 'NONCE_SALT',       '^7^0[RcO)p,ePj?<0cr08b#/P0C*9?o.I2bcJe#T}6l/b==lH($8u{J}/3S%{?!H' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
