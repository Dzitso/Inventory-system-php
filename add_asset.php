<?php
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serial_number = $_POST["serial_number"];
    $name = $_POST["name"];
    $model = $_POST["model"];
    $user = $_POST["user"];
    $user_id = $_POST["user_id"];
    $department_id = $_POST["department_id"];
    $date_issued = $_POST["date_issued"];
    $issued_by = $_POST["issued_by"];
    $status = $_POST["status"];
    $value = $_POST["value"];
    $type = $_POST["type"];
    $quantity = ($type == 'consumable') ? $_POST["quantity"] : null;
    $reorder_level = ($type == 'consumable') ? $_POST["reorder_level"] : null;
    
    $sql = "INSERT INTO assets (serial_number, name, model, user, user_id, department_id, date_issued, issued_by, status, value, type, quantity, reorder_level) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssisssdsis", $serial_number, $name, $model, $user, $user_id, $department_id, $date_issued, $issued_by, $status, $value, $type, $quantity, $reorder_level);
    
    if ($stmt->execute()) {
        $success = "New asset added successfully";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

$departments = $conn->query("SELECT * FROM departments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Asset - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Add Asset</h2>
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
                    <form method="post" action="add_asset.php">
                        <div class="mb-3">
                            <label for="serial_number" class="form-label">Serial Number</label>
                            <input type="text" id="serial_number" name="serial_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Asset Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" id="model" name="model" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="user" class="form-label">User</label>
                            <input type="text" id="user" name="user" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User ID</label>
                            <input type="text" id="user_id" name="user_id" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select id="department_id" name="department_id" class="form-select" required>
                                <?php while($row = $departments->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date_issued" class="form-label">Date Issued</label>
                            <input type="date" id="date_issued" name="date_issued" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="issued_by" class="form-label">Issued By</label>
                            <input type="text" id="issued_by" name="issued_by" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="value" class="form-label">Asset Value</label>
                            <input type="number" id="value" name="value" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Asset Type</label>
                            <select id="type" name="type" class="form-select" required onchange="toggleConsumableFields()">
                                <option value="regular">Regular</option>
                                <option value="consumable">Consumable</option>
                            </select>
                        </div>
                        <div id="consumableFields" style="display: none;">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="reorder_level" class="form-label">Reorder Level</label>
                                <input type="number" id="reorder_level" name="reorder_level" class="form-control">
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Add Asset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleConsumableFields() {
    var type = document.getElementById('type').value;
    var consumableFields = document.getElementById('consumableFields');
    if (type === 'consumable') {
        consumableFields.style.display = 'block';
    } else {
        consumableFields.style.display = 'none';
    }
}
</script>
</body>
</html>