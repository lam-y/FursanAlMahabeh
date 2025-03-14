<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة جديدة</title>
</head>
<body dir="rtl" style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; text-align: right;">
    <div style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 24px; color: #000000; margin-bottom: 20px; text-align: center;">تم إرسال رسالة جديدة إلى موقع فرسان المحبة</h2>

        <div style="margin-bottom: 20px;">
            <p style="font-size: 16px; color: #333333; line-height: 1.5;">
                <strong style="color: #2196F3;">الاسم:</strong> {{ $messageData['name'] }}
            </p>
            <p style="font-size: 16px; color: #333333; line-height: 1.5;">
                <strong style="color: #2196F3;">البريد الإلكتروني:</strong> {{ $messageData['email'] }}
            </p>
            <p style="font-size: 16px; color: #333333; line-height: 1.5;">
                <strong style="color: #2196F3;">موبايل:</strong> {{ $messageData['phone'] }}
            </p>
            <p style="font-size: 16px; color: #333333; line-height: 1.5;">
                <strong style="color: #2196F3;">تاريخ الميلاد:</strong> {{ $messageData['birthdate'] }}
            </p>
            <p style="font-size: 16px; color: #333333; line-height: 1.5;">
                <strong style="color: #2196F3;">الصف:</strong> {{ $messageData['grade'] }}
            </p>
            <p style="font-size: 16px; color: #333333; line-height: 1.5;">
                <strong style="color: #2196F3;">المدرسة:</strong> {{ $messageData['school'] }}
            </p>
        </div>

        <div>
            <p style="font-size: 16px; color: #333333; line-height: 1.5;">
                <strong style="color: #2196F3;">الرسالة:</strong>
            </p>
            <p style="font-size: 16px; color: #555555; line-height: 1.8; border-top: 1px solid #ddd; padding-top: 10px;">
                {{ $messageData['message'] }}
            </p>
        </div>
    </div>
</body>
</html>
