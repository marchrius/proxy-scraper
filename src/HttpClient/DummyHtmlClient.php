<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\HttpClient;

/**
 * Class DummyHtmlClient
 * @package Vantoozz\ProxyScraper\HttpClient
 */
final class DummyHtmlClient implements HttpClientInterface
{
    /**
     * @var string
     */
    private $response;

    /**
     * @var string
     */
    private $proxiedResponse;

    /**
     * DummyHtmlClient constructor.
     * @param string $response
     * @param string $proxiedResponse
     */
    public function __construct(string $response, string $proxiedResponse)
    {
        $this->response = $response;
        $this->proxiedResponse = $proxiedResponse;
    }

    /**
     * @param string $uri
     * @return string
     * @throws \Vantoozz\ProxyScraper\Exceptions\HttpClientException
     */
    public function get(string $uri): string
    {
        return $this->response;
    }

    /**
     * @param string $uri
     * @param string $proxy
     * @return string
     * @throws \Vantoozz\ProxyScraper\Exceptions\HttpClientException
     */
    public function getProxied(string $uri, string $proxy): string
    {
        return $this->proxiedResponse;
    }
}
