<!DOCTYPE html>
<html>

<head>
    <title>Your Account Credentials</title>
</head>

<body>
    <h2>Hello {{ $student->name }},</h2>
    <p>Your account has been created successfully.</p>
    <p><strong>Email:</strong> {{ $student->email }}</p>
    <p><strong>Password:</strong> {{ $plainPassword }}</p>
    <p>Please login and change your password immediately for security reasons.</p>
</body>

</html>
