<?php

    include_once '../db/db_conn.php';

    if($conn->connect_error) {
        die("Connection Failed: {$conn->connect_error}");
    }

    $firstName_reg = $_POST['firstName'];
    $lastName_reg = $_POST['lastName'];
    $email_reg = $_POST['email_reg'];
    $password_reg = $_POST['password_reg'];

    //check if the fields is empty or not
    if(empty($firstName) || empty($lastName) || empty($email_reg) || empty($password_reg)) {
        echo json_encode (['message' => 'error', 'error' => 'All fields are required']);
        exit;
    }

    //check if email is valid or not
    if(!filter_var($email_reg, FILTER_VALIDATE_EMAIL)) {
        echo json_encode (['message' => 'error', 'error' => 'Ivalid email address']);
        exit;
    }

    //for security
    $hashed_password = password_hash($password_reg, PASSWORD_BCRYPT);
    
    $current_date = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO tbl_users (firstName, lastName, email_reg, password_reg) VALUES (?, ?, ?, ?)");

    $stmt->bind_param("ssss", $firstName_reg, $lastName_reg, $email_reg, $hashed_password);

    if($stmt->execute()) {
        echo json_encode(['message' => 'SUCCESSFUL']);
    } else {
        echo json_encode (['message' => 'error', 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();