<?php

namespace Decapitated\Api\Database;

use Decapitated\Api\System\Singleton;

final class DatabaseManager extends Singleton {
	protected $dbConfig = [];

	protected $mysqli = null;

	/**
	 * Private ctor so nobody else can instance it
	 */
	protected function __construct() {
		$config = include($_SERVER['DOCUMENT_ROOT'] . '/api/config/config.php');
		if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === 'localhost') {
			$this->dbConfig = $config['local']['database'];
		} else {
			$this->dbConfig = $config['live']['database'];
		}
	}

	/**
	 * @return \mysqli
	 */
	public function connect() {
		$dbConfig = $this->dbConfig;
		$mysqli = new \mysqli($dbConfig["host"], $dbConfig["user"], $dbConfig["password"], $dbConfig["database"]);
		if ($mysqli->connect_errno) {
			die("Connection error: " . $mysqli->connect_error);
		}
		$this->mysqli = $mysqli;

		return $mysqli;
	}

	/**
	 * @return array
	 */
	public function initDatabase() {
		$conn = new \mysqli($this->dbConfig["host"], $this->dbConfig["user"], $this->dbConfig["password"]);
		$sql_create_database = 'CREATE DATABASE IF NOT EXISTS ' . $this->dbConfig['database'];
		if ($conn->query($sql_create_database) === TRUE) {
			return $this->initSql();
		} else {
			return ['error' => $conn->error];
		}
	}

	/**
	 * @return array
	 */
	protected function initSql() {
		$sqlDirPath = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'sql';
		$queries = [];
		$files = [];
		$errors = [];
		if ($handle = opendir($sqlDirPath)) {
			while (false !== ($file = readdir($handle))) {
				if($file != "." && $file != "..") {
					array_push($files, $file);
					$conn = $this->connect();
					if( $conn->multi_query(file_get_contents($sqlDirPath.DIRECTORY_SEPARATOR.$file)) ) {
						array_push($queries, ['file' => $file, 'error' => ($conn->errno !== 0) ]);
					} else {
						array_push($errors, $conn->error);
					}
					$conn->close();
				}
			}
		}
		return ['file' => $files, 'query' => $queries, 'errors' => $errors, 'database' => $this->dbConfig['database']];
	}

}