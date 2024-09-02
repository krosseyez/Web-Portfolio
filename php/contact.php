<?php
// Include the database connection file
include 'dbCon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fName = trim($_POST['fName']);
    $lName = trim($_POST['lName']);
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);

    // Check if any field is empty
    if (empty($fName) || empty($lName) || empty($email) || empty($comment)) {
        echo "All fields are required.";
        exit;
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO contact_form (first_name, last_name, email, comment) 
            VALUES (?, ?, ?, ?)";

    try {
        // Prepare the statement
        $stmt = $pdo->prepare($sql);

        // Execute the statement with the form data
        $stmt->execute([$fName, $lName, $email, $comment]);

        // Redirect to a thank you page or display a success message
        echo '<script>
                alert("It was successful, we will get back in touch soon.");
                window.location.href = "../html/index.html";
              </script>';
    } catch (PDOException $e) {
        // Display an error message if something goes wrong
        echo '<script>
                alert("An error occurred: ' . $e->getMessage() . '");
                window.location.href = "../html/contact.html";
              </script>';
    }
} else {
    // If the request method is not POST, redirect or show an error
    echo "Invalid request method.";
}

