<?php
// Include the database connection file
require_once 'dbCon.php';

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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_about'])) {
    // Retrieve and sanitize form data
    $heading = htmlspecialchars($_POST['heading']);
    $description = htmlspecialchars($_POST['description']);
    $project_count = intval($_POST['project_count']);
    $client_count = intval($_POST['client_count']);
    $review_count = intval($_POST['review_count']);
    $cv_link = htmlspecialchars($_POST['cv_link']);
    $facebook_link = htmlspecialchars($_POST['facebook_link']);
    $linkedin_link = htmlspecialchars($_POST['linkedin_link']);
    $instagram_link = htmlspecialchars($_POST['instagram_link']);
    $twitter_link = htmlspecialchars($_POST['twitter_link']);
    $skills = htmlspecialchars($_POST['skills']);
  
    // Update database
    try {
        $stmt = $pdo->prepare("UPDATE about_section SET heading = :heading, description = :description, project_count = :project_count, client_count = :client_count, review_count = :review_count, cv_link = :cv_link, facebook_link = :facebook_link, linkedin_link = :linkedin_link, instagram_link = :instagram_link, twitter_link = :twitter_link, skills = :skills WHERE id = :id");
        $stmt->execute([
            'heading' => $heading,
            'description' => $description,
            'project_count' => $project_count,
            'client_count' => $client_count,
            'review_count' => $review_count,
            'cv_link' => $cv_link,
            'facebook_link' => $facebook_link,
            'linkedin_link' => $linkedin_link,
            'instagram_link' => $instagram_link,
            'twitter_link' => $twitter_link,
            'skills' => $skills,
            'id' => 1 // Assuming there's an ID of 1 for the About section
        ]);
        echo '<script>alert("About section updated successfully."); window.location.href="adminDash.php";</script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  }
  
  // Fetch current data for the About section
  try {
    $stmt = $pdo->prepare("SELECT * FROM about_section WHERE id = :id");
    $stmt->execute(['id' => 1]);
    $aboutData = $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

// Handle adding a service
if (isset($_POST['add_service'])) {
    $service_title = htmlspecialchars($_POST['service_title']);
    $service_description = htmlspecialchars($_POST['service_description']);
    $service_icon = $_FILES['service_icon']['name'];

    // Handle file upload
    if ($service_icon) {
        $target_dir = "../ICONS/";
        $target_file = $target_dir . basename($service_icon);
        move_uploaded_file($_FILES['service_icon']['tmp_name'], $target_file);
    }

    // Insert into database
    try {
        $stmt = $pdo->prepare("INSERT INTO services (service_icon, service_title, service_description) VALUES (:service_icon, :service_title, :service_description)");
        $stmt->execute([
            'service_icon' => $service_icon,
            'service_title' => $service_title,
            'service_description' => $service_description
        ]);
        echo '<script>alert("Service added successfully."); window.location.href="adminDash.php";</script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle deleting a service
if (isset($_POST['delete_service'])) {
    $service_id = $_POST['service_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM services WHERE serviceID = :serviceID");
        $stmt->execute(['serviceID' => $service_id]);
        echo '<script>alert("Service deleted successfully."); window.location.href="adminDash.php";</script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle adding a project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
    $project_name = htmlspecialchars($_POST['project_name']);
    $project_link = htmlspecialchars($_POST['project_link']);
    $project_image = $_FILES['project_image']['name'];

    // Handle file upload
    if ($project_image) {
        $target_dir = "../images/portfolio/";
        $target_file = $target_dir . basename($project_image);
        move_uploaded_file($_FILES['project_image']['tmp_name'], $target_file);
    }

    // Insert the project into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO portfolio (project_name, project_image, project_link) VALUES (:project_name, :project_image, :project_link)");
        $stmt->execute([
            'project_name' => $project_name,
            'project_image' => $target_file,
            'project_link' => $project_link
        ]);
        echo '<script>alert("Project added successfully."); window.location.href="adminDash.php";</script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
