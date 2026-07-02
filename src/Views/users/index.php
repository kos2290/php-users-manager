<?php
$title = "User Management - Admin Panel";
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Registered Users Database</h2>
    <a href="/users/create" class="btn btn-success">+ Add New User</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th><a class="text-white text-decoration-none" href="?sort=id&direction=<?= $orderBy === 'id' ? $nextDirection : 'asc' ?>">ID <?= $orderBy === 'id' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?></a></th>
                    <th><a class="text-white text-decoration-none" href="?sort=username&direction=<?= $orderBy === 'username' ? $nextDirection : 'asc' ?>">Username <?= $orderBy === 'username' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?></a></th>
                    <th><a class="text-white text-decoration-none" href="?sort=first_name&direction=<?= $orderBy === 'first_name' ? $nextDirection : 'asc' ?>">First Name <?= $orderBy === 'first_name' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?></a></th>
                    <th><a class="text-white text-decoration-none" href="?sort=last_name&direction=<?= $orderBy === 'last_name' ? $nextDirection : 'asc' ?>">Last Name <?= $orderBy === 'last_name' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?></a></th>
                    <th><a class="text-white text-decoration-none" href="?sort=gender&direction=<?= $orderBy === 'gender' ? $nextDirection : 'asc' ?>">Gender <?= $orderBy === 'gender' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?></a></th>
                    <th><a class="text-white text-decoration-none" href="?sort=birth_date&direction=<?= $orderBy === 'birth_date' ? $nextDirection : 'asc' ?>">Birth Date <?= $orderBy === 'birth_date' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?></a></th>
                    <th><a class="text-white text-decoration-none" href="?sort=is_admin&direction=<?= $orderBy === 'is_admin' ? $nextDirection : 'asc' ?>">Role <?= $orderBy === 'is_admin' ? ($orderDir === 'asc' ? '▲' : '▼') : '' ?></a></th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= (int)$user['id'] ?></td>
                            <td><strong><?= htmlspecialchars($user['username']) ?></strong></td>
                            <td><?= htmlspecialchars($user['first_name']) ?></td>
                            <td><?= htmlspecialchars($user['last_name']) ?></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars(ucfirst($user['gender'])) ?></span></td>
                            <td><?= htmlspecialchars($user['birth_date']) ?></td>
                            <td>
                                <?php if ((int)$user['is_admin'] === 1): ?>
                                    <span class="badge bg-danger">Administrator</span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark">User</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="/users/view?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary me-1">View</a>
                                <a href="/users/edit?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                <a href="/users/delete?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>&sort=<?= $orderBy ?>&direction=<?= $orderDir ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $page === $i ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&sort=<?= $orderBy ?>&direction=<?= $orderDir ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>&sort=<?= $orderBy ?>&direction=<?= $orderDir ?>">Next</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
