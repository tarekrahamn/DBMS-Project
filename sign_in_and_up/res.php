<?php
include 'connect.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (isset($_POST['email'])) {
        // Sign up
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']); // Note: md5 is outdated, use password_hash instead

        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM loginfirst WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "Email Address Already Exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO loginfirst (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);
            if ($stmt->execute()) {
                header("Location: index.php");
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        // Sign in
        $email = $_POST['username'];
        $password = md5($_POST['password']);

        $stmt = $conn->prepare("SELECT * FROM loginfirst WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            session_start();
            $row = $result->fetch_assoc();
            $_SESSION['email'] = $row['email'];
            header("Location: homepage.php");
            exit();
        } else {
            echo "Incorrect Email or Password";
        }
        $stmt->close();
    }
}
?>
