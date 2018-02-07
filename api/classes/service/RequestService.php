<?php
namespace Decapitated\Api\Service;

use Klein\Request;
use Decapitated\Api\System\Singleton;

class RequestService extends Singleton {

	/** @var string */
	private $defaultActionName = 'list';

	/**
	 * @param Request $request
	 * @param string  $controllerName
	 * @param string  $actionName
	 * @return string
	 * @throws \ReflectionException
	 */
	public function callControllerAction(Request $request, string $controllerName, ?string $actionName) {
		$controllerName = 'Decapitated\\Api\\Controller\\' . ucfirst($controllerName) . 'Controller';
		$actionName = ($actionName ? $actionName : $this->defaultActionName) . 'Action';

		$controller = new $controllerName; // TODO use singleton and/or object manager

		$paramNames = $this->getMethodArgumentNames($controllerName, $actionName);
		$params = $this->getRequestArguments($request, $paramNames);

		// set access controller headers
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

		// TODO create flash message service to store messages
		// TODO append flash messages to response

		// call action in controller with the given parameters
		return json_encode(call_user_func_array(array($controller, $actionName), $params));

	}

	/**
	 * @param Request $request
	 * @param array   $paramNames
	 * @return array
	 */
	private function getRequestArguments(Request $request, array $paramNames): array {
		$params = [];

		$body = json_decode($request->body());
		foreach ($paramNames as $paramName) {
			$params[$paramName] = $request->param($paramName) ? $request->param($paramName) : NULL;
			if(isset($body->{$paramName})) {
				$params[$paramName] = $body->{$paramName};
			}
		}

		return $params;
	}

	/**
	 * @param string $class
	 * @param string $method
	 * @return array
	 * @throws \ReflectionException
	 */
	private function getMethodArgumentNames(string $class, string $method): array {
		$reflectionMethod = new \ReflectionMethod($class, $method);
		$params = $reflectionMethod->getParameters();

		return array_map(function (\ReflectionParameter $item) {
			return $item->getName();
		}, $params);
	}

	/**
	 * checks the authorization header for a (Bearer) token and returns it if one is found
	 * @return bool|null|string
	 */
	public function getAuthorizationTokenFromHeader() {
		$headers = apache_request_headers();
		if(isset($headers["Authorization"])) {
			$needle = 'Bearer ';
			return strpos($headers["Authorization"], $needle) === 0 ?
				substr($headers["Authorization"], strlen($needle)) :
				$headers["Authorization"];
		}
		return NULL;
	}
}