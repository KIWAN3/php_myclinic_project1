<?php
session_start();
require __DIR__ . '/vendor/autoload.php'; // Load Twilio SDK

use Twilio\Rest\Client;

// Twilio Credentials
$twilio_sid = "AC9cc18ade14d320c34b3dc2e04b55289c";
$twilio_token = "100e710d53456937e06be0d69542f8c4";
$twilio_number = "+18145243431";

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'myclinic_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if doctor is logged in
if (!isset($_SESSION['doctor_logged_in'])) {
    header("Location: doctor_login.php");
    exit();
}

// Fetch appointments including phone number
if ($_SESSION['doctor_name'] === 'kiwan') {
    $sql = "SELECT id, patient_name, phone, doctor_name, appointment_date, appointment_time, status FROM appointments";
} else {
    $sql = "SELECT id, patient_name, phone, doctor_name, appointment_date, appointment_time, status FROM appointments WHERE doctor_name = ?";
}

$stmt = $conn->prepare($sql);
if ($_SESSION['doctor_name'] !== 'kiwan') {
    $stmt->bind_param("s", $_SESSION['doctor_name']);
}
$stmt->execute();
$result = $stmt->get_result();

// Function to send SMS
function send_sms($to, $message) {
    global $twilio_sid, $twilio_token, $twilio_number;

    $client = new Client($twilio_sid, $twilio_token);
    try {
        $client->messages->create(
            $to,
            [
                'from' => $twilio_number,
                'body' => "Sent from Twilio: " . $message
            ]
        );
    } catch (Exception $e) {
        error_log("Twilio Error: " . $e->getMessage());
    }
}

// Handle appointment actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'], $_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];

    // Fetch patient phone number
    $phone_query = "SELECT phone FROM appointments WHERE id = ?";
    $phone_stmt = $conn->prepare($phone_query);
    $phone_stmt->bind_param("i", $appointment_id);
    $phone_stmt->execute();
    $phone_result = $phone_stmt->get_result();
    $patient_data = $phone_result->fetch_assoc();
    $patient_phone = $patient_data['phone'];
    $phone_stmt->close();

    if ($_POST['action'] == 'accept') {
        $update_sql = "UPDATE appointments SET status = 'مقبول' WHERE id = ?";
        send_sms($patient_phone, "Your appointment has been accepted.");
    } elseif ($_POST['action'] == 'delete') {
        $update_sql = "DELETE FROM appointments WHERE id = ?";
        send_sms($patient_phone, "Your appointment has been canceled.");
    } elseif ($_POST['action'] == 'edit' && isset($_POST['new_date'], $_POST['new_time'])) {
        $update_sql = "UPDATE appointments SET appointment_date = ?, appointment_time = ? WHERE id = ?";
        send_sms($patient_phone, "Your appointment has been rescheduled to {$_POST['new_date']} at {$_POST['new_time']}.");
    }

    $update_stmt = $conn->prepare($update_sql);
    if ($_POST['action'] == 'edit') {
        $update_stmt->bind_param("ssi", $_POST['new_date'], $_POST['new_time'], $appointment_id);
    } else {
        $update_stmt->bind_param("i", $appointment_id);
    }
    $update_stmt->execute();
    $update_stmt->close();
    header("Location: doctor_dashboard.php");
    exit();
}

// Add new appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_appointment'])) {
    $patient_name = $_POST['patient_name'];
    $patient_phone = $_POST['patient_phone'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $doctor_name = $_SESSION['doctor_name'];

    $insert_sql = "INSERT INTO appointments (patient_name, phone, doctor_name, appointment_date, appointment_time, status) VALUES (?, ?, ?, ?, ?, 'قيد الانتظار')";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sssss", $patient_name, $patient_phone, $doctor_name, $appointment_date, $appointment_time);
    $insert_stmt->execute();
    $insert_stmt->close();

    send_sms($patient_phone, "Your appointment has been scheduled for $appointment_date at $appointment_time.");
    header("Location: doctor_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>واجهة الطبيب - عيادتي</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; }
        table { width: 80%; margin: auto; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        button { padding: 5px 10px; margin: 5px; cursor: pointer; }
        .accept { background-color: #28a745; color: white; }
        .delete { background-color: #dc3545; color: white; }
        .edit { background-color: #ffc107; color: black; }
    </style>
</head>
<body>
    <header>
        <h1>لوحة تحكم الطبيب</h1>
    </header>
    
    <h2>إضافة موعد جديد</h2>
    <form method="POST">
        <input type="text" name="patient_name" placeholder="اسم المريض" required>
        <input type="text" name="phone" placeholder="رقم الهاتف" required> <!-- 📞 New input field -->
        <input type="date" name="appointment_date" required>
        <input type="time" name="appointment_time" required>
        <button type="submit" name="add_appointment">إضافة</button>
    </form>
    
    <h2>حجوزات المواعيد</h2>
    <table>
        <tr>
            <th>اسم المريض</th>
            <th>رقم الهاتف</th> <!-- 📞 New column -->
            <th>اسم الطبيب</th>
            <th>التاريخ</th>
            <th>الوقت</th>
            <th>الحالة</th>
            <th>إجراءات</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td> <!-- 📞 New field displayed -->
                <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="accept" class="accept">قبول</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="delete" class="delete">حذف</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                        <input type="date" name="new_date" required>
                        <input type="time" name="new_time" required>
                        <button type="submit" name="action" value="edit" class="edit">تعديل</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>