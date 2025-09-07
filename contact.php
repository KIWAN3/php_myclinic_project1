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
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // التحقق من صحة البيانات
    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('يرجى ملء جميع الحقول.');</script>";
    } else {
        // استخدام Prepared Statements لمنع SQL Injection
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "<script>alert('تم إرسال رسالتك بنجاح! شكرا لتواصلك.');</script>";
        } else {
            echo "<script>alert('حدث خطأ أثناء إرسال الرسالة.');</script>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<?php include 'header.php'; ?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f4f8;
        margin: 0;
        padding: 0;
        direction: rtl;
    }

    .contact {
        max-width: 800px;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .contact:hover {
        transform: scale(1.02);
    }

    #contact-title {
        font-size: 36px;
        color: #2c3e50;
        margin-bottom: 20px;
        text-align: center;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    label {
        font-size: 18px;
        color: #34495e;
        margin-bottom: 10px;
    }

    input,
    textarea {
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }

    input:focus,
    textarea:focus {
        border-color: #3498db;
        outline: none;
    }

    textarea {
        resize: vertical;
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
        align-self: center;
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

<div class="contact">
    <h2 id="contact-title">اتصل بنا</h2>
    <form id="contact-form" method="POST" action="contact.php">
        <label for="name" id="form-name">اسمك:</label>
        <input type="text" id="name" name="name" required>

        <label for="email" id="form-email">بريدك الإلكتروني:</label>
        <input type="email" id="email" name="email" required>

        <label for="message" id="form-message">رسالتك:</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit" id="form-submit">إرسال الرسالة</button>
    </form>
</div>

<?php include 'footer.php'; ?>
