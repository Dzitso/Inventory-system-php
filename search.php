<?php
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$search = isset($_GET['q']) ? $_GET['q'] : '';

$sql = "SELECT assets.*, departments.name as department_name 
        FROM assets 
        JOIN departments ON assets.department_id = departments.id
        WHERE 
        assets.serial_number LIKE ? OR 
        assets.name LIKE ? OR 
        assets.model LIKE ? OR 
        assets.user LIKE ? OR 
        assets.user_id LIKE ?";

$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Results - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Serial Number</th>
                    <th>Name</th>
                    <th>Model</th>
                    <th>User</th>
                    <th>User ID</th>
                    <th>Department</th>
                    <th>Date Issued</th>
                    <th>Issued By</th>
                    <th>Status</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row["serial_number"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["model"]; ?></td>
                        <td><?php echo $row["user"]; ?></td>
                        <td><?php echo $row["user_id"]; ?></td>
                        <td><?php echo $row["department_name"]; ?></td>
                        <td><?php echo $row["date_issued"]; ?></td>
                        <td><?php echo $row["issued_by"]; ?></td>
                        <td><?php echo $row["status"]; ?></td>
                        <td><?php echo $row["value"]; ?></td>
                        <td>
                            <a href="edit_asset.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete_asset.php?id=<?php echo $row["id"]; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this asset?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>