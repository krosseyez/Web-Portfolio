<?php
// Include the database connection file
require_once '../php/dbCon.php';

// Handle delete request
if (isset($_POST['delete'])) {
    $idToDelete = $_POST['message_id'];

    try {
        $deleteStmt = $pdo->prepare("DELETE FROM contact_form WHERE id = :id");
        $deleteStmt->execute([':id' => $idToDelete]);

        // Trigger the toast by setting a flag in the session
        echo "<script>showDeleteToast();</script>";
    } catch (PDOException $e) {
        echo "Error deleting message: " . $e->getMessage();
    }
}

// Handle form submission for editing the home section
if (isset($_POST['edit_home'])) {
    // Get form data
    $devName = $_POST['dev_name'];
    $devTitle = $_POST['dev_title'];
    $devIntro = $_POST['dev_intro'];

    // Handle image upload
    $imagePath = '../images/KILLUA.jpeg'; // Default image path
    if (!empty($_FILES['dev_image']['name'])) {
        $targetDir = "../images/";
        $targetFile = $targetDir . basename($_FILES['dev_image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES['dev_image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['dev_image']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile; // Update image path if upload is successful
            } else {
                echo "<script>alert('Error uploading image.');</script>";
            }
        } else {
            echo "<script>alert('File is not an image.');</script>";
        }
    }

    // Update home section data in the database
    try {
        $updateStmt = $pdo->prepare("UPDATE home_section SET dev_name = :devName, dev_title = :devTitle, dev_intro = :devIntro, dev_image = :devImage WHERE id = 1");
        $updateStmt->execute([
            ':devName' => $devName,
            ':devTitle' => $devTitle,
            ':devIntro' => $devIntro,
            ':devImage' => $imagePath
        ]);
        echo "<script>alert('Home section updated successfully!');</script>";
    } catch (PDOException $e) {
        echo "Error updating home section: " . $e->getMessage();
    }
}

// Fetch current home section data
try {
    $stmt = $pdo->query("SELECT * FROM home_section WHERE id = 1");
    $homeData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching home section data: " . $e->getMessage();
}
?>
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <title>Admin Dashboard</title>
</head>

<body>


    <nav class="navbar navbar-light bg-secondary fixed-top shadow-sm">
        <div class="container-lg">
            <a class="navbar-brand text-info fw-bold fs-4" href="#">Admin Dashboard</a>
            <div class="dropdown">
                <button class="btn btn-info px-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    MENU
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li><a href="contact.html" class="dropdown-item">Contact Us</a></li>
                    <li><a href="signIn.html" class="dropdown-item">Sign In</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="contact-messages" class="section-padding py-5">
        <div class="container-lg card shadow">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <?php
                try {
                    // Fetch contact form data
                    $stmt = $pdo->query("SELECT * FROM contact_form");

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $id = $row['id'];
                            $first_name = htmlspecialchars($row['first_name']);
                            $last_name = htmlspecialchars($row['last_name']);
                            $email = htmlspecialchars($row['email']);
                            $created_at = htmlspecialchars($row['created_at']);
                            $comment = htmlspecialchars($row['comment']);
                            $status = htmlspecialchars($row['status']);

                            // Apply the 'text-muted' class if the status is 'read'
                            $dimClass = ($status === 'read') ? 'text-muted' : '';

                            echo '<div class="accordion-item">';
                            echo '<h2 class="accordion-header" id="flush-heading' . $id . '">';
                            echo '<button class="accordion-button collapsed ' . $dimClass . '" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $id . '" aria-expanded="false" aria-controls="flush-collapse' . $id . '">';
                            echo $first_name . ' ' . $last_name . ' (' . $created_at . ')';
                            echo '</button>';
                            echo '</h2>';
                            echo '<div id="flush-collapse' . $id . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $id . '" data-bs-parent="#accordionFlushExample">';
                            echo '<div class="accordion-body">';
                            echo '<p>' . $comment . '</p>';
                            echo '<form method="post" class="d-inline-block me-2">';
                            echo '<input type="hidden" name="message_id" value="' . $id . '">';
                            echo '<button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>';
                            echo '</form>';
                            echo '<button type="button" class="btn btn-primary btn-sm" onclick="copyToClipboard(\'' . $email . '\')">Copy Email</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="accordion-item">';
                        echo '<h2 class="accordion-header">';
                        echo '<button class="accordion-button" type="button" disabled>';
                        echo 'No messages available';
                        echo '</button>';
                        echo '</h2>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </section>


    <section id="edit-home-section" class="section-padding py-5">
        <div class=" container-lg card shadow px-5 py-4">
            <h2>Edit Home Section</h2>
            <form action="adminDash.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="dev_image" class="form-label">Developer Image</label>
                    <input type="file" class="form-control" id="dev_image" name="dev_image">
                    <img src="<?= $homeData['dev_image']; ?>" alt="Current Image"
                        style="max-height: 100px; margin-top: 10px;">
                </div>
                <div class="mb-3">
                    <label for="dev_name" class="form-label">Developer Name</label>
                    <input type="text" class="form-control" id="dev_name" name="dev_name"
                        value="<?= htmlspecialchars($homeData['dev_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="dev_title" class="form-label">Developer Title</label>
                    <input type="text" class="form-control" id="dev_title" name="dev_title"
                        value="<?= htmlspecialchars($homeData['dev_title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="dev_intro" class="form-label">Introduction</label>
                    <textarea class="form-control" id="dev_intro" name="dev_intro" rows="3"
                        required><?= htmlspecialchars($homeData['dev_intro']); ?></textarea>
                </div>
                <button type="submit" name="edit_home" class="btn btn-primary">Update Home Section</button>
            </form>
        </div>
    </section>



    <!-- Toast Notification for Copying Email -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="copyToast" class="toast align-items-center text-white bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Email address copied to clipboard!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Toast Notification for Deletion -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="deleteToast" class="toast align-items-center text-white bg-SECONDARY border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Message deleted successfully!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script>
        // Function to copy email to clipboard
        function copyToClipboard(email) {
            navigator.clipboard.writeText(email).then(
                function () {
                    showCopyToast(); // Show toast notification on success
                },
                function (err) {
                    console.error("Failed to copy email: ", err);
                }
            );
        }

        // Function to show the copy toast notification
        function showCopyToast() {
            var toastElement = document.getElementById("copyToast");
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        // Function to show the delete toast notification
        function showDeleteToast() {
            var toastElement = document.getElementById("deleteToast");
            var toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    </script>
</body>

</html>