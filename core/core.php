<?
// Definice konstant
define("ROOT_DIR", getcwd());
define("LIBS", ROOT_DIR . "/libs/");
define("CORE", ROOT_DIR . "/core/");
define("OLD", PHP_VERSION_ID < 50400);

// Autoloading
require_once(CORE . "Autoloader.php");
if(OLD) {
	require_once(CORE . "smarty/Smarty.class.php");
	require_once(LIBS . "Core/Core.php");
}
Autoloader::setAutoloadExtensions();
Autoloader::setLibsDirPath(LIBS);
spl_autoload_register("Autoloader::load");

// Inicializace tříd
$Core = new Core();