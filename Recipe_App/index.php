<!-- <?php include 'database.php'; ?> -->

<?php
include 'database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background-color: skyblue;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-img-top {
            max-height: 350px;
            width: 100%;
            object-fit: cover;
            display: block;
        }


        .search-form {
            width: 50%;
        }

        .navbar {
    background-color: #2c3e50;
    overflow: hidden;
    padding: 10px;
    text-align: center;
}

.navbar a {
    color: white;
    text-decoration: none;
    padding: 12px 20px;
    display: inline-block;
    font-weight: bold;
    transition: background-color 0.3s;

}

.navbar a:hover {
    background-color: #34495e;
    border-radius: 5px;
}


    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #8B4513;">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-white" href="index.php"><i class="fa fa-utensils me-2"></i>Recipe App</a>

            <!-- Search Form -->
            <form class="d-flex search-form mx-auto" role="search" action="index.php" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search recipes..." aria-label="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button class="btn btn-light" type="submit">Search</button>
            </form>

            <!-- Buttons -->
            <!-- <div>
            <a href="add_recipe.php" class="btn btn-outline-light me-2">Add Recipe</a>
            <a href="signup.php" class="btn btn-success me-2">Sign Up</a>
            <a href="login.php" class="btn btn-outline-light">Login</a>
            <a href="login.php" class="btn btn-outline-light">Logout</a>
        </div> -->

            <div>
                <a href="add_recipe.php" class="btn btn-outline-light me-2">Add Recipe</a>

              <a href="my_bookmarks.php" class="nav-link">🔖 My Bookmarks</a>



                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="btn btn-danger">Logout</a>

                <?php else: ?>
                    <a href="signup.php" class="btn btn-success me-2">Sign Up</a>
                    <a href="login.php" class="btn btn-outline-light">Login</a>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <h2 class="text-center mb-5">Our Delicious Recipes</h2>
        <div class="row">
            <?php
            // Search logic
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
            if ($search != '') {
                $sql = "SELECT * FROM add_recipe WHERE title LIKE '%$search%' ";
            } else {
                $sql = "SELECT * FROM add_recipe";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="<?php echo htmlspecialchars($row['image']) ?>" class="card-img-top" alt="Recipe app">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']) ?></h5>
                                <a href="view_recipe.php?id=<?php echo $row['id']; ?>" class="btn btn-primary w-100">View Recipe</a>


                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <p class="text-center">No recipes found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 bg-light">
        <p class="mb-1">© 2023 Recipe App. All rights reserved.</p>
        <p class="mb-0">Created by <strong>Nidhi, Prabal and Group</strong></p>
    </footer>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>