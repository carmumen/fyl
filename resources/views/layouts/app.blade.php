<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Focus Your Life') }}</title>
    <link rel="icon" href="{{ asset('images/focus5.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <style>
        html {
            font-size:16px;
        }
        @media screen and (max-width: 1366px) {
            html {
                font-size:13px;
            }
        }
       
        .overlay-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            /* Fondo semi-transparente */
            display: flex;
            align-items: center;
            justify-content: center;



            background-color: transparent;
        }

        .overlay-spinner img {

            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        .element-seguimient {
            width: 300px; /* Ancho por defecto */
        }
        
        /* Para pantallas pequeñas */
        @media (max-width: 600px) {
            .element-seguimient {
                width: 150px; /* Ancho para pantallas pequeñas */
            }
        }
   
    </style>


</head>

<body class="font-sans antialiased body">

    <header class="headerPrincipal">
        @include('layouts.header', ['Managment.idAplication', session('aplicationActive')])
    </header>
    <section>
        <nav class="navegador">
            @include('layouts.navigation', ['Managment.idAplication', session('aplicationActive')])
        </nav>
        <article class="main overflow-auto " style="padding:0px">
            {{ $slot }}
        </article>
    </section>
    <footer class="footer">
        © {{ date('Y') }}<em> Focus Your Life</em>
    </footer>
    <script>
        // Mostrar el GIF de espera antes de realizar una acción


        // Ejemplo de cómo usar estas funciones antes y después de una acción
        function realizarAccionQueTomaTiempo() {
            showLoadingSpinner(); // Muestra el GIF de espera antes de la acción

            // Simula una demora de 2 segundos (reemplaza esto con tu lógica real)
            setTimeout(function() {
                // Tu lógica aquí...

                hideLoadingSpinner(); // Oculta el GIF de espera después de la acción
            }, 2000);
        }
    </script>
</body>

</html>
