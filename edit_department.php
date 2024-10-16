<?php
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    
    $sql = "UPDATE departments SET name=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $id);
    
    if ($stmt->execute()) {
        $success = "Department updated successfully";
    } else {
        $error = "Error: " . $stmt->error;
    }
}

$id = $_GET["id"];
$result = $conn->query("SELECT * FROM departments WHERE id=$id");
$department = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Department - Inventory Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Edit Department</h2>
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
                    <form method="post" action="edit_department.php">
                        <input type="hidden" name="id" value="<?php echo $department['id']; ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Department Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $department['name']; ?>" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Department</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>