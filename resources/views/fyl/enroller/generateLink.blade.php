<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LACTsys') }}</title>
    <link rel="icon" href="{{ asset('imgages/tu_icono.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .border {
            border: 1px solid #E5E7EB;
        }

        .dark-border {
            border: 1px solid #4B5563;
        }

        .body {
            background-color: #F7F7F7;
        }

        .w-64 {
            width: 16rem;
        }

        .img {
            width: 100%;
            padding: 0.5rem 0;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .text-base {
            line-height: 1.5;
        }

        .lg\:text-xl {
            font-size: 1.125rem;
        }

        .space-y-4>*+* {
            margin-top: 1rem;
        }

        .text {
            margin-left: 2rem;
            list-style-type: square;
        }

        .cajaTexto {
            width: 100%;
            padding: 0.5rem;
            font-size: 1rem;
        }

        .btnSave {
            padding: 0.5rem 1rem;
            background-color: #0469A0;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 0.25rem;
        }

        .fontText {
            font-size: 1vw;
        }

        @media (min-width: 1181px) {
            .fontText {
                font-size: 0.8vw;
            }
        }

        @media (max-width: 1180px) {
            .fontText {
                font-size: 1.5vw;
            }
        }


        @media (max-width: 800px) {
            .fontText {
                font-size: 2.5vw;
            }
        }

        .custom-input {
            border-radius: 0.25rem;
            /* 6px */
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.05);
            border: 0.2px solid #CBD5E0;
            font-size: 0.6rem;
            /* 10px */
            /*color: #718096;*/
            border-color: #CBD5E0;
            outline: 1px solid transparent;
            outline-offset: 1px;
            outline-color: #CBD5E0;
            outline-offset: 0;
            outline-style: auto;
            outline-width: 2px;
            outline-color: rgba(203, 213, 224, 0.5);
            border-color: #1A202C;
            outline-color: #2D3748;
            border-color: #4A5568;

            padding-left: 0.5rem;
            /* 8px */
            padding-right: 0.5rem;
            /* 8px */
            padding-top: 0.5rem;
            /* 4px */
            padding-bottom: 0.5rem;
            /* 4px */
        }
    </style>
</head>

<body class="body">

    <div class="container">
        <div class="flex flex-col mt-6 mb-8">
            <div class="container mx-auto">
                <main class="border border-gray-200 dark-border-gray-700 mt-6 mb-8 px-2 py-2" style="max-width: 600px">
                    <div class="w-64">
                        <img class="img" src="{{ url('images/fyl.jpeg') }}" alt="Logo" />
                    </div>
                    @if (isset($participant) && count($participant) > 0)
                        <div class="space-y-4 mt-6 mb-8 px-8">
                            <label><b class="text-2xl">Hola Legendari@</b></label>
                            <p class="text-base fontText" >
                                Este espacio te permite generar y copiar un enlace para que tú o tu enrolado
                                ingresen los datos de la ficha personal.
                            </p>
                            <ul class="fontText">
                                <li>Selecciona tu nombre y da clic en Generar enlace.</li>
                                <li>Haz click en el botón copiar enlace</li>
                                <li>Pega tu enlace en un navegador o envíalo a tu enrolado para que ingrese los
                                    datos de la ficha personal.</li>
                                <li>El enlace generado te sirve para todos los enrolamientos del fin de semana.</li>
                            </ul>

                            <form id="generate" method="POST" class="flex items-center space-x-2"
                                action="{{ route('Register.register') }}">
                                @csrf
                                <input type="hidden" name="opc" value="{{ $opc }}" />
                                <select class="custom-input" style="width: 100%; max-width:400px" type="text" name="participant" id="participant"

                                value="{{ old('participant')}}" required>
                                    @foreach ($participant as $id => $name)
                                    <option value="{{ $id }}" @if(isset($par) && old('participant', $par) == $id) selected @endif>
                                        {{ __($name) }}
                                    </option>

        @endforeach
                                </select>
                                <button class="btnSave" style="margin-top: 2px" form="generate" type="submit">Generar Enlace</button>
                            </form>
                            @if (isset($link))
                                <p>
                                    <b class="fontText">Tu enlace ha sido creado de manera exitosa.</b>
                                </p>
                                <p class="fontText">
                                    Al hacer click en el botón a continuación se copiará en memoria un enlace a una
                                    página de registro. Haz click y pásalo a tu enrolado para que ingrese sus datos de
                                    la ficha personal al sistema.
                                    <br />
                                <button id="copyButton" class="btnSave" style="margin-top: 2px" onclick="copiaLink('{{ $link }}');">
                                    Copiar Enlace
                                </button>
                                </p>
                            @endif
                        </div>
                    @else
                        <p>
                            Este espacio es sólo para enroladores.
                        </p>
                    @endif
                </main>
            </div>
        </div>
    </div>

    <script>
        function copiaLink(link) {
            var textToCopy = link;
            var dummyInput = document.createElement("input");
            document.body.appendChild(dummyInput);
            dummyInput.setAttribute("value", textToCopy);
            dummyInput.select();
            document.execCommand("copy");
            setTimeout(function() {
                document.body.removeChild(dummyInput);
                alert('Enlace copiado al portapapeles');
            }, 100);
        }
    </script>
</body>

</html>



