<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عيادتي</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo">عيادتي</a>
            <div class="nav-links">
                <a href="index.php">الرئيسية</a>
                <a href="doctors.php">الأطباء</a>
                <a href="appointment.php">حجز موعد</a>
                
                <a href="contact.php">اتصل بنا</a>
                
                <select id="language-switcher">
                    <option value="ar">العربية</option>
                    <option value="en">English</option>
                </select>
            </div>
        </nav>
    </header>
