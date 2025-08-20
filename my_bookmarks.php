<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'database.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT r.* FROM add_recipe r 
        JOIN bookmarks b ON r.id = b.recipe_id 
        WHERE b.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookmarked Recipes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>My Bookmarked Recipes</h1>
   <?php while ($row = $result->fetch_assoc()): ?>
    <div class="recipe-card">
        <img src="<?= htmlspecialchars($row['image']) ?>" alt="Recipe Image">
        <h2><?= htmlspecialchars($row['title']) ?></h2>
        <p><?= nl2br(htmlspecialchars(substr($row['instructions'], 0, 150))) ?>...</p>
        <a href="view_recipe.php?id=<?= $row['id'] ?>" class="btn btn-view">View Recipe</a>
        <a href="unbookmark.php?recipe_id=<?= $row['id'] ?>" class="btn btn-unbookmark">❌ Remove Bookmark</a>
    </div>
<?php endwhile; ?>

</body>
</html>
