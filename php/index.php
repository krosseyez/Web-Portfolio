<?php
// Include the database connection file
require_once 'dbCon.php';

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

// Initialize variables
$heading = '';
$description = '';
$project_count = '';
$client_count = '';
$review_count = '';
$cv_link = '';
$facebook_link = '';
$linkedin_link = '';
$instagram_link = '';
$twitter_link = '';
$skills = '';

try {
    // Prepare and execute a query to get the data
    $stmt = $pdo->prepare("SELECT * FROM about_section WHERE id = :id");
    $stmt->execute(['id' => 1]); // Assuming there's an ID of 1 for the About section
    $aboutData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if data is fetched
    if ($aboutData) {
        $heading = htmlspecialchars($aboutData['heading']);
        $description = htmlspecialchars($aboutData['description']);
        $project_count = htmlspecialchars($aboutData['project_count']);
        $client_count = htmlspecialchars($aboutData['client_count']);
        $review_count = htmlspecialchars($aboutData['review_count']);
        $cv_link = htmlspecialchars($aboutData['cv_link']);
        $facebook_link = htmlspecialchars($aboutData['facebook_link']);
        $linkedin_link = htmlspecialchars($aboutData['linkedin_link']);
        $instagram_link = htmlspecialchars($aboutData['instagram_link']);
        $twitter_link = htmlspecialchars($aboutData['twitter_link']);
        $skills = json_decode($aboutData['skills'], true); // Assuming skills are stored as JSON
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$services = [];

try {
    // Prepare and execute a query to get the services data
    $stmt = $pdo->query("SELECT service_icon, service_title, service_description FROM services");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
  // Fetch portfolio projects from the database
  $stmt = $pdo->query("SELECT * FROM portfolio ORDER BY created_at DESC");
  $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

// Fetch testimonials from the database
$stmt = $pdo->query("SELECT * FROM testimonials ORDER BY created_at DESC");
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

<section id="about" class="section-padding py-5">
    <div class="container-lg">
        <div class="row section-heading text-center">
            <h2 class="fw-bold fs-2"><?= $heading; ?></h2>
        </div>
        <div class="row py-5">
            <div class="col-md-6">
                <h3 class="fs-4 mb-3"><?= $description; ?></h3>
                
                <div class="row text-center text-uppercase my-4">
                    <div class="col-sm-4">
                        <div>
                            <h4 class="fs-1 fw-bold"><?= $project_count; ?></h4>
                            <p class="text-muted">Projects completed</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div>
                            <h4 class="fs-1 fw-bold"><?= $client_count; ?></h4>
                            <p class="text-muted">Happy Clients</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div>
                            <h4 class="fs-1 fw-bold"><?= $review_count; ?></h4>
                            <p class="text-muted">Positive Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 align-items-center">
                        <a href="<?= $cv_link; ?>" class="btn px-5 btn-info me-2">Download CV</a>
                        <?php if ($facebook_link): ?><a href="<?= $facebook_link; ?>" class="me-2"><img src="../ICONS/facebook.svg" alt="Facebook" /></a><?php endif; ?>
                        <?php if ($linkedin_link): ?><a href="<?= $linkedin_link; ?>" class="me-2"><img src="../ICONS/linkedin.svg" alt="LinkedIn" /></a><?php endif; ?>
                        <?php if ($instagram_link): ?><a href="<?= $instagram_link; ?>" class="me-2"><img src="../ICONS/instagram.svg" alt="Instagram" /></a><?php endif; ?>
                        <?php if ($twitter_link): ?><a href="<?= $twitter_link; ?>" class="me-2"><img src="../ICONS/twitter.svg" alt="Twitter" /></a><?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-5 mt-md-0">
                <?php foreach ($skills as $skill): ?>
                <div class="skill-item mb-4">
                    <h3 class="fs-6"><?= htmlspecialchars($skill['name']); ?></h3>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= htmlspecialchars($skill['percentage']); ?>%;" aria-valuenow="<?= htmlspecialchars($skill['percentage']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section id="services" class="section-padding py-5">
    <div class="container-lg">
        <div class="row">
            <div class="col text-center section-heading">
                <h3>What I Do</h3>
            </div>
        </div>
        <div class="row">
            <?php foreach ($services as $service): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body shadow text-center">
                        <div class="icon fs-2 text-danger">
                            <img style="height: 40px;" src="../ICONS/<?= htmlspecialchars($service['service_icon']); ?>" alt="">
                        </div>
                        <h3 class="fs-5 py-2"><?= htmlspecialchars($service['service_title']); ?></h3>
                        <p class="text-muted"><?= htmlspecialchars($service['service_description']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="portfolio" class="section-padding py-5">
    <div class="container-lg">
        <div class="row">
            <div class="col text-center section-heading">
                <h3>Latest Work</h3>
            </div>
        </div>
        <div class="row">
            <?php foreach ($projects as $project): ?>
                <div class="col-md-6 col-lg-4 pt-5">
                    <img class="w-100 my-3 img-thumbnail" src="<?= htmlspecialchars($project['project_image']); ?>" alt="Project Image">
                    <h3 class="fs-5 my-2"><?= htmlspecialchars($project['project_name']); ?></h3>
                    <p><a class="text-info" href="<?= htmlspecialchars($project['project_link']); ?>" target="_blank">Live Demo</a></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-padding py-5">
    <div class="container-lg">
        <div class="row">
            <div class="col text-center section-heading">
                <h3>Testimonials</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-7">
                <div id="carousel1" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach ($testimonials as $index => $testimonial): ?>
                            <button
                                type="button"
                                data-bs-target="#carousel1"
                                data-bs-slide-to="<?= $index; ?>"
                                class="<?= $index === 0 ? 'active' : ''; ?> bg-secondary"
                                aria-current="true"
                                aria-label="Slide <?= $index + 1; ?>"
                            ></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach ($testimonials as $index => $testimonial): ?>
                            <div class="bg-white carousel-item <?= $index === 0 ? 'active' : ''; ?> shadow-sm rounded mb-5 p-4">
                                <div class="names">
                                    <h3 class="fs-6 mb-1"><?= htmlspecialchars($testimonial['name']); ?></h3>
                                    <p class="text-muted m-0"><?= htmlspecialchars($testimonial['position']); ?></p>
                                </div>
                                <p class="text-muted mt-3">
                                    <?= htmlspecialchars($testimonial['testimonial_text']); ?>
                                </p>
                                <div class="rating">
                                    <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                        <img src="../ICONS/star-fill.svg" alt="star">
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
