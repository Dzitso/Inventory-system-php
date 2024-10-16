<?php
include 'db.php';

$maintenance_schedule = $conn->query("
    SELECT mt.id, mt.task_description, mt.due_date, a.name as asset_name 
    FROM maintenance_tasks mt
    JOIN assets a ON mt.asset_id = a.id
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance Schedule - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Maintenance Schedule</h2>
    <a href="add_maintenance_task.php" class="btn btn-primary mb-4">Add Maintenance Task</a>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Maintenance Schedule</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Asset</th>
                        <th>Task</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($task = $maintenance_schedule->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($task['asset_name']); ?></td>
                            <td><?php echo htmlspecialchars($task['task_description']); ?></td>
                            <td><?php echo $task['due_date']; ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="edit_maintenance_task.php?id=<?php echo $task['id']; ?>">Edit</a></li>
                                        <li><a class="dropdown-item" href="delete_maintenance_task.php?id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
