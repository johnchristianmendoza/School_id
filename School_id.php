<?php
session_start();

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

if (isset($_POST['add'])) {
    $student = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'course' => $_POST['course']
    ];
    $_SESSION['students'][] = $student;
}


if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    unset($_SESSION['students'][$index]);
    $_SESSION['students'] = array_values($_SESSION['students']);
}


if (isset($_POST['update'])) {
    $index = $_POST['index'];
    $_SESSION['students'][$index]['id'] = $_POST['id'];
    $_SESSION['students'][$index]['name'] = $_POST['name'];
    $_SESSION['students'][$index]['course'] = $_POST['course'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
</head>
<body>

<h2>Student Records Management</h2>

<!-- Add / Edit Form -->
<form method="post">
    <input type="hidden" name="index" value="<?= $_GET['edit'] ?? '' ?>">
    <input type="text" name="id" placeholder="Student ID" required
           value="<?= $_SESSION['students'][$_GET['edit']]['id'] ?? '' ?>">
    <input type="text" name="name" placeholder="Student Name" required
           value="<?= $_SESSION['students'][$_GET['edit']]['name'] ?? '' ?>">
    <input type="text" name="course" placeholder="Course" required
           value="<?= $_SESSION['students'][$_GET['edit']]['course'] ?? '' ?>">

    <?php if (isset($_GET['edit'])): ?>
        <button type="submit" name="update">Update Student</button>
    <?php else: ?>
        <button type="submit" name="add">Add Student</button>
    <?php endif; ?>
</form>

<hr>

<!-- Display Students -->
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Course</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($_SESSION['students'] as $index => $student): ?>
        <tr>
            <td><?= $student['id'] ?></td>
            <td><?= $student['name'] ?></td>
            <td><?= $student['course'] ?></td>
            <td>
                <a href="?edit=<?= $index ?>">Edit</a> |
                <a href="?delete=<?= $index ?>" onclick="return confirm('Delete this student?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>