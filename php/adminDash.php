<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../css/style.css" />
    <title>JohnDoe</title>
  </head>
  <body>
    <nav class="navbar navbar-light bg-secondary fixed-top shadow-sm">
      <div class="container-lg">
        <a class="navbar-brand text-info fw-bold fs-4" href="#"
          >Admin Dashboard</a
        >
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
            <li><a href="contact.html" class="dropdown-item">Contact Us</a></li>
            <li><a href="signIn.html" class="dropdown-item">Sign In</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <section id="home" class="section padding py-5">
      <div class="container-lg">
        <div class="row min-vh-100 align-content-center align-items-center">
          <div class="col-md-6 mt-5 mt-md-0">
            <img
              src="../images/KILLUA.jpeg"
              class="rounded-circle mw-100"
              alt=""
              srcset=""
              style="height: 450px"
            />
          </div>
          <div class="col-md-6 order-md-first mt-5 mt-md-0">
            <p class="text-muted mb-1 fw-bold">Hello I'm</p>
            <h1 class="text-secondary mb-1 fs-1 fw-bold">WEB DEVELOPER</h1>
            <h2 class="fs-4 mt-1">John Doe</h2>
            <p class="text-muted mt-4">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse
              animi repellat, expedita molestiae dolorem quas. Maiores, nemo!
            </p>
            <a href="#portfolio" class="btn btn-info px-3 mt-3">My Work</a>
          </div>
        </div>
      </div>
    </section>

    <section id="contact-messages" class="section padding py-5">
      <div class="container-lg">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <?php
          // Database connection
          $conn = new mysqli('localhost', 'username', 'password', 'portfolio');

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Fetch contact form data
          $sql = "SELECT * FROM contact_form";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $id = $row['id'];
                  $first_name = htmlspecialchars($row['first_name']);
                  $last_name = htmlspecialchars($row['last_name']);
                  $created_at = htmlspecialchars($row['created_at']);
                  $comment = htmlspecialchars($row['comment']);
                  
                  echo '<div class="accordion-item">';
                  echo '<h2 class="accordion-header" id="flush-heading' . $id . '">';
                  echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse' . $id . '" aria-expanded="false" aria-controls="flush-collapse' . $id . '">';
                  echo $first_name . ' ' . $last_name . ' (' . $created_at . ')';
                  echo '</button>';
                  echo '</h2>';
                  echo '<div id="flush-collapse' . $id . '" class="accordion-collapse collapse" aria-labelledby="flush-heading' . $id . '" data-bs-parent="#accordionFlushExample">';
                  echo '<div class="accordion-body">' . $comment . '</div>';
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

          $conn->close();
          ?>
        </div>
      </div>
    </section>

    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
