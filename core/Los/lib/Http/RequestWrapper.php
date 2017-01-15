<?php

namespace Los\Core\Http;

use Symfony\Component\HttpFoundation\Request;

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

    /**
     * Get the requested content.
     *
     * @return array
     */
    public function getRequestContent()
    {
        $content = array(
            'method' => $this->request->getMethod(),
            'content_type' => $this->request->headers->get('content-type'),
            'content' => array(),
        );

        if (strstr($content['content_type'], 'application/x-www-form-urlencoded')) {
            $content['content'] += $this->request->request->all();
        } elseif (strstr($content['content_type'], 'application/json')) {
            $content['content'] += json_decode($this->getRequest()->getContent(), true);
        } else {
            $content['content'] += $this->request->query->all();
        }

        return $content;
    }
}
