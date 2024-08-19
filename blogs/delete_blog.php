<?php
include_once '../index.php';
if (isset($_GET['id']) ) {
    $id = ($_GET['id']);
    $sql = "SELECT * FROM blogs WHERE id = ?";
    $selectQuery = $connection->prepare($sql);
    $selectQuery->execute([$id]);
    $blog = $selectQuery->fetch(PDO::FETCH_ASSOC);

    if ($blog) {
        $sql = "DELETE FROM blogs WHERE id = ?";
        $deleteQuery = $connection->prepare($sql);
        $check = $deleteQuery->execute([$id]);

        if ($check) {
           view(route('blogs/usersblog.php'));
        }
    } 
} else {
    echo "ID tapilmadi";
}
?>
