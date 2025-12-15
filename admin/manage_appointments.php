<?php
require_once '../config/database.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: manage_appointments");
    exit();
}

$success = '';
$error = '';

// APPROVE appointment
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    if (mysqli_query($conn, "UPDATE appointments SET status='approved' WHERE id=$id")) {
        $success = "Appointment approved successfully!";
    } else {
        $error = "Failed to approve appointment.";
    }
}

// DELETE appointment
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if (mysqli_query($conn, "DELETE FROM appointments WHERE id=$id")) {
        $success = "Appointment deleted successfully!";
    } else {
        $error = "Failed to delete appointment.";
    }
}

// Fetch all appointments
$sql = "SELECT 
            appointments.*, 
            doctors.full_name AS doctor_name
        FROM appointments
        JOIN doctors ON appointments.doctor_id = doctors.id
        ORDER BY appointments.created_at DESC";

$appointments = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Appointments - Tena Hospital</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<!-- HEADER -->
<div class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1>TENA <span>HOSPITAL</span> - ADMIN</h1>
                </div>
                <nav class="nav">
                    <ul>
                        <li><a href="manage_appointments.php">App</a></li>
                        <li><a href="admin_dashboard.php">Dashboard</a></li>
                        <li><a href="manage_doctors.php">Manage Doctors</a></li>
                        <li><a href="../logout.php">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

<!-- CONTENT -->
<div class="container">

    <h2>Manage Appointments</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($appointments) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($appointments)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>

                        <td>
                            <?php echo $row['patient_id']; ?><br>
                            <small><?php echo $row['patient_phone']; ?></small>
                        </td>

                        <td><?php echo $row['doctor_name']; ?></td>
                        <td><?php echo $row['appointment_date']; ?></td>
                        <td><?php echo $row['appointment_time']; ?></td>

                        <td>
                            <?php if ($row['status'] == 'pending'): ?>
                                <span style="color:orange;">Pending</span>
                            <?php elseif ($row['status'] == 'approved'): ?>
                                <span style="color:green;">Approved</span>
                            <?php else: ?>
                                <span style="color:red;">Rejected</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if ($row['status'] == 'pending'): ?>
                                <a class="btn btn-success"
                                   href="?approve=<?php echo $row['id']; ?>">
                                   Approve
                                </a>
                            <?php endif; ?>

                            <a class="btn btn-danger"
                               href="?delete=<?php echo $row['id']; ?>"
                               onclick="return confirm('Delete this appointment?')">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>

</div>

</body>
</html>
