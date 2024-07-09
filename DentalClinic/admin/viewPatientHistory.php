<?php
include 'connect-db.php';

// Get the patient ID from the request (assume it's passed via GET)
$patientID = isset($_GET['patientID']) ? (int)$_GET['patientID'] : 0;

// Fetch patient details
$patientSql = "SELECT * FROM patient WHERE PatientID = $patientID";
$patientResult = $conn->query($patientSql);
$patient = $patientResult->fetch_assoc();

// Fetch appointments for the patient
$appointmentsSql = "SELECT a.*, d.DoctorName as doctorName 
                    FROM appointments a 
                    JOIN doctors d ON a.doctorID = d.doctorID 
                    WHERE a.patientID = $patientID";
$appointmentsResult = $conn->query($appointmentsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient History - Dental Clinic</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Arial', sans-serif;
            color: #333;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            border-bottom: none;
        }
        .card-body {
            padding: 20px;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
<div class="button-container">
    <a href="index.php" class="btn btn-dark">Dashboard</a>
  </div>
    <?php if ($patient): ?>
        <div class="card">
            <div class="card-header">
                Patient Details
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo $patient['PatientName'] . ' ' . $patient['PatientSurname']; ?></p>
                <p><strong>Phone Number:</strong> <?php echo $patient['PatientPhoneNumber']; ?></p>
                <p><strong>Birthdate:</strong> <?php echo $patient['PatientBirthdate']; ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Appointment History
            </div>
            <div class="card-body">
                <?php if ($appointmentsResult->num_rows > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Doctor</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($appointment = $appointmentsResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $appointment['date']; ?></td>
                                    <td><?php echo $appointment['time']; ?></td>
                                    <td><?php echo $appointment['doctorName']; ?></td>
                                    <td><?php echo $appointment['description']; ?></td>
                                    <td><?php echo $appointment['status']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No appointments found for this patient.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            Patient not found.
        </div>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>