<?php
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

$total_assets = $conn->query("SELECT COUNT(*) as count FROM assets")->fetch_assoc()['count'];
$total_departments = $conn->query("SELECT COUNT(*) as count FROM departments")->fetch_assoc()['count'];

// Top Users
$top_users = $conn->query("SELECT user, COUNT(*) as asset_count 
                           FROM assets 
                           WHERE user IS NOT NULL AND user != '' 
                           GROUP BY user 
                           ORDER BY asset_count DESC 
                           LIMIT 5");

// Low Stock Alert
$low_stock = $conn->query("SELECT * FROM assets 
                           WHERE type = 'consumable' AND quantity <= reorder_level 
                           LIMIT 5");

// Recent Activities
$recent_activities = $conn->query("SELECT activity_description, created_at FROM activity_logs ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="container mt-5">
    <h1 class="mb-4">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Assets</h5>
                    <p class="card-text display-4"><?php echo $total_assets; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Departments</h5>
                    <p class="card-text display-4"><?php echo $total_departments; ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quick Actions</h5>
                    <div class="list-group">
                        <a href="add_asset.php" class="list-group-item list-group-item-action">Add New Asset</a>
                        <a href="add_department.php" class="list-group-item list-group-item-action">Add New Department</a>
                        <a href="department_list.php" class="list-group-item list-group-item-action">View Departments</a>
                        <a href="asset_list.php" class="list-group-item list-group-item-action">View Assets</a>
                        <a href="maintenance_schedule.php" class="list-group-item list-group-item-action">View Maintenance Schedule</a>
                        <a href="add_maintenance_task.php" class="list-group-item list-group-item-action">Add Maintenance Task</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Activity</h5>
                    <?php if ($recent_activities->num_rows > 0): ?>
                        <ul class="list-group list-group-flush">
                            <?php while ($activity = $recent_activities->fetch_assoc()): ?>
                                <li class="list-group-item">
                                    <?php echo htmlspecialchars($activity['activity_description']); ?>
                                    <br>
                                    <small class="text-muted"><?php echo $activity['created_at']; ?></small>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p>No recent activities found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Users</h5>
                    <ul class="list-group">
                        <?php while ($user = $top_users->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($user['user']); ?>
                                <span class="badge bg-primary rounded-pill"><?php echo $user['asset_count']; ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Low Stock Alert</h5>
                    <ul class="list-group">
                        <?php while ($item = $low_stock->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($item['name']); ?>
                                <span class="badge bg-warning rounded-pill"><?php echo $item['quantity']; ?> left</span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
