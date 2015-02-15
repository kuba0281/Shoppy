<?
class Autoloader {
	private static $pathExceptions = array(
		"Smarty" => "./core/smarty/Smarty.class.php",
	);

	private static $libsDirPath;

	public static function setAutoloadExtensions() {
		spl_autoload_extensions('.php,.inc');
	}

	public static function setLibsDirPath($libsDirPath) {
		self::$libsDirPath = $libsDirPath;
	}

	public static function load($className) {
		$classNameFirstUpper = ucfirst($className);
		if(self::isClassInExceptions($className)) {
			require_once(self::$pathExceptions[$className]);
		} else {
			if(file_exists("./libs/$classNameFirstUpper/$classNameFirstUpper.php")) {
				require_once("./libs/$classNameFirstUpper/$classNameFirstUpper.php");
			}
		}
	}

	private static function isClassInExceptions($className) {
		return key_exists($className, self::$pathExceptions);
	}
}