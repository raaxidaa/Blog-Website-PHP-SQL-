<?php
include_once '../index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = post('title');
    $description = post('description');
    $user_id = $_SESSION['user_id'];
    $category_id = intval(post('category'));
    $image = null;

    if (!empty($_FILES['image']['name'])) {
        $image = file_upload('../uploads', $_FILES['image']);
        if (!$image) {
            $errors['image'] = 'Image upload failed. Please try again.';
        }
    }

    if (empty($errors)) {
        $sql = "INSERT INTO blogs (title, description, user_id, blog_img, category_id) 
                VALUES (?, ?, ?, ?, ?)";
        $loginQuery = $connection->prepare($sql);
        $check = $loginQuery->execute([
            $title,
            $description,
            $user_id,
            $image,
            $category_id 
        ]);

        if ($check) {
          view(route('blogs/blogs.php'));
        }
    }
}

$categorySql = "SELECT id, name FROM categories";
$categoryStmt = $connection->query($categorySql);
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            width: 100%;
            height: 100vh;
            background-color: #ededed;
            display: flex;
            align-items: center;
            justify-content:center;
        }
        form {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-direction: column;
            width: 500px;
            border: 1px solid #ededed;
            border-radius: 4px;
            padding: 20px;
        }
        form div {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input, textarea, select {
            border: 1px solid #ededed;
            border-radius: 4px;
            padding: 10px;
        }
        button {
            background-color: blue;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px;
        }
    </style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea>

        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="">Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
