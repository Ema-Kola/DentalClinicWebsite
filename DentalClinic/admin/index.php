<?php
session_start();

if (!isset($_SESSION["username"]) || !isset($_SESSION["logout_token"])) {
    header("Location: ../index.php");
    exit();
}

// Securely handle the logout process using the token
if (isset($_POST["logout"])) {
    if (hash_equals($_SESSION["logout_token"], $_POST["logout_token"])) {
        session_unset();
        session_destroy();
        header("Location: ../index.php");
        exit();
    } else {
        die("Invalid logout request.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dental Clinic</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://source.unsplash.com/1920x1080/?dental') no-repeat center center fixed; //kjo duhet ndryshuar me nje imazh qe do vendosim per bg
            background-size: cover;
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff;
        }
        .navbar-nav .nav-link {
            color: #fff;
        }
        .dashboard-card {
            margin-bottom: 40px;
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        .card-body {
            text-align: center;
            padding: 40px 20px;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #343a40;
        }
        .card-text {
            color: #6c757d;
        }
        .card-icon {
            font-size: 3rem;
            color: #007bff;
            margin-bottom: 20px;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Dental Clinic Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <input type="hidden" name="logout_token" value="<?php echo $_SESSION["logout_token"]; ?>">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Dashboard</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Logout</a>
                </li> -->
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 dashboard-card mx-3" onclick="window.location.href = 'viewAppointments.php'">>
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon">📅</div>
                        <h5 class="card-title">Make/Edit Appointment</h5>
                        <p class="card-text">Confirm or cancel appointments.</p>
                    </div>
                </div>
            </div>
           
            <div class="col-md-5 dashboard-card mx-3" data-toggle="modal" data-target="#patientHistoryModal">
    <div class="card">
        <div class="card-body">
            <div class="card-icon">📋</div>
            <h5 class="card-title">View Patient History</h5>
            <p class="card-text">Check patient records and history.</p>
        </div>
    </div>
</div>
   
            <div class="col-md-5 dashboard-card mx-3" onclick="window.location.href = 'viewDoctor.php'">>
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon">👨‍⚕️</div>
                        <h5 class="card-title">Add/Edit Doctor</h5>
                        <p class="card-text">Manage doctor details.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 dashboard-card mx-3" onclick="window.location.href = 'viewpatients1.php'">
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon">👥</div>
                        <h5 class="card-title">Add/Edit Patient</h5>
                        <p class="card-text">Manage patient details.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 dashboard-card mx-3" onclick="window.location.href = 'viewTreatments.php'">>
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon">💉</div>
                        <h5 class="card-title">Add/Edit Treatment</h5>
                        <p class="card-text">Manage treatments and services.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-5 dashboard-card mx-3" onclick="window.location.href = 'viewGeneralData.php'">>
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon">💉</div>
                        <h5 class="card-title">Change General Data</h5>
                        <p class="card-text">Update clinic information..</p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-5 dashboard-card mx-3" onclick="openModal('changeDataModal')">
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon">⚙️</div>
                        <h5 class="card-title">Change General Data</h5>
                        <p class="card-text">Update clinic information.</p>
                    </div>
                </div>
            </div> -->
            <div class="col-md-5 dashboard-card mx-3" onclick="window.location.href = 'viewFeedback.php'">>
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon">🗣️</div>
                        <h5 class="card-title">View Feedback</h5>
                        <p class="card-text">Check patient feedback.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5 dashboard-card mx-3">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="logout_token" value="<?php echo $_SESSION["logout_token"]; ?>">
                    <button type="submit" name="logout" class="btn btn-dark btn-sm">Logout</button>
            </form>
            </div>
            <!-- <div class="col-md-5 dashboard-card mx-3" onclick="window.location.href = 'logout.php'">>
                <div class="card">
                    <div class="card-body">
                        <div class="card-icon">🔒</div>
                        <h5 class="card-title">Logout</h5>
                        <p class="card-text">Logout from the admin dashboard.</p>
                    </div>
                </div>
            </div> -->
        </div>
    </div>


    <!-- Change Data Modal -->
    <div class="modal fade" id="changeDataModal" tabindex="-1" aria-labelledby="changeDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeDataModalLabel">Change General Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changeDataForm" method="POST" action="changedata.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="aboutUs">About Us</label>
                            <textarea class="form-control" id="aboutUs" name="aboutUs" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="gallery">Gallery</label>
                            <input type="url" class="form-control" id="gallery" name="gallery" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="patientHistoryModal" tabindex="-1" aria-labelledby="patientHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="patientHistoryModalLabel">Enter Patient ID</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="patientHistoryForm" method="GET" action="viewPatientHistory.php">
                        <div class="form-group">
                            <label for="patientID">Patient ID</label>
                            <input type="number" class="form-control" id="patientID" name="patientID" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">View History</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // function showAlert(section) {
        //     if (section === 'Logout') {
        //         window.location.href = 'logout.php'; // Redirect to logout page
        //     } else {
        //         alert("You clicked on " + section);
        //     }
        // }


        function openModal(modalId) {
            $('#' + modalId).modal('show');
        }
    </script>
</body>
</html>


