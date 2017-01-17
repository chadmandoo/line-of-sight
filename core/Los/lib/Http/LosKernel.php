<?php

namespace Los\Core\Http;

use Los\Core\Config\LosConfig;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class LosKernal
 *
 * @package Symfony\Component\HttpKernel
 */
class LosKernel implements HttpKernelInterface
{
    private $resolver;
    private $argumentResolver;
    private $container;
    private $config;
    private $finder;

    /**
     * LosKernal constructor.
     * @param ControllerResolverInterface $resolver
     * @param ArgumentResolverInterface   $argumentResolver
     * @param TaggedContainerInterface    $container
     * @param LosConfig                   $config
     * @param Finder                      $finder
     */
    public function __construct(ControllerResolverInterface $resolver, ArgumentResolverInterface $argumentResolver, TaggedContainerInterface $container, LosConfig $config, Finder $finder)
    {
        $this->resolver = $resolver;
        $this->argumentResolver = $argumentResolver;
        $this->container = $container;
        $this->config = $config;
        $this->finder = $finder;
    }

    /**
     * Handle request
     *
     * @param Request $request
     * @param int     $type
     * @param bool    $catch
     * @return mixed
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = false)
    {
        $request->headers->set('X-Php-Ob-Level', ob_get_level());
        $this->serviceRequest($request);
        $this->containerSetup($request);

        try {
            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            $controllerName = $controller[0];
            $controllerObj = new $controllerName();
            $controllerObj->setContainer($this->container, $request);

            return call_user_func_array(array($controllerObj, $controller[1]), $arguments);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage());
        }
    }

    /**
     * Set up container for controller to use.
     *
     * @param $request
     */
    private function containerSetup($request)
    {
        $this->container->register('serializer', 'Los\Core\Serializer\SerializerWrapper');
        $this->container->register('entity.info', 'Los\Core\Entity\EntityInfo')
            ->addArgument($this->config->getEntityInfo());
        $this->container->register('request', 'Los\Core\Http\RequestWrapper')
            ->addArgument($request);
        $this->container->register('entity.manager', 'Los\Core\Entity\EntityManagerWrapper')
            ->addArgument($this->config)
            ->addArgument(new Reference('entity.info'));
    }

    /**
     * Handle request
     *
     * @param Request $request
     */
    private function serviceRequest(&$request)
    {
        $routeCollection = new RouteCollection();
        $routes = $this->config->getRoutes();

        foreach ($routes as $key => $route) {
            $routeAdd = new Route($route['path'], array('_controller' => $route['_controller'], 'smest' => 'test'));
            $routeCollection->add($key, $routeAdd);
        }

        $matcher = new UrlMatcher($routeCollection, new RequestContext());
        $match = $matcher->matchRequest($request);
        $request->attributes->add($match);
    }
}
