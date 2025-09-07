<?php
session_start(); // بدء الجلسة

// التحقق من وجود جلسة المستخدم
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // إذا لم يكن المستخدم مسجل الدخول، ارجع إلى صفحة تسجيل الدخول
    exit();

}

?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مرحبًا - عيادتي</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .welcome-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .welcome-container h1 {
            color: #007BFF;
            margin-bottom: 20px;
        }
        .welcome-container p {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        .welcome-container a {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
        }
        .welcome-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>مرحبًا، <?php echo $_SESSION['username']; ?></h1>
        <p>لقد قمت بتسجيل الدخول بنجاح!</p>
        <a href="logout.php">تسجيل الخروج</a>
    </div>
</body>
</html>