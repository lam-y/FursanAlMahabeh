<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة جديدة</title>
</head>
<body dir="rtl" style="text-align: right; float: right; width: 100%; margin: 0;">
    <div style="float: right; width: 50%; margin-right: 20px;">
        <h2>تم إرسال رسالة جديدة إلى موقع فرسان المحبة</h2>
        <p><strong>الاسم:</strong> {{ $messageData['name'] }}</p>
        <p><strong>البريد الإلكتروني:</strong> {{ $messageData['email'] }}</p>
        <p><strong>موبايل:</strong> {{ $messageData['phone'] }}</p>
        <p><strong>تاريخ الميلاد:</strong> {{ $messageData['birthdate'] }}</p>
        <p><strong>الصف:</strong> {{ $messageData['grade'] }}</p>
        <p><strong>المدرسة:</strong> {{ $messageData['school'] }}</p>
        <p><strong>الرسالة:</strong></p>
        <p>{{ $messageData['message'] }}</p>
    </div>
</body>
</html>
