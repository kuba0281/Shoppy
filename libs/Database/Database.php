<?
class Database extends PDO {
	/**
	 * @var string
	 */
	private $host;
	/**
	 * @var string
	 */
	private $user;
	/**
	 * @var string
	 */
	private $password;
	/**
	 * @var string
	 */
	private $database;

	public function __construct($database, $host, $user, $password) {
		if($this->isLocalhost()) {
			$this->setLoginData([
				"host" => "localhost",
				"user" => "root",
				"password" => "",
				"database" => $database,
			]);
		} else {
			$this->setLoginData([
				"host" => $host,
				"user" => $user,
				"password" => $password,
				"database" => $database,
			]);
		}
	}

	/**
	 * @param string $host
	 * @return \Database
	 */
	private function setHost($host) {
		$this->host = $host;

		return $this;
	}

	/**
	 * @param string $user
	 * @return \Database
	 */
	private function setUser($user) {
		$this->user = $user;

		return $this;
	}

	/**
	 * @param string $password
	 * @return \Database
	 */
	private function setPassword($password) {
		$this->password = $password;

		return $this;
	}

	/**
	 * @param string $database
	 * @return \Database
	 */
	private function setDatabase($database) {
		$this->database = $database;

		return $this;
	}

	/**
	 * Hromadě nastaví data pro připojení k databázi
	 * @param array $loginData
	 * @return \Database
	 */
	private function setLoginData(Array $loginData) {
		$this
			->setHost($loginData["host"])
			->setUser($loginData["user"])
			->setPassword($loginData["password"])
			->setDatabase($loginData["database"]);

		return $this;
	}

	/**
	 * @return string
	 */
	private function getHost() {
		return $this->host;
	}

	/**
	 * @return string
	 */
	private function getUser() {
		return $this->user;
	}

	/**
	 * @return string
	 */
	private function getPassword() {
		return $this->password;
	}

	/**
	 * @return string
	 */
	private function getDatabase() {
		return $this->database;
	}

	/**
	 * @return string
	 */
	private function getLoginData() {
		return [
			"host" => $this->getHost(),
			"user" => $this->getUser(),
			"password" => $this->getPassword(),
			"database" => $this->getDatabase(),
		];
	}

	/**
	 * True pokud jsme na localhostu
	 * @return boolean
	 */
	private function isLocalhost() {
		return ($_SERVER["SERVER_ADDR"] === "::1" || $_SERVER["SERVER_ADDR"] === "127.0.0.1");
	}

	/**
	 * Sestaví speciální host pro PDO
	 * @return string
	 */
	private function getHostForPDO() {
		return "mysql:dbname=" . $this->getDatabase() . ";host=" . $this->getHost();
	}

	/**
	 * Vratí instanci třídy PDO
	 * @return \PDO
	 */
	public function connect() {
		return new PDO($this->getHostForPDO(), $this->getUser(), $this->getPassword());
	}
}