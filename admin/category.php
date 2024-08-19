<?php
include_once '../check-url.php';
require_once '../config/database.php';
require_once '../helper/helper.php';

$errors = [];
$successMessage = "";

function isCategoryUsed($categoryId, $connection) {
    $sql = "SELECT COUNT(*) FROM blogs WHERE category_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$categoryId]);
    $count = $stmt->fetchColumn();
    return $count > 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add_category') {
    $categoryName = post('category_name');
    
    if (empty($categoryName)) {
        $errors['category_name'] = 'Category name is required.';
    } else {
        $sql = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $connection->prepare($sql);
        $check = $stmt->execute([$categoryName]);
        
        if ($check) {
            $successMessage = "Category added successfully.";
        } 
    }
}

if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    
    if ($deleteId > 0 && !isCategoryUsed($deleteId, $connection)) {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $check = $stmt->execute([$deleteId]);
        if ($check) {
            $successMessage = "Category deleted successfully.";
        }
    } else if (isCategoryUsed($deleteId, $connection)) {
        $successMessage = "Category cannot be deleted as it is associated with blogs.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'edit_category') {
    $categoryId = intval(post('category_id'));
    $categoryName = post('category_name');
    
    if (empty($categoryName)) {
        $errors['category_name'] = 'Category name is required.';
    } else {
        $sql = "UPDATE categories SET name = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $check = $stmt->execute([$categoryName, $categoryId]);
        if ($check) {
            $successMessage = "Category updated successfully.";
        }
    }
}

$sql = "SELECT * FROM categories";
$stmt = $connection->query($sql);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #333;
            color: white;
            padding: 20px;
            position: fixed;
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .main-content {
            margin-left: 300px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f4f4f4;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }

        .header h1 {
            margin: 0;
        }

        .header .search-bar input {
            padding: 5px;
            font-size: 16px;
        }

        .content {
            margin-top: 20px;
        }

        .content h2 {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn-primary {
            background-color: #1e90ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #1c86ee;
        }

        .error-message {
            color: red;
            margin-top: 5px;
        }

        .success-message {
            color: green;
            margin-top: 5px;
        }

        .category-list {
            margin-top: 20px;
        }

        .category-list ul {
            list-style-type: none;
            padding: 0;
        }

        .category-list li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .btn-edit, .btn-delete {
            background-color: #1e90ff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-edit:hover, .btn-delete:hover {
            background-color: #1c86ee;
        }

        .btn-delete {
            background-color: #ff6347;
        }

        .btn-delete:hover {
            background-color: #e5534b;
        }

        .categorys {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .edit-form {
            display: none;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="adminprofil.php">Profile</a>
        <a href="category.php">Manage Category</a>
        <a href="acceptblog.php">Manage Blogs</a>
        <a href="edituser.php">Manage Users</a>
        <a href="adminstatistic.php">Statistic</a>
        <a href="adminlogout.php">Log out</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
            </div>
        </div>
        <div class="content">
            <h2>Categories</h2>

            <?php if ($successMessage): ?>
                <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>
            <?php if (isset($errors['category_name'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($errors['category_name']); ?></div>
            <?php endif; ?>

            <!-- Form add -->
            <form action="" method="post">
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" id="category_name" name="category_name" required>
                </div>
                <input type="hidden" name="action" value="add_category">
                <button class="btn-primary" type="submit">Add Category</button>
            </form>

            <!-- Form edit -->
            <form id="editCategoryForm" action="" method="post" class="edit-form">
                <div class="form-group">
                    <label for="edit_category_name">Category Name</label>
                    <input type="text" id="edit_category_name" name="category_name" required>
                    <input type="hidden" id="edit_category_id" name="category_id">
                </div>
                <input type="hidden" name="action" value="edit_category">
                <button class="btn-primary" type="submit">Update Category</button>
            </form>

            <div class="category-list">
                <h3>Existing Categories:</h3>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <li class="categorys">
                            <?php echo htmlspecialchars($category['name']); ?>
                            <div>
                                <button class="btn-edit" onclick="editCategory(<?php echo $category['id']; ?>, '<?php echo htmlspecialchars($category['name']); ?>')">Edit</button>
                                <?php if (!isCategoryUsed($category['id'], $connection)): ?>
                                    <a href="?delete_id=<?php echo $category['id']; ?>" class="btn-delete">Delete</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function editCategory(id, name) {
            document.getElementById('edit_category_id').value = id;
            document.getElementById('edit_category_name').value = name;
            document.getElementById('editCategoryForm').style.display = 'block';
        }
    </script>
</body>

</html>
