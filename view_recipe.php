<?php  
session_start();
include 'database.php';  

if (!isset($_GET['id'])) {
    echo "Recipe ID is missing!";
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM add_recipe WHERE id = $id"; 
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    echo "Recipe not found!";
    exit;
}

$recipe = $result->fetch_assoc();

// Prepare bookmark button
$user_id = $_SESSION['user_id'] ?? null; // null if not logged in
$bookmark_button = '';
if ($user_id) {
    $stmt = $conn->prepare("SELECT * FROM bookmarks WHERE user_id = ? AND recipe_id = ?");
    $stmt->bind_param("ii", $user_id, $id);
    $stmt->execute();
    $bookmark_result = $stmt->get_result();

    if ($bookmark_result->num_rows > 0) {
        // Already bookmarked
        $bookmark_button = "<a href='unbookmark.php?recipe_id=$id' class='btn btn-danger'>❌ Remove Bookmark</a>";
    } else {
        // Not bookmarked yet
        $bookmark_button = "<a href='bookmark.php?recipe_id=$id' class='btn btn-success'>🔖 Bookmark</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($recipe['title']); ?> - Recipe App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            background-color: #4b2e2e;
            color: white;
            padding: 15px;
            font-size: 24px;
        }
        .recipe-img {
            width: 50%;
            height: 40%;
            border-radius: 10px;
        }
        .section-title {
            font-weight: bold;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="header d-flex justify-content-between align-items-center rounded">
        <span>Recipe App</span>
        <div>
            <a href="edit_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-primary">Edit</a>
            <a href="delete_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this recipe?');">Delete</a>
        </div>
    </div>

    <div class="container mt-2 d-flex justify-content-center">
        <div class="col-md-6">

            <div class="text-center my-4">
                <img src="<?php echo htmlspecialchars($recipe['image']); ?>" class="recipe-img" alt="Recipe Image">
            </div>

            <h2 class="text-center"><?php echo htmlspecialchars($recipe['title']); ?></h2>

            <h4 class="section-title">Ingredients:</h4>
            <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>

            <h4 class="section-title">Instructions:</h4>
            <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>

            <div class="text-center my-4">
                <a href="index.php" class="btn btn-secondary me-2">Back to Home</a>
                <?php echo $bookmark_button; ?>
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
