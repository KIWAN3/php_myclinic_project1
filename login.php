<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - عيادتي</title>
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
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .login-container h2 {
            color: #007BFF;
            margin-bottom: 20px;
        }
        .login-container img {
            width: 100px;
            margin-bottom: 20px;
        }
        .login-container label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .login-container button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .welcome-message {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="doctor.png" alt="صورة الطبيب">
        <h2>مرحبًا أيها الطبيب</h2>
        <p class="welcome-message">قم بتسجيل الدخول لإدارة الحجوزات</p>
        <form method="POST" action="process_login.php">
            <label for="username">اسم المستخدم:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">تسجيل الدخول</button>
        </form>
    </div>
</body>
</html>
