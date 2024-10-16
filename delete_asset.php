<?php
include 'db.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"];
$sql = "DELETE FROM assets WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Asset deleted successfully";
} else {
    $_SESSION['error_message'] = "Error: " . $stmt->error;
}

header("Location: list.php");
exit();