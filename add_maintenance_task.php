<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $asset_id = $_POST["asset_id"];
    $task_description = $_POST["task_description"];
    $due_date = $_POST["due_date"];

    $sql = "INSERT INTO maintenance_tasks (asset_id, task_description, due_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $asset_id, $task_description, $due_date);

    if ($stmt->execute()) {
        $success = "Maintenance task added successfully.";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

$assets = $conn->query("SELECT id, name FROM assets");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Maintenance Task - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Add Maintenance Task</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form method="post" action="add_maintenance_task.php">
        <div class="mb-3">
            <label for="asset_id" class="form-label">Asset</label>
            <select id="asset_id" name="asset_id" class="form-control" required>
                <?php while ($asset = $assets->fetch_assoc()): ?>
                    <option value="<?php echo $asset['id']; ?>"><?php echo htmlspecialchars($asset['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="task_description" class="form-label">Task Description</label>
            <input type="text" id="task_description" name="task_description" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" id="due_date" name="due_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
