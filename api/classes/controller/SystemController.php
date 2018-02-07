<?php
namespace Decapitated\Api\Controller;

use Decapitated\Api\Database\DatabaseManager;
use Decapitated\Api\Service\AccessService;
use Decapitated\Api\Service\ConfigService;

class SystemController {

	/**
	 * @var DatabaseManager
	 */
	protected $dbManager = NULL;

	/**
	 * @var AccessService
	 */
	protected $accessService = NULL;

	/**
	 * @var ConfigService
	 */
	protected $configService = NULL;

	/**
	 * AuthController constructor.
	 */
	public function __construct() {
		$this->dbManager = DatabaseManager::getInstance();
		$this->accessService = AccessService::getInstance();
		$this->configService = ConfigService::getInstance();
	}

	/**
	 * @param array | string $config
	 * @return array
	 */
	public function installAction($config): array {
		// init database tables
		$dbInitResult = $this->dbManager->initDatabase();

		// write config files
		$path = $this->configService->getPathToConfig();
		$messages = [];
		if(file_exists($path) === FALSE) {
			// TODO move writing config files to an more abstract layer
			// TODO * to configService?
			// TODO * or to configManager (rename configService)?
			// TODO * or to configFileRepository?
			$configFile = fopen($path, "w") or die("Unable to open file " . $path . "!");

			$content = is_array($config) || $config instanceof \stdClass ? json_encode($config) : $config;
			fwrite($configFile, $content);
			fclose($configFile);
			$messages['configResult'] = 'local config file initiated';
		}

		return [
			'success'  => TRUE,
			'messages' => $messages,
			'config'   => $this->configService->getConfig(),
			'db'       => $dbInitResult
		];
	}


	public function getConfigAction() {
		return $this->configService->getConfig();
	}
}