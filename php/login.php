<?php
require_once 'dbCon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $role = '';

    if (empty($username) || empty($password)) {
        echo "<script>alert('All fields are required'); window.location.href='../html/signIn.html';</script>";
        exit();
    }

    // Check in the admin table
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($pwd, $user['pwd'])) {
            $role = $user['role'];
            session_start();
            $_SESSION['user'] = $user;
            if ($role === 'admin') {
                header("Location: ../html/adminDash.html");
                exit();
            }
        }
    }

    // Check in the assistance table
    $stmt = $pdo->prepare("SELECT * FROM assistance WHERE email = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['pwd'])) {
            $role = $user['role'];
            session_start();
            $_SESSION['user'] = $user;
            if ($role === 'assistance') {
                header("Location: ../html/assistanceDash.html");
                exit();
            }
        }
    }

    echo "<script>alert('Invalid username or password'); window.location.href='../html/signIn.html';</script>";
}
?>
