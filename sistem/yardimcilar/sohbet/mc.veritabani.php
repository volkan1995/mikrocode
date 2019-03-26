<?php
if (!defined('mdb_guvenlik')) { exit; }
/* Connection Details */
define("mdb_driver", "mysql");
define("mdb_ctype", "pdo");
define("mdb_server", "localhost");
define("mdb_port", "");
define("mdb_name", "toplama");
define("mdb_user", "root");
define("mdb_pass", "");

/* Users Table Details */
define("mdt_users", "kullanicilar");
define("mdt_users_name", "kadi");
define("mdt_users_id", "id");

/* Messages Table Details */
define("mdt_messages", "mesajlasma");
define("mdt_messages_uniq", "oturum");
define("mdt_messages_id", "id");
define("mdt_messages_text", "mesaj");
define("mdt_messages_user", "kullanici");
define("mdt_messages_datetime", "tarih");