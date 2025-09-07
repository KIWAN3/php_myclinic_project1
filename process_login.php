<?php
session_start(); // بدء الجلسة

// استلام البيانات من النموذج
$username = $_POST['username'];
$password = $_POST['password'];

// التحقق من الاسم وكلمة المرور
if ($username === 'kiwan' && $password === '0000') {
    // تخزين اسم المستخدم في الجلسة
    $_SESSION['username'] = $username;
    header('Location: welcome.php');
    exit();
} else {
    // إذا كانت البيانات غير صحيحة، ارجع إلى صفحة تسجيل الدخول مع رسالة خطأ
    echo "اسم المستخدم أو كلمة المرور غير صحيحة.";
}
?>