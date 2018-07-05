<?php
namespace SlimFramework\Controllers;

use BlueGoCore\BlueGoCore;
use BlueGoCore\Databases\DatabaseConfig;
use BlueGoCore\Databases\DatabaseFactory;
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
    /** @var \Monolog\Logger */
    protected $logger;
    /** @var BlueGoCore */
    protected $blueGoCore;

    /**
     * Constructor
     *
     * Stores the container and logger internally
     *
     * Also see the __call magic method.  Magic methods
     * are a bit ugh, but I can't work out how else to
     * easily set up all the reusable components in slim without
     * repeating code in every method.  So all implemented
     * handler methods must be non-public to make
     * sure call gets invoked.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->logger = $container->get('logger');

    }

    /**
     * Magic methods
     * are a bit ugh, but I can't work out how else to
     * easily set up all the reusable components without
     * repeating code in every method.  So all implemented
     * handler methods must be non-public to make
     * sure call gets invoked.
     *
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call($name, $args) {
        $this->request = $args[0];
        $this->response = $args[1];
        $instance = $args[2]['instance'];

        $path = $this->request->getUri()->getPath();
        $this->logger->info("BlueGo-API: '$path' route");

        $dbConfig = new DatabaseConfig();
        $dbConfig->setEndpoint('mongodb://mongodb:27017');
        $dbConfig->setDatabaseName($instance);

        $this->blueGoCore = new BlueGoCore(
            new DatabaseFactory($dbConfig)
        );

        return call_user_func_array(array($this, $name), $args);
    }

    /**
     * Returns a BlueGoCore object
     *
     * Handy helper method for
     * implemented handler methods.
     * The obejct is instantiated and
     * configured in the _call magic
     * method
     *
     * @return BlueGoCore
     */
    protected function getBlueGoCore(){
        return $this->blueGoCore;
    }

    /**
     * Get a document describing the
     * response in a JSON api format.
     *
     * We simply pass an array of all objects
     * which need to be returned.  This method
     * will not be called outside of this Abstract
     * class
     *
     * @param array $objects
     * @return Document
     */
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