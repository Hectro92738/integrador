<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/ico.png') }}">
    <title>URL no encontrada</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/librerias/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/librerias/bootstrap-css/css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap"
        rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap');
    </style>
</head>

<body>
    <div style="text-align: center; padding: 50px;">
        <img class="center-image" width="150" class="img-thumbnail" src="{{ asset('img/ico.png') }}"
            alt="">
        <h1>URL - NO ENCONTRADA</h1>
        <p>No es pocible acceder a esta URL, verifica que este bien escrita o es por que no tienes los permisos para
            acceder a ella.</p>
        <div style="padding-top: 1rem">
            <img class="center-image" width="250" class="img-thumbnail" src="{{ asset('images/404.png') }}"
                alt="">
            <br>
        </div>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
        document.addEventListener('DOMContentLoaded', function() {
            let emojis = ['☠️', '😶', '😥', '😰']; // Lista de emojis
            let i = 0;

            function animateEmoji() {
                document.title = '404 - ' + emojis[i];
                i = (i + 1) % emojis.length; 
                setTimeout(animateEmoji,
                    2500); 
            }

            animateEmoji();
        });
    </script>
</body>

</html>
