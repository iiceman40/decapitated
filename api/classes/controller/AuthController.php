<?php
namespace Decapitated\Api\Controller;

use Decapitated\Api\Database\DatabaseManager;
use Decapitated\Api\Service\AccessService;

class AuthController {

	/**
	 * @var DatabaseManager
	 */
	protected $dbManager = NULL;

	/**
	 * @var AccessService
	 */
	protected $accessService = NULL;

	/**
	 * AuthController constructor.
	 */
	public function __construct() {
		$this->dbManager = DatabaseManager::getInstance();
		$this->accessService = AccessService::getInstance();
	}

	/**
	 * @param string $username
	 * @param string $password
	 * @return array
	 */
	public function getTokenAction(string $username, string $password): array {
		return ['token' => $this->accessService->getAccessToken($username, $password)];
	}

	/**
	 * @param string $token
	 * @return array
	 * @throws \Exception
	 */
	public function hasAccessAction(string $token): array {
		return [
			'hasAccess' => $this->accessService->hasAccess($token),
			'expirationDate' => $this->accessService->getTokenExpirationDate($token)->format(DATE_ISO8601),
			'accessPeriod' => $this->accessService->getAccessPeriod()
		];
	}
}