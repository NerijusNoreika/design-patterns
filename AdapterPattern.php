<?php

class Client
{
    private JsonRequest $jsonRequest;

    public function __construct(JsonRequest $jsonRequest)
    {
        $this->jsonRequest = $jsonRequest;
    }

    public function doWork()
    {
        $class = new stdClass;
        $class->name = 'ExampleName';
        $class->surname = 'ExampleSurname';

        return $this->jsonRequest->connect($class);
    }
}

interface JsonRequest
{
    public function connect(object $object);
}

class JsonAdapter implements JsonRequest
{
    private ForeignLibrary $adaptee;

    public function __construct(ForeignLibrary $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function connect(Object $object)
    {
        return $this->adaptee->getRequest($object);
    }
}

class ForeignLibrary
{
    public function getRequest(object $object)
    {
        return json_encode($object);
    }
}

// Create a service object (foreign incompatible library)
// Create adapter that wraps the service and all the functionality
// Create the interface that targets the client (our class)
// Do work from client through the interface. 

$service = new ForeignLibrary();
$adapter = new JsonAdapter($service);
$client = new Client($adapter);
print_r($client->doWork());
