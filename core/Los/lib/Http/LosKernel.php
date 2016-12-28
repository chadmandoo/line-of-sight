<?php

namespace Los\Core\Http;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
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
    private $finder;

    /**
     * LosKernal constructor.
     * @param ControllerResolverInterface $resolver
     * @param ArgumentResolverInterface   $argumentResolver
     * @param TaggedContainerInterface    $container
     * @param Finder                      $finder
     */
    public function __construct(ControllerResolverInterface $resolver, ArgumentResolverInterface $argumentResolver, TaggedContainerInterface $container, Finder $finder)
    {
        $this->resolver = $resolver;
        $this->argumentResolver = $argumentResolver;
        $this->finder = $finder;
        $this->container = $container;
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
            return new Response($e->getMessage());
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
            ->addArgument($this->serviceEntityInfo());
        $this->container->register('request', 'Los\Core\Http\RequestWrapper')
            ->addArgument($request);
        $this->container->register('entity.manager', 'Los\Core\Entity\EntityManagerWrapper')
            ->addArgument(new Reference('entity.info'));
    }

    /**
     * Set up entity information.
     *
     * @return array|mixed
     */
    private function serviceEntityInfo()
    {
        $entities = array();
        $entityFinder = new Finder();
        $entityFinder->files()->name('entity.json')->in(APP_PATH_SRC);
        foreach ($entityFinder as $file) {
            $entity = json_decode(file_get_contents($file->getRealPath()), true);

            if ($entity) {
                $entities += $entity;
            }
        }

        return $entities;
    }

    /**
     * Handle request
     *
     * @param Request $request
     */
    private function serviceRequest(&$request)
    {
        $routeCollection = new RouteCollection();

        $entityLocations = array();
        $finder = new Finder();
        $finder->files()->name('routes.json')->in(APP_PATH_SRC);
        foreach ($finder as $file) {
            $entityLocations[] = $file->getRealPath();
        }

        foreach ($entityLocations as $location) {
            $routes = json_decode(file_get_contents($location), true);
            foreach ($routes as $key => $route) {
                $routeAdd = new Route($route['path'], array('_controller' => $route['_controller']));
                $routeCollection->add($key, $routeAdd);
            }
        }

        $matcher = new UrlMatcher($routeCollection, new RequestContext());
        $match = $matcher->matchRequest($request);
        $request->attributes->add($match);
    }
}
