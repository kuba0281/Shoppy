<?php
class Autoloader {
	private static $pathExceptions = [
		"Smarty" => "/core/smarty/Smarty.class.php",
	];

	public static function setAutoloadExtensions() {
		spl_autoload_extensions('.php,.inc');
	}

	public static function load($className) {
		$classNameFirstUpper = ucfirst($className);
		if(self::isClassInExceptions($className)) {
			require_once(self::$pathExceptions[$className]);
		} else {
			require_once("/libs/$classNameFirstUpper/$classNameFirstUpper.php");
		}
	}

	private static function isClassInExceptions($className) {
		return key_exists($className, self::$pathExceptions);
	}
}