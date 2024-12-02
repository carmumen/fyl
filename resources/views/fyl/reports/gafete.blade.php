<!doctype html>
<html>

<!DOCTYPE html>
<html>

<head>
    <style>
        .contenedor {
            width: 340px;
            margin: 4px auto;

            /* Establece la imagen de fondo y ajusta su tamaño y posición */
            background-image: url('images/fyltrans.png');
            background-size: cover;
            /* Ajusta la imagen para cubrir todo el fondo */
            background-position: center;
            /* Coloca la imagen en el centro del fondo */
            background-attachment: fixed;
            display: inline-block;
            /* Fija la imagen para que no se desplace con el contenido */
        }


        .div1 {
            width: 320px;
            height: 60px;
            text-align: center;
            font-size: 25px;
            vertical-align: middle;
            margin: 0px 10px;
        }

        .div3 {
            width: 320px;
            height: 40px;
            text-align: center;
            font-size: 25px;
            vertical-align: middle;
            margin: 0px 5px;
        }

        .div2 {
            width: 320px;
            height: 100px;
            text-align: center;
        }
    </style>
</head>

<body style="font-family: 'Montserrat', sans-serif; margin: 30px -15px">
    @if (isset($participant) && count($participant) > 0)
        <div class="contenedor-principal" style="display: flex; flex-wrap: wrap;">
            @foreach ($participant as $theparticipant)
                <div class="contenedor" style="border: 0.5px dashed black;  margin: 10px;">
                    <div class="div1" style="padding-top: 5px; border-bottom: 1px solid black">
                        <img src="{{ asset('images/fyl.jpeg') }}" width="130px" alt="Mi Imagen">
                    </div>
                    <div class="div2">
                        @if (strlen($theparticipant->nickname) > 7)
                            <span style="font-size:30px">{{ $theparticipant->nickname }}</span><br>
                        @else
                            <span style="font-size:50px">{{ $theparticipant->nickname }}</span><br>
                        @endif
                        <span style="font-size:13px">{{ $theparticipant->surnames }}</span><br>
                        <span style="font-size:10px">-- {{ $theparticipant->secuencial }} --</span>
                    </div>
                    <div class="div3" style="padding-top: 10px; border-top: 1px solid black">
                        PARTICIPANTE
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</body>

</html>
