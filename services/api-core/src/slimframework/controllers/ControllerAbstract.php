<?php
namespace SlimFramework\Controllers;

use Interop\Container\ContainerInterface;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Collection;
use Slim\Http\Request;
use Slim\Http\Response;

class ControllerAbstract {

    /** @var ContainerInterface  */
    protected $container;
    /** @var Request */
    protected $request;
    /** @var Response */
    protected $response;

    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->request = $container->get('request');
        $this->response = $container->get('response');
        $this->logger = $container->get('logger');

        $path = $this->request->getUri()->getPath();

        $this->logger->info("BlueGo '$path' route");

    }

    public function getBlueGoCore(){
        return new \BlueGoCore\BlueGoCore();
    }

    private function getJsonAPIDocument(array $objects){
        // Create a new collection of posts, and specify relationships to be included.
        $collection = (new Collection($objects, new \JsonApi\Tobscure\Serialisers\UserSerialiser()))
            ->with(['author', 'comments']);

        // Create a new JSON-API document with that collection as the data.
        $document = new Document($collection);

        // Add metadata and links.
        $document->addMeta('total', count($objects));
        $uri = $this->request->getUri();
        $document->addLink('self', $uri->getScheme() . '://' . $uri->getHost() . $uri->getPort() . $uri->getPath());

        return $document;
    }

    /**
     * Build a JSON API standard response
     *
     * This method takes an array of objects and parses them into
     * a response to match the JSON API response
     *
     * @param $statusCode
     * @param array $objects
     * @return Response
     */
    protected function buildJsonAPIResponse($statusCode, array $objects) {
        $document = $this->getJsonAPIDocument($objects);
        return $this->response
            ->withJson($document)
            ->withHeader('Content-Type', 'application/vnd.api+json')
            ->withStatus($statusCode);
    }

} 