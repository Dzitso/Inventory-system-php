<?php
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];

// Check if there are any assets associated with this department
$check_sql = "SELECT COUNT(*) as count FROM assets WHERE department_id=?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $id);
$check_stmt->execute();
$result = $check_stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    $_SESSION['error_message'] = "Cannot delete department. There are assets associated with it.";
} else {
    $sql = "DELETE FROM departments WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Department deleted successfully";
    } else {
        $_SESSION['error_message'] = "Error: " . $stmt->error;
    }
}

header("Location: list.php");
exit();