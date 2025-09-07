<?php
session_start();

// تفعيل عرض الأخطاء لأغراض التصحيح (يجب إزالتها في الإنتاج)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// الاتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'myclinic_db');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// معالجة النموذج عند إرساله
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // التحقق من صحة الإدخال
    $patient_name = htmlspecialchars($_POST['name']); // تعقيم الإدخال
    $phone = htmlspecialchars($_POST['phone']); // تعقيم الإدخال
    $doctor_name = htmlspecialchars($_POST['doctor']); // تعقيم الإدخال
    $appointment_date = $_POST['date'];
    $appointment_time = $_POST['time'];

    // التحقق من صحة البيانات
    if (empty($patient_name) || empty($phone) || empty($doctor_name) || empty($appointment_date) || empty($appointment_time)) {
        echo "<script>alert('يرجى ملء جميع الحقول.');</script>";
    } else {
        // استخدام Prepared Statements لمنع SQL Injection
        $stmt = $conn->prepare("INSERT INTO appointments (patient_name, phone, doctor_name, appointment_date, appointment_time, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->bind_param("sssss", $patient_name, $phone, $doctor_name, $appointment_date, $appointment_time);

        if ($stmt->execute()) {
            echo "<script>alert('تم حجز الموعد بنجاح! ستتلقى رسالة SMS أو بريدًا إلكترونيًا بعد موافقة الطبيب.');</script>";
        } else {
            echo "<script>alert('حدث خطأ أثناء حجز الموعد.');</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<?php include 'header.php'; ?>

<style>
    .appointment-container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .appointment-container h2 {
        color: #333;
    }
    .appointment-container p {
        font-size: 18px;
        color: #555;
        margin-bottom: 20px;
    }
    .appointment-container form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .appointment-container input, 
    .appointment-container select, 
    .appointment-container button {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 16px;
    }
    .appointment-container button {
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }
    .appointment-container button:hover {
        background-color: #218838;
    }
</style>

<div class="appointment-container">
    <h2>حجز موعد</h2>
    <p>حجز المواعيد من 9 صباحا الى 8 مساء</p>
    <form id="appointment-form" method="POST" action="appointment.php">
        <label for="name">اسم المريض:</label>
        <input type="text" id="name" name="name" required>

        <label for="phone">رقم الهاتف:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="doctor">اختر الطبيب:</label>
        <select id="doctor" name="doctor" required>
            <option value="د. أحمد">د. أحمد</option>
            <option value="د. سارة">د. سارة</option>
        </select>

        <label for="date">تاريخ الموعد:</label>
        <input type="date" id="date" name="date" required>

        <label for="time">وقت الموعد:</label>
        <input type="time" id="time" name="time" required>

        <button type="submit">احجز الموعد</button>
    </form>
</div>

<?php include 'footer.php'; ?>