<?php
session_start();
require_once 'dbCon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["eMail"];
    $pwd = $_POST["pwd"];

    if (empty($email) || empty($pwd)) {
        $error = "Please fill in all the fields.";
        header("Location: ../html/signIn.html?error=$error");
        exit;
    }

    $query = "SELECT * FROM owners WHERE email = :email AND pwd = :pwd";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $pwd);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // User exists, start session
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION["user_id"] = $userData["adminID"];
        $_SESSION["firstName"] = $userData["firstName"];
        $_SESSION["lastName"] = $userData["lastName"];
        $_SESSION["email"] = $email;

        // Redirect to the admin dashboard
        header("Location: ../html/adminDash.html");
        exit;
    } else {
        $error = "Invalid email or password.";
        header("Location: ../html/signIn.html?error=$error");
        exit;
    }
} else {
    header("Location: ../html/index.html");
    exit;
}
