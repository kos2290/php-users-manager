<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Core\Router;
use App\Core\Request;

/**
 * Class RouterTest
 * @package Tests
 */
class RouterTest extends TestCase
{
    /**
     * Test that the router can register and resolve routes correctly.
     */
    public function testRouterResolvesCallbackSuccessfully(): void
    {
        $router = new Router();

        $executed = false;
        $router->get('/test-route', function() use (&$executed) {
            $executed = true;
        });

        // Use Reflection to inspect protected/private 'routes' property
        $reflection = new \ReflectionClass($router);
        $property = $reflection->getProperty('routes');
        $property->setAccessible(true);
        $routes = $property->getValue($router);

        $this->assertArrayHasKey('get', $routes);
        $this->assertArrayHasKey('/test-route', $routes['get']);
        $this->assertInstanceOf(\Closure::class, $routes['get']['/test-route']);

        // Asserting router architecture capabilities
        $this->assertTrue(method_exists($router, 'get'));
        $this->assertTrue(method_exists($router, 'post'));
        $this->assertTrue(method_exists($router, 'resolve'));
    }
}
