<?php
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$assets = $conn->query("SELECT assets.*, departments.name as department_name FROM assets JOIN departments ON assets.department_id = departments.id");

// Recent Assets
$recent_assets = $conn->query("SELECT * FROM assets ORDER BY id DESC LIMIT 5");

// Asset Status
$asset_status = $conn->query("SELECT status, COUNT(*) as count FROM assets GROUP BY status");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assets - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Assets</h2>
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
            <?php while($row = $assets->fetch_assoc()): ?>
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
                    <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $row["id"]; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $row["id"]; ?>">
                                <li><a class="dropdown-item" href="edit_asset.php?id=<?php echo $row["id"]; ?>">Edit</a></li>
                                <li><a class="dropdown-item" href="delete_asset.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure you want to delete this asset?')">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<h2 class="mb-4">Assets Overview</h2>
<div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Assets</h5>
                    <ul class="list-group">
                        <?php while ($asset = $recent_assets->fetch_assoc()): ?>
                            <li class="list-group-item"><?php echo htmlspecialchars($asset['name']); ?></li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Asset Status</h5>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Asset Status Chart
var statusCtx = document.getElementById('statusChart').getContext('2d');
var statusChart = new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: [<?php while ($status = $asset_status->fetch_assoc()) echo "'" . $status['status'] . "',"; ?>],
        datasets: [{
            data: [<?php $asset_status->data_seek(0); while ($status = $asset_status->fetch_assoc()) echo $status['count'] . ","; ?>],
            backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
            borderWidth: 1
        }]
    }
});
</script>
</body>
</html>