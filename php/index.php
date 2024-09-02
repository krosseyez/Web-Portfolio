<?php
// Include the database connection file
require_once '../php/dbCon.php';

// Initialize variables for home section data
$dev_image = '';
$dev_name = '';
$dev_title = '';
$dev_intro = '';

// Fetch current home section data
try {
    $stmt = $pdo->query("SELECT * FROM home_section WHERE id = 1");
    $homeData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the data was fetched successfully
    if ($homeData) {
        $dev_image = htmlspecialchars($homeData['dev_image']);
        $dev_name = htmlspecialchars($homeData['dev_name']);
        $dev_title = htmlspecialchars($homeData['dev_title']);
        $dev_intro = nl2br(htmlspecialchars($homeData['dev_intro']));
    } else {
        // Handle case where no data is returned
        $dev_image = 'default-image.jpg'; // Set a default image or handle as needed
        $dev_name = 'Default Name';
        $dev_title = 'Default Title';
        $dev_intro = 'Default introduction text.';
    }
} catch (PDOException $e) {
    echo "Error fetching home section data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Your Portfolio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<nav class="navbar navbar-light bg-secondary fixed-top  shadow-sm">
      <div class="container-lg">
        <a class="navbar-brand text-info fw-bold fs-4" href="#">JohnDoe</a>
        <div class="dropdown">
          <button
            class="btn btn-info px-3"
            type="button"
            id="dropdownMenuButton"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            MENU
          </button>
          <ul
            class="dropdown-menu dropdown-menu-end"
            aria-labelledby="dropdownMenuButton"
          >
            <li><a href="../html/contact.html" class="dropdown-item">Contact Us</a></li>
            <li><a href="../html/signIn.html" class="dropdown-item">Sign In</a></li>
          </ul>
        </div>
      </div>
    </nav>
<!-- Home Section -->
<section id="home" class="section-padding py-5 ">
    <div class="container-lg">
        <div class="row  min-vh-100 align-content-center align-items-center">
            <div class="col-md-6 mt-5 mt-md-0">
                <img src="<?= $dev_image; ?>" alt="Developer Image" class="rounded-circle mw-100" style="height: 450px;">
            </div>
            <div class="col-md-6 order-md-first mt-5 mt-md-0 px-5">
            <p class="text-muted mb-1 fw-bold">Hello I'm</p>
                <h1 class="text-secondary mb-1 fs-1 fw-bold"><?= $dev_name; ?></h1>
                <h2 class="fs-4 mt-1"><?= $dev_title; ?></h2>
                <p  class="text-muted mt-4"><?= $dev_intro; ?></p>
                <a href="#portfolio" class="btn btn-info px-3 mt-3">My Work</a>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
