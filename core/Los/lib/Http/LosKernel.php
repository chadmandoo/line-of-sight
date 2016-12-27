<?php

namespace Los\Core\Http;

use Los\Core\Entity\EntityInfo;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

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
        $this->containerSetup($container);
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

        try {
            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            $controllerName = $controller[0];
            $controllerObj = new $controllerName();
            $controllerObj->setContainer($this->container);

            return call_user_func_array(array($controllerObj, $controller[1]), $arguments);
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
    }

    /**
     * Set up container for controller to use.
     *
     * @param $container
     */
    private function containerSetup($container)
    {
        $this->container = $container;
        $this->container->register('entity.manager', 'Los\Core\Entity\EntityManagerWrapper');
        $this->container->register('serializer', 'Los\Core\Serializer\SerializerWrapper');
        $this->container->register('entityinfo', 'Los\Core\Entity\EntityInfo')
            ->addArgument($this->entityInfoSetup());
    }

    private function entityInfoSetup()
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
}
