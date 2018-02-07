<?php

namespace Decapitated;

use Decapitated\Api\Service\RequestService;
use Klein\Klein;
use Klein\Request;

$klein = new Klein();

/* GENERAL API REQUESTS */
/** @var RequestService $requestService */
$requestService = RequestService::getInstance();
$generalApiRequestHandler = function (Request $request, $response, $service, $app, $klein, $matched) use ($requestService) {
	if($request->method('options')) {
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
		return NULL;
	}

	// TODO add config file for protected routes
	$protectedActions = [
		['controller' => 'system', 'action' => 'getConfig']
	];

	// TODO implement check for protected routes and if a valid access token was provided if needed

	// iterate over protected actions list and compare controller and action names
	// if no action name is given in the request, assume the default action from the request service
	// if action name in the protectedActions list is a * assume that all actions are protected

	// TODO move authorization check to request service
	$token = $requestService->getAuthorizationTokenFromHeader();

	// TODO check if token is valid and grants permission for the requested action

	// other todos
	// TODO add general route for retrieving data
	// TODO add MessagesService and append stored messages to response

	return count($matched) === 0 ? $requestService->callControllerAction(
		$request, $request->controller, isset($request->action) ? $request->action : NULL
	) : NULL;
};
$klein->respond('GET', '/api/[:controller]s', $generalApiRequestHandler);
$klein->respond('GET', '/api/[:controller]/[:action]', $generalApiRequestHandler);
$klein->respond('GET', '/api/[:controller]/[:action]/', $generalApiRequestHandler);
$klein->respond('POST', '/api/[:controller]/[:action]', $generalApiRequestHandler);
$klein->respond('POST', '/api/[:controller]/[:action]/', $generalApiRequestHandler);
$klein->respond('OPTIONS', '/api/[:controller]/[:action]', $generalApiRequestHandler);
$klein->respond('OPTIONS', '/api/[:controller]/[:action]/', $generalApiRequestHandler);

/* ERROR */
$klein->onHttpError(function ($code, $router) {
	var_dump(['ERROR', $code]);
});

$klein->dispatch();

