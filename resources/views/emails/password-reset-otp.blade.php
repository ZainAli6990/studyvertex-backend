<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StudyVertex Password Reset Code</title>
</head>

<body style="margin:0; padding:0; background:#f4f7f8; font-family:Arial, Helvetica, sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:14px; padding:35px; box-sizing:border-box;">

        <h2 style="margin:0 0 20px; color:#008b8b;">
            StudyVertex
        </h2>

        <p style="font-size:16px; color:#333;">
            Hello {{ $userName }},
        </p>

        <p style="font-size:16px; color:#333;">
            We received a request to reset your StudyVertex password. Your reset code is:
        </p>

        <div style="margin:25px 0; text-align:center;">
            <span style="display:inline-block; padding:15px 30px; background:#008b8b; color:#ffffff; font-size:30px; font-weight:bold; letter-spacing:8px; border-radius:10px;">
                {{ $otp }}
            </span>
        </div>

        <p style="font-size:14px; color:#666;">
            This OTP is valid for 10 minutes.
        </p>

        <p style="font-size:14px; color:#666;">
            If you did not request this, you can safely ignore this email. Your password will not change.
        </p>

        <p style="margin-top:30px; font-size:14px; color:#555;">
            StudyVertex Team
        </p>

    </div>

</body>
</html>