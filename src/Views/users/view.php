<?php $title = "View User Details"; ob_start(); ?>

<div class="card shadow-sm max-width-md mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">User Profile Card</h5>
        <a href="/users" class="btn btn-sm btn-outline-light">Back to List</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 30%;">ID</th>
                <td><?= (int)$user['id'] ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><strong><?= htmlspecialchars($user['username']) ?></strong></td>
            </tr>
            <tr>
                <th>First Name</th>
                <td><?= htmlspecialchars($user['first_name']) ?></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><?= htmlspecialchars($user['last_name']) ?></td>
            </tr>
            <tr>
                <th>Gender</th>
                <td><span class="badge bg-secondary"><?= htmlspecialchars(ucfirst($user['gender'])) ?></span></td>
            </tr>
            <tr>
                <th>Birth Date</th>
                <td><?= htmlspecialchars($user['birth_date']) ?></td>
            </tr>
            <tr>
                <th>System Role</th>
                <td>
                    <?= (int)$user['is_admin'] === 1 ? '<span class="badge bg-danger">Administrator</span>' : '<span class="badge bg-info text-dark">Regular User</span>' ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php $content = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>
