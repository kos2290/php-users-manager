<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Core\Env;

/**
 * Class EnvTest
 * @package Tests
 */
class EnvTest extends TestCase
{
    /**
     * Test that environment variables are correctly parsed and loaded.
     */
    public function testParsesAndLoadsEnvironmentVariables(): void
    {
        $vEnvPath = __DIR__ . '/test.env';
        file_put_contents($vEnvPath, "TEST_KEY=test_value\nANOTHER_KEY=12345");

        Env::load($vEnvPath);

        $this->assertEquals('test_value', Env::get('TEST_KEY'));
        $this->assertEquals('12345', Env::get('ANOTHER_KEY'));

        unlink($vEnvPath); // Cleanup
    }
}
