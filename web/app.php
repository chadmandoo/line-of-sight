<?php

/**
 * Bootstrap application.
 */
require __DIR__.'/../app/autoload.php';

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Los\Core\LosBootstrap;
use Los\Core\Http\LosKernel;
use Los\Core\Http\RequestWrapper;

$request = Request::createFromGlobals();
$requestWrapper = new RequestWrapper($request, new UrlMatcher(LosBootstrap::routeSetup(), new RequestContext()));
$requestWrapper->matchRequest();

$kernel = new LosKernel(new ControllerResolver(), new ArgumentResolver(), LosBootstrap::database());
$response = $kernel->handle($requestWrapper->getRequest());
$response->send();
