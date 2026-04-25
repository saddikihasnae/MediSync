<!DOCTYPE html>
<html dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #eee; padding: 20px; border-radius: 10px; }
        .header { background: #3b82f6; color: white; padding: 10px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MediSync - تأكيد الموعد</h1>
        </div>
        <div class="content">
            <p>مرحباً <strong>{{ $appointment->patient->name }}</strong>،</p>
            <p>تم تسجيل موعدك الجديد بنجاح. إليك التفاصيل:</p>
            <ul>
                <li><strong>الخدمة:</strong> {{ $appointment->service->name }}</li>
                <li><strong>التاريخ والوقت:</strong> {{ $appointment->appointment_time }}</li>
                <li><strong>الطبيب:</strong> {{ $appointment->doctor->name }}</li>
            </ul>
            <p>شكراً لثقتكم بنا.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} MediSync_App. جميع الحقوق محفوظة.
        </div>
    </div>
</body>
</html>
