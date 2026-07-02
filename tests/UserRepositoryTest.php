<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Models\UserRepository;
use App\Core\Database;
use App\Core\Env;

/**
 * Class UserRepositoryTest
 *
 * This test class is designed to validate the functionality of the UserRepository class.
 * It ensures that user creation and retrieval operations work as expected.
 * @package Tests
 */
class UserRepositoryTest extends TestCase
{
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    /**
     * @var \PDO
     */
    private \PDO $db;

    /**
     * Set up the test environment before each test.
     * This includes loading environment variables, initializing the database connection,
     * and starting a transaction to isolate test mutations from the production database state.
     */
    protected function setUp(): void
    {
        // Load env variables if not loaded
        Env::load(__DIR__ . '/../.env');

        $this->db = Database::getInstance();
        $this->repository = new UserRepository();

        // Start transaction to isolate test mutations from production database state
        $this->db->beginTransaction();
    }

    /**
     * Tear down the test environment after each test.
     * This method rolls back any database changes made during the test execution,
     * ensuring that the database remains in a consistent state for subsequent tests.
     */
    protected function tearDown(): void
    {
        // Rollback all inserts/updates/deletes made during the test execution
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
    }

    /**
     * Test the creation of a user and subsequent retrieval by username.
     * This test verifies that a user can be created with specific attributes and
     * that the same user can be retrieved accurately from the database.
     */
    public function testCanCreateAndFindUserByUsername(): void
    {
        $testUsername = 'test_runner_' . uniqid();
        $userData = [
            'username'   => $testUsername,
            'password'   => 'secret123',
            'first_name' => 'Unit',
            'last_name'  => 'Tester',
            'gender'     => 'other',
            'birth_date' => '2000-01-01',
            'is_admin'   => 1 // Testing our custom admin checkbox logic flag
        ];

        // 1. Act: Create
        $created = $this->repository->create($userData);
        $this->assertTrue($created);

        // 2. Act: Find
        $user = $this->repository->findByUsername($testUsername);

        // 3. Assert
        $this->assertNotNull($user);
        $this->assertEquals('Unit', $user['first_name']);
        $this->assertEquals('Tester', $user['last_name']);
        $this->assertEquals(1, (int)$user['is_admin']);
    }

    /**
     * Test that the repository returns null when attempting to find a non-existent user.
     */
    public function testReturnsNullIfUserDoesNotExist(): void
    {
        $user = $this->repository->findByUsername('non_existing_user_99999');
        $this->assertNull($user);
    }
}
