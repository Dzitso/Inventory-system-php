<?php
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$departments = $conn->query("SELECT * FROM departments");
$assets = $conn->query("SELECT assets.*, departments.name as department_name FROM assets JOIN departments ON assets.department_id = departments.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>List - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Departments</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $departments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td>
                        <a href="edit_department.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete_department.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this department?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2 class="mt-5 mb-4">Assets</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Department</th>
                <th>Name</th>
                <th>Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $assets->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["department_name"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["value"]; ?></td>
                    <td>
                        <a href="edit_asset.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete_asset.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this asset?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>