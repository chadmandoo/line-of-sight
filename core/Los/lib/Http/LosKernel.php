<?php

namespace Los\Core\Http;

use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * LosKernal constructor.
     * @param ControllerResolverInterface   $resolver
     * @param ArgumentResolverInterface     $argumentResolver
     * @param EntityManagerInterface        $entityManager
     */
    public function __construct(ControllerResolverInterface $resolver, ArgumentResolverInterface $argumentResolver, EntityManagerInterface $entityManager)
    {
        $this->resolver = $resolver;
        $this->argumentResolver = $argumentResolver;
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

            return call_user_func_array(array($controllerObj, $controller[1]), $arguments);
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
    }
}
