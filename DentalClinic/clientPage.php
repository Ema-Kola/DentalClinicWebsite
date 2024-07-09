<?php
include 'admin/connect-db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedbackName'], $_POST['feedbackMessage'])) {
    $feedbackName = $conn->real_escape_string($_POST['feedbackName']);
    $feedbackMessage = $conn->real_escape_string($_POST['feedbackMessage']);
    $feedbackDate = date('Y-m-d');


    $feedbackSql = "INSERT INTO feedback (date, content) VALUES ('$feedbackDate', 'Name: $feedbackName\nFeedback: $feedbackMessage')";
    if ($conn->query($feedbackSql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Thank you for your feedback!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: " . $conn->error . "</div>";
    }
}


$generalDataSql = "SELECT phone, email, aboutUs FROM generalData WHERE id = 1";
$generalDataResult = $conn->query($generalDataSql);


if ($generalDataResult->num_rows > 0) {
    $generalData = $generalDataResult->fetch_assoc();
    $phone = $generalData['phone'];
    $email = $generalData['email'];
    $aboutUs = $generalData['aboutUs'];
} else {
    $phone = "N/A";
    $email = "N/A";
    $aboutUs = "N/A";
}


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #add8e6;
            scroll-behavior: smooth;
        }
        .navbar-brand {
            font-family: 'Trebuchet MS', cursive;
            font-size: 2em;
            color: #007bff;
        }
        .feedback-section {
            border: 1px solid transparent;
            padding: 20px;
            margin-top: 20px;
            background-color: #ffffff80; /* 50% transparency */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card {
            background-color: #e0f7fa; /* light blue background */
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card-title {
            color: #007bff;
            font-size: 1.25em;
        }
        .card-text {
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Dental Clinic</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#treatments">View Treatments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#feedback">Add Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallery">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>
            </ul>
        </div>
    </nav>


    <!-- Sections -->
    <div class="container mt-4">
        <!-- View Treatments Section -->
        <section id="treatments">
            <h2>View Treatments</h2>
            <div id="treatmentButtons" class="row">
                <?php
                    include('admin/connect-db.php');
                    $result = mysqli_query($conn, "SELECT * FROM treatment") or die(mysqli_error($conn));
                    while($row = mysqli_fetch_array($result)) {
                        echo '<div class="col-md-4 mb-3">';
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row['TreatmentName'] . '</h5>';
                        echo '<p class="card-text">Price: ' . $row['Price'] . ' ALL</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
            <div id="treatmentDetails" class="mt-4"></div>
        </section>


        <!-- Add Feedback Section -->
        <section id="feedback" class="feedback-section mt-4">
            <h2>Add Feedback</h2>
            <form id="feedbackForm" method="post" action="">
                <div class="form-group">
                    <label for="feedbackName">Name</label>
                    <input type="text" class="form-control" id="feedbackName" name="feedbackName" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <label for="feedbackMessage">Feedback</label>
                    <textarea class="form-control" id="feedbackMessage" name="feedbackMessage" rows="3" placeholder="Your Feedback" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </section>


        <!-- Gallery Section -->
        <section id="gallery" class="mt-4">
            <h2>Gallery</h2>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="https://media.istockphoto.com/id/1349328691/photo/young-happy-woman-during-dental-procedure-at-dentists-office.jpg?s=612x612&w=0&k=20&c=H0WBvMhyspSX10Xq65AFhF4DoMLzg8wOpqjjupwTWDE=" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://i.pinimg.com/736x/4f/d7/96/4fd7966486f0db87e58a36a081619a62.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://wildwooddentalclinic.com/wp-content/uploads/2018/08/family-dentistry.jpg" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://www.dentalclinicportishead.co.uk/wp-content/uploads/2021/09/dentist.jpg" alt="Fourth slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://cdn.pixabay.com/photo/2023/09/03/15/59/ai-generated-8230961_1280.jpg" alt="Fifth slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>


  <!-- Contact Info Section -->
<section id="contact" class="mt-4">
    <h2>Contact Info</h2>
    <p>Phone: <?php echo $phone; ?></p>
    <p>Email: <?php echo $email; ?></p>
</section>


<!-- About Us Section -->
<section id="about" class="mt-4">
    <h2>About Us</h2>
    <p><?php echo nl2br($aboutUs); ?></p>
</section>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>