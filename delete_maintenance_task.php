<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: maintenance_schedule.php");
    exit();
}

$task_id = $_GET['id'];

$sql = "DELETE FROM maintenance_tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $task_id);

if ($stmt->execute()) {
    header("Location: maintenance_schedule.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
