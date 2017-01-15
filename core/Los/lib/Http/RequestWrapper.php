<?php

namespace Los\Core\Http;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestWrapper
 * @package Los\Core\Http
 */
class RequestWrapper
{
    /**
     * Request object
     *
     * @var Request
     */
    private $request;

    /**
     * Requested Content
     *
     * @var
     */
    private $requestContent;

    /**
     * RequestWrapper constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setRequestContent();
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
     * Get requested content.
     *
     * @return array
     */
    public function getRequestContent()
    {
        return $this->requestContent;
    }

    /**
     * Set the requested content.
     */
    public function setRequestContent()
    {
        $this->requestContent = array(
            'method' => $this->request->getMethod(),
            'headers' => $this->request->headers->all(),
            'content_type' => $this->request->headers->get('content-type'),
            'content' => array(),
        );

        if (strstr($this->requestContent['content_type'], 'application/x-www-form-urlencoded')) {
            $this->requestContent['content'] += $this->request->request->all();
        } elseif (strstr($this->requestContent['content_type'], 'application/json')) {
            $this->requestContent['content'] += json_decode($this->getRequest()->getContent(), true);
        } else {
            $this->requestContent['content'] += $this->request->query->all();
        }
    }
}
