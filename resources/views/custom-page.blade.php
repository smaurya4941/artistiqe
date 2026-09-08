<!DOCTYPE html>
<html>
<head>
    <title>Custom Page</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .side-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .side-buttons img {
            width: 120px;
            cursor: pointer;
            transition: 0.2s;
        }

        .side-buttons img:hover {
            transform: scale(1.05);
        }

        .logo img {
            width: 180px;
        }
    </style>

</head>
<body>

<div class="container">
 <!-- header LOGO -->
    <div class="logo">
        <img src="/public/assets/img/Artistiqe_Logo_sd.png" alt="Logo">
        <h4>Welcomes...</h4>
    </div>
    
    <!-- LEFT SIDE BUTTONS -->
    <div>
    <a href="/page4"><img src="/public/assets/img/Artistiqe_logo_white.png" alt="artisr 1"></a>
        <a href="/page5"><img src="/public/assets/img/Artistiqe_black_logo.png" alt="collectr 2"></a>
        <a href="/page6"><img src="/public/assets/img/Artistiqe_logo_white.png" alt="collecter 3"></a>

   
</div>
    

</div>

</body>
</html>
