<?php  

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'Applications' . DS . 'MAMP' . DS . 'htdocs' . DS . 'portfolio_oop');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'includes');

require_once('config.php');
require_once('database.php');
require_once('db_object.php');
require_once('user.php');
require_once('functions.php');
require_once('paginate.php');
require_once('note.php');
require_once('contact.php');
session_start();