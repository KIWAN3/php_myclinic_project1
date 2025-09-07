<?php
session_start();

// الاتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'myclinic_db');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_name = $_POST['doctor_name'];
    $password = $_POST['password'];

    // التحقق من صحة بيانات تسجيل الدخول
    $sql = "SELECT * FROM doctors WHERE doctor_name = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $doctor_name, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['doctor_logged_in'] = true;
        $_SESSION['doctor_name'] = $doctor_name;
        header("Location: doctor_dashboard.php"); // إعادة التوجيه إلى واجهة الطبيب
        exit();
    } else {
        echo "<script>alert('اسم المستخدم أو كلمة المرور غير صحيحة.');</script>";
    }
}
?>

<?php include 'header.php'; ?>

<div class="login-container">
    <div class="login-image">
        <img src="images/doctorfront.png" alt="Doctor Icon">
    </div>
    <h2>تسجيل دخول الطبيب</h2>
    <form method="POST" action="doctor_login.php">
        <label for="doctor_name">اسم الطبيب:</label>
        <input type="text" id="doctor_name" name="doctor_name" required>

        <label for="password">كلمة المرور:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">تسجيل الدخول</button>
    </form>
</div>

<?php include 'footer.php'; ?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f4f8;
        margin: 0;
        padding: 0;
        direction: rtl;
        text-align: center;
    }

    .login-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: all 0.3s ease;
    }

    .login-container:hover {
        transform: scale(1.02);
    }

    .login-image img {
        max-width: 150px;
        margin-bottom: 20px;
    }

    h2 {
        font-size: 28px;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    label {
        font-size: 18px;
        color: #34495e;
        margin-bottom: 10px;
        text-align: right;
    }

    input {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
        margin-bottom: 20px;
        transition: border-color 0.3s ease;
    }

    input:focus {
        border-color: #3498db;
        outline: none;
    }

    button[type="submit"] {
        background-color: #2ecc71;
        color: white;
        font-size: 18px;
        padding: 15px 40px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    button[type="submit"]:hover {
        background-color: #27ae60;
    }

    footer {
        background-color: #34495e;
        color: white;
        text-align: center;
        padding: 15px;
        margin-top: 50px;
    }

    footer p {
        font-size: 14px;
    }
</style>
