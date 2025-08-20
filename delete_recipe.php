<?php
include 'database.php';

if (!isset($_GET['id'])) {
    echo "Recipe ID is missing!";
    exit;
}

$id = intval($_GET['id']);

// Prepare and execute the DELETE query
$sql = "DELETE FROM add_recipe WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Redirect to home page after successful deletion
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting recipe: " . $conn->error;
}
?>
