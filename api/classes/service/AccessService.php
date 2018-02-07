<?php

namespace Decapitated\Api\Service;

use Firebase\JWT\JWT;
use Decapitated\Api\System\Singleton;

class AccessService extends Singleton {

	protected $privateKey = "example_key"; // TODO get key from configuration

	protected $accessPeriod = 'PT36S'; // TODO move to settings

	/**
	 * @param string $username
	 * @param string $password
	 * @return string
	 * @throws \Exception
	 */
	public function getAccessToken(string $username, string $password) {
		// TODO check user credentials with database

		$now = new \DateTime();
		$expirationDate = new \DateTime();
		$expirationDate->add(new \DateInterval($this->accessPeriod));

		$token = array(
			"nbf"       => $now->getTimestamp(),
			"iat"       => $now->getTimestamp(),
			"exp"       => $expirationDate->getTimestamp(),
			"domain"    => "marry-on.de",
			"user"      => $username,
			"createdAt" => $now->format(DATE_ISO8601)
		);

		/**
		 * IMPORTANT:
		 * You must specify supported algorithms for your application. See
		 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
		 * for a list of spec-compliant algorithms.
		 */
		return JWT::encode($token, $this->privateKey);
	}

	/**
	 * @param string $token
	 * @return bool
	 * @throws \Exception
	 */
	public function hasAccess(string $token) {
		return $this->getTokenExpirationDate($token) > (new \DateTime());
	}

	/**
	 * @param string $token
	 * @return \DateTime
	 * @throws \Exception
	 */
	public function getTokenExpirationDate(string $token) {
		$decodedToken = $this->decodeToken($token);
		if ($decodedToken instanceof \stdClass && isset($decodedToken->createdAt)) {
			$validUntil = new \DateTime($decodedToken->createdAt);;
			$validUntil->add(new \DateInterval($this->accessPeriod ));
			return $validUntil;
		}
		return new \DateTime();
	}

	/**
	 * @param string $format
	 * @return string
	 * @throws \Exception
	 */
	public function getAccessPeriod($format = '%s') {
		return (new \DateInterval($this->accessPeriod))->format($format);
	}

	/**
	 * @param string $token
	 * @return object
	 */
	private function decodeToken(string $token) {
		try {
			return JWT::decode($token, $this->privateKey, array('HS256'));
		} catch (\Exception $e) {
			return NULL;
		}
	}
}