<?
class Settings {
	/**
	 * @var \Database
	 */
	private $Database;
	/**
	 * @var array
	 */
	public $settings;

	public function __construct(PDO $Database) {
		$this->Database = $Database;
		$this->loadSettings();
	}

	/**
	 * Načte z databáze všechny hodnoty z tabulky settings
	 * @return \Settings
	 */
	private function loadSettings() {
		$SettingsResult = $this->Database->prepare("SELECT name, value FROM settings");
		$SettingsResult->execute();
		$this->settings = $this->createSettingsArray($SettingsResult);

		return $this;
	}

	/**
	 * Vytvoří pole hodnot z tabulky settings "name" => "value"
	 * @param PDOStatement $SettingsResult
	 * @return array
	 */
	private function createSettingsArray(PDOStatement $SettingsResult) {
		$settings = [];
		while($SettingsRow = $SettingsResult->fetch()) {
			$settings[$SettingsRow["name"]] = $SettingsRow["value"];
		}

		return $settings;
	}

	/**
	 * Vrátí hodnotu z tabulky settings
	 * @param string $name
	 * @return string
	 */
	public function getValue($name) {
		return $this->settings[$name];
	}

	/**
	 * Zapíše hodnotu do tabulky settings
	 * @param string $name
	 * @param string $value
	 * @return \Settings
	 */
	public function setValue($name, $value) {
		$Statement = $this->Database->prepare("
			INSERT INTO settings (name, value) VALUES (:name, :value)
			ON DUPLICATE KEY UPDATE value = :value");
		$Statement->execute([
			":name" => $name,
			":value" => $value,
		]);

		return $this;
	}
}