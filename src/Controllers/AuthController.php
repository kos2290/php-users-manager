<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Session;
use App\Models\UserRepository;

class AuthController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function showLogin(Request $request): void
    {
        $error = Session::get('login_error');
        Session::remove('login_error');

        $csrfToken = Session::generateCsrfToken();

        // Render pure view
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function login(Request $request): void
    {
        $data = $request->getBody();

        // Security check: CSRF
        if (!Session::validateCsrfToken($data['csrf_token'] ?? '')) {
            die('CSRF token validation failed.');
        }

        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';

        $user = $this->userRepository->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            if ((int)$user['is_admin'] === 1) {
                Session::set('user_id', $user['id']);
                Session::set('username', $user['username']);
                Session::set('is_admin', (int)$user['is_admin']);

                header('Location: /users');
                exit;
            }
        }

        Session::set('login_error', 'Invalid username, password, or insufficient privileges.');
        header('Location: /login');
        exit;
    }

    public function logout(): void
    {
        Session::destroy();
        header('Location: /login');
        exit;
    }
}
