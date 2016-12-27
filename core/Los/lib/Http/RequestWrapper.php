<?php

namespace Los\Core\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

/**
 * Class RequestWrapper
 * @package Los\Core\Http
 */
class RequestWrapper
{
    private $request;

    /**
     * RequestWrapper constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}
