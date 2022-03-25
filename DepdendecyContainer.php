<?php 

// We create the container which has two methods and and array property to store the classname as a key and callable that will be used to construct the object
class DependencyContainerProvider
{

    private array $bindings;

    public function __construct()
    {
        $this->bindings = [];
    }

    public function set(string $className, Callable $object): void
    {
        $this->bindings[$className] = $object;
    }


    public function get(string $className): Object
    {
        // $this at the end because we this as parameter to callable that means when we call callable, we get container object as argumenmt
       return $this->bindings[$className]($this);
    }
}

// User class with SessionStorage as depdendency

class User {

    protected SessionStorage $storage; 

    public function __construct(SessionStorage $storage)
    {
        $this->storage = $storage;
    }

    public function setLanguage(string $lang) {
        $this->storage->set('lang', $lang);
    }

    public function getLanguage(): string {
        return $this->storage->get('lang');
    }
    
}

// SessionStorage with no dependencies 
class SessionStorage {
    public function __construct()
    {
        session_start();
    }

    public function get(string $key) {
        return $_SESSION[$key];
    }

    public function set(string $key, string $value) {
        $_SESSION[$key] = $value; 
    }

}

//Creat the container
$container = new DependencyContainerProvider;

// Set User class for construction. Since our callable gets container object, we can pass dependencies of SessionStorage
$container->set(User::class, function($container) {
    return new User($container->get(SessionStorage::class));
});
// Adding object without dependencies to container
$container->set(SessionStorage::class, function($container) {
    return new SessionStorage;
});



// Get the class (container constructs object with dependencies behinds the scenes)
$user = $container->get(User::class);

// Use class like normal 
$user->setLanguage('lt');
echo $user->getLanguage();






