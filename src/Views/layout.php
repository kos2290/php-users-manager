<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PHP Users Manager' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php if (\App\Core\Session::get('user_id')): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/users">User Management</a>
        <div class="navbar-nav ms-auto">
            <span class="navbar-text me-3">Logged in as: <strong><?= htmlspecialchars(\App\Core\Session::get('username')) ?></strong></span>
            <a class="btn btn-outline-light btn-sm" href="/logout">Logout</a>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="container">
    <?= $content ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
