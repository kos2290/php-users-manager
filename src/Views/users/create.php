<?php $title = "Add New User"; ob_start(); ?>

<div class="card shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Register New Database Record</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger p-2 small">
                <ul class="mb-0"><?php foreach($errors as $e): ?> <li><?= htmlspecialchars($e) ?></li> <?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <form action="/users/create" method="POST">
            <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">

            <div class="mb-3">
                <label class="form-label">Username (Unique)</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Birth Date</label>
                <input type="date" name="birth_date" class="form-control" required>
            </div>
            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_admin" id="isAdminCheck">
                <label class="form-check-label text-danger" for="isAdminCheck"><strong>Grant Administrator Privileges</strong></label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/users" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Save User</button>
            </div>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); require __DIR__ . '/../layout.php'; ?>
