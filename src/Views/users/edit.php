<?php $title = "Edit User Settings"; ob_start(); ?>

<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Modify Account Details</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger p-2 small">
                <ul class="mb-0"><?php foreach($errors as $e): ?> <li><?= htmlspecialchars($e) ?></li> <?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <form action="/users/edit" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password <span class="text-muted small">(Leave blank to keep unchanged)</span></label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="male" <?= $user['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= $user['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="other" <?= $user['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Birth Date</label>
                <input type="date" name="birth_date" class="form-control" value="<?= htmlspecialchars($user['birth_date']) ?>" required>
            </div>
            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_admin" id="isAdminCheck" <?= (int)$user['is_admin'] === 1 ? 'checked' : '' ?>>
                <label class="form-check-label text-danger" for="isAdminCheck"><strong>Grant Administrator Privileges</strong></label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/users" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Database</button>
            </div>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>
