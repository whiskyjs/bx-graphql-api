<?php
// phpcs:disable PSR1.Files.SideEffects

namespace WJS\API;

use Composer\Autoload\ClassLoader;

class Loader
{
    /**
     * @var ClassLoader
     */
    private $loader;

    public function __construct(ClassLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * @param string $class
     * @return mixed
     */
    public function loadClass(string $class)
    {
        $result = $this->loader->loadClass($class);

        if ($result && method_exists($class, '__static')) {
            call_user_func([$class, '__static']);
        }

        return $result;
    }
}
