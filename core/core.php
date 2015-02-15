<?

define("ROOT_DIR", getcwd());
define("LIBS", ROOT_DIR . "/libs/");
define("CORE", ROOT_DIR . "/core/");

require_once(CORE . "Autoloader.php");
Autoloader::setAutoloadExtensions();
spl_autoload_register(function($className) {
	Autoloader::load($className);
});

$Core = new Core();