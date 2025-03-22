<?php

include "conn.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $rfid_card = $_POST['rfid_card'];

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT COUNT(*) FROM employee WHERE rfid_card = :rfid_card");
    $stmt->bindParam(':rfid_card', $rfid_card);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        session_start();
        $_SESSION['error'] = "This RFID already exists.";
    } else {
        $rfid_card = $_POST['rfid_card'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $age = $_POST['age'];
        $department = $_POST['department'];

        $stmt = $conn->prepare("INSERT INTO employee (rfid_card, firstname, middlename, lastname, age, department) 
        VALUES (:rfid_card, :firstname, :middlename, :lastname, :age, :department)");
        $stmt->bindParam(':rfid_card', $rfid_card);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':department', $department);


        if ($stmt->execute()) {
            session_start();
            $_SESSION['success'] = "Employee added successfully.";
        } else {
            echo 'Failed';
        }
    }
}

header("Location: employee.php");
exit;
?>
