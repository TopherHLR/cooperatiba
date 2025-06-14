<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Message Notification</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #001C00; color: #ffffff;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="background-color: #001C00; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background: linear-gradient(to bottom right, #1F1E1E, #001C00); border: 1px solid #ffffff; border-radius: 20px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.3); color: white;">
                    <tr>
                        <td style="text-align: center; padding-bottom: 20px;">
                            <h2 style="font-size: 24px; color: #ffffff; margin: 0; font-weight: bold; text-shadow: -2px 1px 0px #047705;">
                                🔔 New Message
                            </h2>
                            <hr style="border: 0; border-top: 1px solid #ffffff; margin-top: 20px;">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 16px;">Hello {{ $notification['student_name'] ?? '' }},</p>
                            <p style="font-size: 16px;">You have a new message from COOPERATIBA staff:</p>
                            <p style="font-size: 16px;">Message: <strong>"{{ $notification['message'] ?? $notification['status'] }}"</strong></p>
                            <p style="font-size: 16px;">Date: {{ $notification['updated_at'] }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 30px; text-align: center; font-size: 14px; color: #cccccc;">
                            © 2025 Cooperatiba. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>