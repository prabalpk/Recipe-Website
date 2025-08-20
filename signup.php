<?php
include 'database.php';

if (isset($_POST['signup'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure password hashing

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();

    if ($checkEmail->num_rows > 0) {
        $error = "Email already exists. Please use a different one.";
    } else {
        // Email is unique, proceed with signup
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $success = "Signup successfully";
        } else {
            $error = "Signup failed: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkEmail->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 d-flex justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center mb-4">SignUp</h2>

        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="card p-4 shadow">
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" name="signup" class="btn btn-primary">Signup</button>

            <div class="mt-3">
                <p>Already have an account? <a href="login.php">Login Here</a></p>
            </div>
        </form>
    </div>
</div>

<!-- Auto redirect script -->
<?php if (isset($success)): ?>
<script>
    setTimeout(function() {
        window.location.href = "login.php";
    }, 2000);
</script>
<?php endif; ?>

</body>
</html>
