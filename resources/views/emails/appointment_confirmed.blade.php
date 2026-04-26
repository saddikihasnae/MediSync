<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 12px; padding: 40px; color: #1e293b;">
    <h1 style="color: #4f46e5; margin-top: 0;">Appointment Confirmed!</h1>
    <p>Hello <strong>{{ $appointment->patient->name }}</strong>,</p>
    <p>Your appointment request has been received and is currently <strong>pending review</strong>. Here are the details:</p>
    
    <div style="background-color: #f8fafc; padding: 20px; border-radius: 8px; margin: 30px 0;">
        <p style="margin: 0 0 10px 0;"><strong>Service:</strong> {{ $appointment->service->name }}</p>
        <p style="margin: 0 0 10px 0;"><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D, d M Y') }}</p>
        <p style="margin: 0;"><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('H:i') }}</p>
    </div>

    <p>We will notify you once the doctor confirms your session.</p>
    
    <hr style="border: 0; border-top: 1px solid #f1f5f9; margin: 30px 0;">
    <p style="font-size: 12px; color: #94a3b8;">This is an automated message from MediSync Clinic. Please do not reply.</p>
</div>
