<?php

    define('DB_USER', 'groot');
    define('DB_PASSWORD', 'Avengers');
    define('DB_NAME', 'mini_projet');
    define('DB_SERVER', 'localhost');
    $mysqlDsn = "mysql:host=".DB_SERVER.";dbname=".DB_NAME.';charset=utf8'.";";
    define('DB_DSN', $mysqlDsn);

?>