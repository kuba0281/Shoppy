<?
class Autoloader {
	/**
	 * Třídy, které se nenachází ve výchozí Libs složce
	 * @var array
	 */
	private static $pathExceptions = [
		"Smarty" => "./core/smarty/Smarty.class.php",
	];

	/**
	 * Cesta k výchozí Libs složce
	 * @var string
	 */
	private static $libsDirPath;

	/**
	 * Nastaví pořadí přípon pro autoloader (zvýšení rychlosti)
	 */
	public static function setAutoloadExtensions() {
		spl_autoload_extensions('.php,.inc');
	}

	/**
	 * Nastaví cestu k výchozí Libs složce
	 * @param string $libsDirPath
	 */
	public static function setLibsDirPath($libsDirPath) {
		self::$libsDirPath = $libsDirPath;
	}

	/**
	 * Metoda pro autoloading tříd
	 * @param string $className
	 */
	public static function load($className) {
		$classNameFirstUpper = ucfirst($className);
		if(self::isClassInExceptions($className)) {
			require_once(self::$pathExceptions[$className]);
		} else {
			if(file_exists(self::$libsDirPath . "$classNameFirstUpper/$classNameFirstUpper.php")) {
				require_once(self::$libsDirPath . "$classNameFirstUpper/$classNameFirstUpper.php");
			}
		}
	}

	/**
	 * Vrátí, jestli se jedná o výjimku
	 * @param string $className
	 * @return boolean
	 */
	private static function isClassInExceptions($className) {
		return key_exists($className, self::$pathExceptions);
	}
}