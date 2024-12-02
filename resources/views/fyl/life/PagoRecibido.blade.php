<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Participantes</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> --}}

    <style>
        body {
            font-family: Arial, sans-serif;

            margin: 0;
            padding: 0;
        }

        .focus{
            background-color: #F7F7F7;
        }

        .opss{
            background-color: red;
        }

    </style>
</head>

<body>
    <center>
        <div style="max-width: 600px">
            <img width="100%" class=" py-2 focus" src="{{ url('images/fyl.jpeg') }}" />
        </div>
        <hr>
        <div style="max-width: 600px; margin-top: 40px; padding:10px">
            <b style="font-size:16px">¡Registrarte para asistir al entrenamiento fue una de las mejores decisiones de tu vida!</b>
            <br>
            <br>
            <b style="font-size:40px">Gracias Por tu Pago</b>

        </div>
        <div><br>
            Visitanos en:
            <br>
            <a href="https://instagram.com/focus.yourlife?igshid=MzRlODBiNWFlZA=="><span class="icon-instagram  text-2xl text-red-500"></span> focus.yourlife</a>
            <br>
            <a href="https://www.impetusec.com/focus-your-life"><span class="icon-sphere text-2xl text-blue-600"></span> Focus Your Life</a>
        </div>
    </center>

</body>

</html>

