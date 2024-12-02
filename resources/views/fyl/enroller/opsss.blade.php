<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Participantes</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
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
        <div style="width:100%; max-width:600px">
        <div>
            <img width="100%" class=" py-2 focus" src="{{ url('images/fyl.jpeg') }}" />
        </div>
        <hr>
        <div>
            <img width="40%" class=" py-2 opss" src="{{ url('images/Error.png') }}" alt="opss" />
        </div>
        </div>
    </center>

</body>

</html>

