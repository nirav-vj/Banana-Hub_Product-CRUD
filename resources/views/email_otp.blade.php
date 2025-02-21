<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your OTP Code</title>
</head>

<body>
    @if(isset($otp))
        <p>Hello,</p>
        <p>Your OTP code is: <strong>{{ $otp }}</strong></p>
        <p>Please enter this OTP to verify your account.This OTP Will expire in 5 minutes.</p>
        <p>Thank you!</p>
    @else
        <p>OTP is not available.</p>
    @endif
</body>

</html>
