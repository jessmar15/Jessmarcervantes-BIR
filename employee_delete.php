<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];

        $stmt = $conn->prepare("DELETE FROM employee WHERE id = :delete_id");
        $stmt->bindParam(':delete_id', $delete_id);

        if ($stmt->execute()) {
            echo "success"; // Return success response for AJAX
        } else {
            echo "error"; // Return error response for AJAX
        }
    }
}
?>
