<?php

namespace Decapitated\Api\Service;

use Decapitated\Api\System\Singleton;

class ConfigService extends Singleton {

	protected $defaultConfiguration = [
		'database' => [
			'host' => 'localhost',
			'user' => 'root',
			'password' => '',
			'database' => 'decapitated'
		],
		'baseDir' => 'http://decapitated.local',
		'testField' => 'test1'
	];

	/**
	 * @return array
	 */
	public function getConfig() {
		$config = $this->getDefaultConfiguration();
		if(file_exists($this->getPathToConfig())) {
			$config = json_decode(file_get_contents($this->getPathToConfig()));
		}
		return $config ? $config : [];
	}

	/**
	 * @return string
	 */
	public function getPathToConfig() {
		return implode(DIRECTORY_SEPARATOR, [$_SERVER["DOCUMENT_ROOT"], 'api', 'config', 'localConfig.php']);
	}

	/**
	 * @return array
	 */
	public function getDefaultConfiguration(): array {
		return $this->defaultConfiguration;
	}
}