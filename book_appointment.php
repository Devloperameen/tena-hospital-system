<?php
require_once 'config/database.php';

// Check if patient is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$error = '';
$success = '';

// Get doctors list
$doctors = mysqli_query($conn, "SELECT * FROM doctors");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = clean_input($_POST['doctor_id']);
    $appointment_date = clean_input($_POST['appointment_date']);
    $appointment_time = clean_input($_POST['appointment_time']);
    $symptoms = clean_input($_POST['symptoms']);

    if (empty($doctor_id) || empty($appointment_date) || empty($appointment_time)) {
        $error = "Please fill all required fields!";
    } else {
        $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, symptoms) 
                VALUES ($patient_id, $doctor_id, '$appointment_date', '$appointment_time', '$symptoms')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Appointment booked successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Tena Hospital</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>TENA <span>HOSPITAL</span></h1>
                </div>
                <nav class="nav">
                    <ul>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="book_appointment.php">Book Appointment</a></li>
                        <li><a href="view_appointments.php">My Appointments</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <h2>Book Appointment</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label>Select Doctor</label>
                    <select name="doctor_id" required>
                        <option value="" disabled Selected>Choose a doctor</option>
                        <?php while($doctor = mysqli_fetch_assoc($doctors)): ?>
                            <option value="<?php echo $doctor['id']; ?>">
                                <?php echo $doctor['full_name']; ?> - <?php echo $doctor['specialization']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Appointment Date</label>
                    <input type="date" name="appointment_date" required 
                           min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label>Preferred Time</label>
                    <select name="appointment_time" required>
                        <option value="">Select time</option>
                        <option value="9:00 AM">9:00 AM</option>
                        <option value="10:00 AM">10:00 AM</option>
                        <option value="11:00 AM">11:00 AM</option>
                        <option value="2:00 PM">2:00 PM</option>
                        <option value="3:00 PM">3:00 PM</option>
                        <option value="4:00 PM">4:00 PM</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Symptoms (Optional)</label>
                    <textarea name="symptoms" rows="4" placeholder="Describe your symptoms..."></textarea>
                </div>

                <button type="submit" class="btn" style="width:100%">Book Appointment</button>
            </form>
        </div>
    </div>
</body>

</html>
