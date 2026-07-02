<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Models\UserRepository;

/**
 * Class UserController
 * @package App\Controllers
 */
class UserController
{
    /** @var UserRepository */
    private UserRepository $userRepository;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Display a paginated list of users
     *
     * @param  Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        $params = $request->getBody();
        $limit = 5;
        $page = isset($params['page']) ? (int)$params['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        $orderBy = $params['sort'] ?? 'id';
        $orderDir = $params['direction'] ?? 'asc';
        $nextDirection = $orderDir === 'asc' ? 'desc' : 'asc';

        $users = $this->userRepository->getAll($limit, $offset, $orderBy, $orderDir);
        $totalUsers = $this->userRepository->getTotalCount();
        $totalPages = (int)ceil($totalUsers / $limit);

        require_once __DIR__ . '/../Views/users/index.php';
    }

    /**
     * Display a single user
     *
     * @param  Request $request
     * @return void
     */
    public function view(Request $request): void
    {
        $id = (int)($request->getBody()['id'] ?? 0);
        $user = $this->userRepository->findById($id);

        if (!$user) {
            die('User not found.');
        }

        require_once __DIR__ . '/../Views/users/view.php';
    }

    /**
     * Show the user creation form
     *
     * @param  Request $request
     * @return void
     */
    public function create(Request $request): void
    {
        $errors = Session::get('validation_errors') ?? [];
        Session::remove('validation_errors');
        $csrfToken = Session::generateCsrfToken();

        require_once __DIR__ . '/../Views/users/create.php';
    }

    /**
     * Handle user creation form submission
     *
     * @param  Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $data = $request->getBody();

        if (!Session::validateCsrfToken($data['csrf_token'] ?? '')) {
            die('CSRF token validation failed.');
        }

        // Server-side validation
        $errors = [];
        if (empty($data['username'])) $errors[] = "Username is required.";
        if (empty($data['password'])) $errors[] = "Password is required.";
        if (empty($data['first_name'])) $errors[] = "First name is required.";
        if (empty($data['last_name'])) $errors[] = "Last name is required.";
        if (empty($data['birth_date'])) $errors[] = "Birth date is required.";

        // Check uniqueness
        if (!empty($data['username']) && $this->userRepository->findByUsername($data['username'])) {
            $errors[] = "This username is already taken.";
        }

        if (!empty($errors)) {
            Session::set('validation_errors', $errors);
            header('Location: /users/create');
            exit;
        }

        // Map checkbox state to integer
        $data['is_admin'] = isset($data['is_admin']) ? 1 : 0;

        $this->userRepository->create($data);
        header('Location: /users');
        exit;
    }

    /**
     * Show the user edit form
     *
     * @param  Request $request
     * @return void
     */
    public function edit(Request $request): void
    {
        $id = (int)($request->getBody()['id'] ?? 0);
        $user = $this->userRepository->findById($id);

        if (!$user) {
            die('User not found.');
        }

        $errors = Session::get('validation_errors') ?? [];
        Session::remove('validation_errors');
        $csrfToken = Session::generateCsrfToken();

        require_once __DIR__ . '/../Views/users/edit.php';
    }

    /**
     * Handle user edit form submission
     *
     * @param  Request $request
     * @return void
     */
    public function update(Request $request): void
    {
        $data = $request->getBody();
        $id = (int)($data['id'] ?? 0);

        if (!Session::validateCsrfToken($data['csrf_token'] ?? '')) {
            die('CSRF token validation failed.');
        }

        $errors = [];
        if (empty($data['username'])) $errors[] = "Username cannot be empty.";

        // Check uniqueness if username changed
        $existingUser = $this->userRepository->findByUsername($data['username']);
        if ($existingUser && (int)$existingUser['id'] !== $id) {
            $errors[] = "This username is already taken by another account.";
        }

        if (!empty($errors)) {
            Session::set('validation_errors', $errors);
            header("Location: /users/edit?id={$id}");
            exit;
        }

        $data['is_admin'] = isset($data['is_admin']) ? 1 : 0;

        $this->userRepository->update($id, $data);
        header('Location: /users');
        exit;
    }

    /**
     * Handle user deletion
     *
     * @param  Request $request
     * @return void
     */
    public function delete(Request $request): void
    {
        $id = (int)($request->getBody()['id'] ?? 0);

        // Prevent deleting yourself
        if ($id === (int)Session::get('user_id')) {
            die('Security Violation: You cannot delete your own administrative account.');
        }

        $this->userRepository->delete($id);
        header('Location: /users');
        exit;
    }
}
