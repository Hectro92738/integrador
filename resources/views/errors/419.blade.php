<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/Mathalytics_logo.png') }}">
    <title>URL no encontrada</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div style="text-align: center; padding: 50px;">
        <img class="center-image" width="150" class="img-thumbnail"
            src="{{ asset('img/Mathalytics_logo.png') }}" alt="">
        <h1>URL - PAGE EXPIRED</h1>
        {{-- <p>No es pocible acceder a esta URL, verifica que este bien escrita o es por que no tienes los permisos para
            acceder a ella.</p> --}}
        <div style="padding-top: 1rem">
            <img class="center-image" width="250" class="img-thumbnail" src="{{ asset('img/404.png') }}"
                alt="">
            <br>
            <button class="btn btn-primary mt-5" onclick="location.href='{{ url('/') }}'">
                <i class="bi bi-arrow-bar-left me-2"></i>Regresar
            </button>
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
                document.title = '419 - ' + emojis[i];
                i = (i + 1) % emojis.length; // Incremento cíclico del índice
                setTimeout(animateEmoji,
                    2500); // Cambia el número para ajustar la velocidad de la animación (en milisegundos)
            }

            animateEmoji();
        });
    </script>
</body>

</html>
