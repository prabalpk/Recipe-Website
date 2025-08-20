
<?php
    include 'database.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php

if (isset($_POST['submit'])) {
    $title        = $_POST['title'];
    $ingredients  = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    $image = "images/" . basename($_FILES['image']['name']);
    $tmp   = $_FILES['image']['tmp_name'];
    $target = $image; 

    if (move_uploaded_file($tmp, $target)) {
        $stmt = $conn->prepare("INSERT INTO add_recipe (title, image, ingredients, instructions) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $image, $ingredients, $instructions);

        if ($stmt->execute()) {
            $success = "Recipe added successfully!";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Recipe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5 d-flex justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Add Recipe</h2>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data" class="card p-4 shadow">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ingredients</label>
                    <textarea name="ingredients" rows="4" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Instructions</label>
                    <textarea name="instructions" rows="4" class="form-control" required></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Submit</button><br>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Back</button>

            </form>
        </div>
    </div>

</body>

</html>