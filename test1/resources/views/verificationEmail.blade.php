<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Email</title>
    <style>
        .header {
            font-size: 32px;
            font-weight: bold;
        }
        .content {
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="header">ChatBot404</div>
    <div class="content">
        <p>Il tuo codice di verifica è:</p>
        <p style="font-size: 30px;">{{ $verificationCode }}</p>
    </div>
</body>

</html>
