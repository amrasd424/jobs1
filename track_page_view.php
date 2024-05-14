<?php
// استقبال البيانات المُرسلة بواسطة POST من النص البرمجي JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// التحقق من أن البيانات قد تم استلامها بنجاح
if(isset($data['timestamp']) && isset($data['userAgent'])) {
    // فتح ملف للتسجيل بوضع الإضافة لإضافة البيانات الجديدة
    $file = fopen("tracked_page_views.txt", "a");

    // كتابة البيانات إلى الملف مع تنسيقها المناسب
    fwrite($file, "Timestamp: " . $data['timestamp'] . "\n");
    fwrite($file, "User Agent: " . $data['userAgent'] . "\n");

    // إغلاق الملف بعد الانتهاء من الكتابة
    fclose($file);
} else {
    // إذا لم يتم العثور على الملف، يتم إنشاء ملف جديد
    $file = fopen("tracked_page_views.txt", "w");
    fclose($file);
}
?>