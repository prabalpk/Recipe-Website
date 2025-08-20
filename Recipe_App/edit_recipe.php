<?php
include 'database.php';

if (!isset($_GET['id'])) {
    echo "Recipe ID is missing!";
    exit;
}

$id = intval($_GET['id']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $instructions = mysqli_real_escape_string($conn, $_POST['instructions']);

    $sql = "UPDATE add_recipe 
            SET title = '$title', ingredients = '$ingredients', instructions = '$instructions' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_recipe.php?id=$id");
        exit;
    } else {
        echo "Error updating recipe: " . $conn->error;
    }
}

// Fetch existing recipe data
$sql = "SELECT * FROM add_recipe WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "Recipe not found!";
    exit;
}

$recipe = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Recipe - <?php echo htmlspecialchars($recipe['title']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="mb-4">Edit Recipe</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ingredients</label>
                <textarea name="ingredients" class="form-control" rows="4" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Instructions</label>
                <textarea name="instructions" class="form-control" rows="5" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="view_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
