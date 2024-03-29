<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Título del PDF</title>
    <style>
        @font-face {
            font-family: 'ShadowsIntoLight Regular';
            font-style: normal;
            font-weight: normal;
            src: url('{{ public_path("fonts/ShadowsIntoLight-Regular.ttf") }}') format('truetype');
        }
        @font-face {
            font-family: 'ShadowsIntoLight Regular';
            font-style: normal;
            font-weight: 900;
            src: url('{{ public_path("fonts/ShadowsIntoLight-Regular.ttf") }}') format('truetype');
        }
        h1 {
            font-family: 'ShadowsIntoLight Regular';
            font-weight: 900;
        }
        h2 {
            font-family: 'ShadowsIntoLight Regular';
            font-weight: normal;
        } 
    </style>
</head>
<body>
    <h1>LARAVEL FRAMEWORK</h1>
    <h2>EL FRAMEWORK DE PHP</h2>
</body>
</html>
