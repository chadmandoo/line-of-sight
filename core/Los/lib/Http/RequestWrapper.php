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
    private $matcher;

    /**
     * RequestWrapper constructor.
     * @param Request             $request
     * @param UrlMatcherInterface $matcher
     */
    public function __construct(Request $request, UrlMatcherInterface $matcher)
    {
        $this->request = $request;
        $this->matcher = $matcher;
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

    /**
     * @return UrlMatcherInterface
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * @param UrlMatcherInterface $matcher
     */
    public function setMatcher($matcher)
    {
        $this->matcher = $matcher;
    }

    /**
     * Match request
     */
    public function matchRequest()
    {
        $match = $this->matcher->matchRequest($this->request);
        $this->request->attributes->add($match);
    }
}
