<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

/**
 * AuthMiddleware
 *
 * @author    Haven Shen <havenshen@gmail.com>
 * @copyright    Copyright (c) Haven Shen
 */
class AuthMiddleware extends Middleware
{

	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = $handler->handle($request);

		if(! $this->container->get('auth')->check()) {
			$this->container->get('flash')->addMessage('error', 'Please sign in before doing that');
			return $response->withHeader('Location', $this->container->get('router')->urlFor('auth.signin'));
		}

		return $response;
	}
}