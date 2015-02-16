<?
class Core {
	/**
	 * Cesta k adresáři s knihovnami
	 */
	const LIBS_DIR = ROOT_DIR . "/libs/";
	/**
	 * Cesta ke Core složce
	 */
	const CORE_DIR = ROOT_DIR . "/core/";
	/**
	 * Cesta k šablonám
	 */
	const TEMPLATE_DIR = ROOT_DIR . "/templates/";
	/**
	 * True pokud je verze PHP starší než 5.4
	 */
	const OLD = PHP_VERSION_ID < 50400;

	/**
	 * @var \PDO
	 */
	public $Database;
	/**
	 * @var \Smarty
	 */
	public $Smarty;
	/**
	 * @var \Settings
	 */
	public $Settings;

	public function __construct() {
		$this
			->initDatabase()
			->initSmarty($this->getTemplatePath())
			->initSettings();
	}

	/**
	 * Vytvoří instanci a nastaví Smarty
	 * @param string $templatePath
	 * @return \Core
	 */
	private function initSmarty($templatePath) {
		$Smarty = new Smarty();

		$Smarty->setTemplateDir($templatePath);
		$Smarty->setCompileDir($templatePath . "cache/compile_tpl");
		$Smarty->setCacheDir($templatePath . "cache/cache_tpl");
		$Smarty->debugging = false;
		$Smarty->compile_check = true;

		$this->setBaseSmartyVariables($Smarty);

		$this->Smarty = $Smarty;

		return $this;
	}

	/**
	 * Vrátí cestu k aktuální šabloně
	 * @return string
	 */
	public function getTemplatePath() {
		$templateNameResult = $this->Database->prepare("SELECT value FROM settings WHERE name = :name");
		$templateNameResult->execute([":name" => "template"]);

		if($templateNameResult->rowCount() > 0) {
			$templateName = $templateNameResult->fetchColumn();
		} else {
			$templateName = "default";
		}

		return self::TEMPLATE_DIR . $templateName . "/index.tpl";
	}

	/**
	 * Nastaví základní proměnné pro Smarty
	 * @param Smarty $Smarty
	 * @return \Core
	 */
	private function setBaseSmartyVariables(Smarty $Smarty) {
		$Smarty->assign("baseURL", "/");

		return $this;
	}

	/**
	 * Vytvoří připojení pro databázi
	 * @return \Core
	 */
	private function initDatabase() {
		$Database = new Database("Shoppy", "localhost", "root", "");
		$this->Database = $Database->connect();

		return $this;
	}

	/**
	 * Vytvoří instanci třídy settings a načte z databáze hodnoty
	 * @return \Core
	 */
	private function initSettings() {
		$Settings = new Settings($this->Database);
		$this->Settings = $Settings;

		return $this;
	}
}