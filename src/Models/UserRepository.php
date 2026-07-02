<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    // Pagination + Dynamic Sorting
    public function getAll(int $limit, int $offset, string $orderBy, string $orderDir): array
    {
        // Whitelist variables to prevent SQL injection in ORDER BY clause
        $allowedColumns = ['id', 'username', 'first_name', 'last_name', 'gender', 'birth_date', 'is_admin'];
        $orderBy = in_array($orderBy, $allowedColumns, true) ? $orderBy : 'id';
        $orderDir = strtoupper($orderDir) === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT * FROM users ORDER BY {$orderBy} {$orderDir} LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getTotalCount(): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO users (username, password, first_name, last_name, gender, birth_date, is_admin)
                VALUES (:username, :password, :first_name, :last_name, :gender, :birth_date, :is_admin)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'username'   => $data['username'],
            'password'   => password_hash($data['password'], PASSWORD_BCRYPT),
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'gender'     => $data['gender'],
            'birth_date' => $data['birth_date'],
            'is_admin'   => $data['is_admin']
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $fields = "username = :username, first_name = :first_name, last_name = :last_name,
                   gender = :gender, birth_date = :birth_date, is_admin = :is_admin";

        $params = [
            'id'         => $id,
            'username'   => $data['username'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'gender'     => $data['gender'],
            'birth_date' => $data['birth_date'],
            'is_admin'   => $data['is_admin']
        ];

        // Only update password if a new one was provided
        if (!empty($data['password'])) {
            $fields .= ", password = :password";
            $params['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $sql = "UPDATE users SET {$fields} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
