<?php
require_once '../config/config.php';

$error = '';

if (isPost()) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {

        $error = "Please enter your email and password.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $sql = "SELECT * FROM admins
                WHERE email = ?
                AND status = 'Active'
                LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];

            $update = $pdo->prepare("
                UPDATE admins
                SET last_login = NOW()
                WHERE id = ?
            ");

            $update->execute([$admin['id']]);

            redirect('dashboard.php');

        } else {

            $error = "Invalid email or password.";

        }

    }

}

if(isset($_SESSION['admin_id'])){
    redirect('dashboard.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Login | <?= SITE_NAME; ?></title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

<link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

<div class="login-wrapper">

<div class="card login-card p-4">

<div class="text-center mb-4">

<img src="../assets/images/logo.png"
class="login-logo mb-3"
alt="Logo">

<h3 class="fw-bold">

Admin Login

</h3>

<p class="text-muted">

Sign in to continue

</p>

</div>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Email Address

</label>

<?php if (!empty($error)): ?>

<div class="alert alert-danger">

    <?= e($error); ?>

</div>

<?php endif; ?>

<input
type="email"
name="email"
class="form-control"
value="<?= isset($email) ? e($email) : ''; ?>"
required>

</div>

<div class="mb-4">

<label class="form-label">

Password

</label>

<div class="input-group">

<input
type="password"
name="password"
id="password"
class="form-control"
required>

<button
class="btn btn-outline-secondary"
type="button"
id="togglePassword">

<i class="bi bi-eye"></i>

</button>

</div>

</div>

<div class="d-grid">

<button
class="btn btn-primary">

Login

</button>

</div>

</form>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/login.js"></script>

</body>

</html>