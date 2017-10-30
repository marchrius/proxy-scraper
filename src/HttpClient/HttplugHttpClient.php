<?php /* Disabled for PHP 7.0 support */ /* declare(strict_types( )?=( )?1); */

namespace Vantoozz\ProxyScraper\HttpClient;

use Http\Client\Exception as ClientException;
use Http\Client\HttpClient as Client;
use Http\Message\MessageFactory;
use Vantoozz\ProxyScraper\Enums\Http;
use Vantoozz\ProxyScraper\Exceptions\HttpClientException;
use Vantoozz\ProxyScraper\Exceptions\RuntimeException;

/**
 * Class HttplugHttpClient
 * @package Vantoozz\ProxyScraper
 */
final class HttplugHttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * HttplugHttpClient constructor.
     * @param Client $httpClient
     * @param MessageFactory $messageFactory
     */
    public function __construct(Client $httpClient, MessageFactory $messageFactory)
    {

        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param string $uri
     * @return string
     * @throws HttpClientException
     */
    public function get(string $uri): string
    {
        $request = $this->messageFactory->createRequest(Http::GET, $uri);
        try {
            return $this->httpClient->sendRequest($request)->getBody()->getContents();
        } catch (ClientException  $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new HttpClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $uri
     * @param string $proxy
     * @return string
     * @throws \Vantoozz\ProxyScraper\Exceptions\RuntimeException
     */
    public function getProxied(string $uri, string $proxy): string
    {
        throw new RuntimeException('Method not implemented');
    }
}
