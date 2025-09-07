<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عيادتي - الأطباء</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .doctors {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .doctor-cards {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            text-align: center;
            width: 300px;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .card h3 {
            color: #333;
            margin-bottom: 5px;
        }
        .card p {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="index.php" class="logo" id="nav-logo">عيادتي</a>
            <div class="nav-links">
                <a href="index.php" id="nav-home">الرئيسية</a>
                <a href="doctors.php" id="nav-doctors">الأطباء</a>
                <a href="appointment.php" id="nav-appointment">حجز موعد</a>
                <a href="contact.php" id="nav-contact">اتصل بنا</a>
                <select id="language-switcher">
                    <option value="ar">العربية</option>
                    <option value="en">English</option>
                </select>
            </div>
        </nav>
    </header>

    <section class="doctors">
        <h2 id="doctors-title">أطباؤنا</h2>
        <div class="doctor-cards">
            <div class="card">
                <img src="images/doctor1.jpg" alt="د. أحمد">
                <h3>د. أحمد</h3>
                <p id="doctor1-specialty">أخصائي جراحة العظام</p>
                <p>خبرة 15 سنة في جراحة العظام والمفاصل.</p>
                <p>المستشفى: مستشفى الشفاء التخصصي</p>
            </div>
            <div class="card">
                <img src="images/doctor2.jpg" alt="د. سارة">
                <h3>د. سارة</h3>
                <p id="doctor2-specialty">أخصائية طب الأسنان</p>
                <p>خبرة 10 سنوات في طب الأسنان وعلاج اللثة.</p>
                <p>المستشفى: مركز الابتسامة المضيئة</p>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>