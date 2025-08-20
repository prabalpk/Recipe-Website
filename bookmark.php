<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$recipe_id = $_GET['recipe_id'];

$stmt = $conn->prepare("INSERT INTO bookmarks (user_id, recipe_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $recipe_id);
$stmt->execute();

header("Location: view_recipe.php?id=$recipe_id");
?>
