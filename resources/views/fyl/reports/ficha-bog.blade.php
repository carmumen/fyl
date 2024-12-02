<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Contrato</title>

    <style>
        .tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla tr td {
            width: 25%;
            border: 0.5px solid black;
            font-size: 12px;
        }

        .tablaPagos {
            width: 105%;
            margin-left: -40px;
            margin-right: 40px
        }

        .tablaPagosRowspan {
            font-size: 13px;
            width: 30%;
            background-color: black;
        }

        .tituloPago {
            background-color: black;
            display: inline-block;
            transform: scale(1, 1);
            font-weight: bold;
            font-size: 27px;
            color: white;
            padding: 10px 20px;
            background-color: black;
            display: inline-block;
            transform: scale(1, 1);
            font-weight: bold;
            font-size: 27px;
            color: white;
            padding: 10px 20px;
            background-color: black;
            display: inline-block;
            transform: scale(1, 1);
            font-weight: bold;
            font-size: 27px;
            color: white;
            padding: 10px 20px;
        }

        .metodoPago {
            font-size: 13px;
            width: 100px;
        }

        .fila {
            font-size: 12px;
            text-align: left;
            padding-left: 20px;
            border-bottom: 0.5px solid black
        }

        .tablaFirmaf {
            width: 100%;
            border-spacing: 15px;
            border-collapse: separate;
            margin-bottom: 15px;
        }

        .tablaFirma {
            width: 100%;
            border-spacing: 30px;
            border-collapse: separate;
        }

        .filaFirma {
            border-top: 0.5px solid black;
            font-size: 13px;
        }

        .tablaDetalle {
            width: 100%;
            margin-top: -5px
        }

        .datosFactura {
            text-align: center;
            border: 0px solid white;
            padding: 10px;
        }
    </style>
</head>

<body style="margin:-20px -5px; font-family: 'Montserrat', sans-serif;">
    @if (isset($participant) && count($participant) > 0)
        @foreach ($participant as $theparticipant)
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="width:50%;">
                        <img src="{{ asset('images/find.png') }}" width="50px" alt="Mi Imagen">
                    </td>
                    <td style="width:50%; text-align:right; matgin-top: -10px;  ">
                        <img src="{{ asset('images/focus.jpg') }}" width="50px" alt="Mi Imagen">
                    </td>
                </tr>
            </table>

            <table style="width:100%; margin-top:-40px">
                <tr>
                    <td style="height:60px; width:25%; vertical-align:bottom">

                        <span>Sede: <b>{{ htmlspecialchars($theparticipant->sede) }}</b></span>
                    </td>
                    <td style="text-align: center; ">
                        <span
                            style="background-color:black; display: inline-block; transform: scale(.9, 1); font-weight:bold; font-size:27px; color:white; padding:10px;">FICHA
                            DE INSCRIPCIÓN</span>
                    </td>
                    <td style="width:25%; text-align:right; vertical-align:bottom;">
                        <span>No. Focus: <b>{{ htmlspecialchars($theparticipant->number) }}</b></span>
                    </td>
                </tr>
            </table>
            <table style="width:100%">
                <tr>
                    <td style="width:40%"><span
                            style="font-weight:bold; font-size:13px; padding-top:10px; padding-bottom:10px">DATOS
                            PERSONALES</span></td>
                    <td style="text-align: center"><span style="font-size:10px;">--
                            {{ htmlspecialchars($theparticipant->secuencial) }} --</span></td>
                    <td style="width:40%; text-align:right">
                        <span style="font-size:13px;">
                            <b>{{ htmlspecialchars($theparticipant->record_mode) }}</b>
                        </span>
                    </td>
                </tr>
            </table>

            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="font-size: 13px; width: 110px">
                        Nombre Completo
                    </td>
                    <th class="fila">
                        {{ htmlspecialchars($theparticipant->participant) }}
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="font-size: 13px; width: 250px">
                        Nombre por el que prefiero que me llamen
                    </td>
                    <th class="fila">
                        {{ htmlspecialchars($theparticipant->nickname) }}
                    </th>
                    <td style="font-size: 13px; width: 20px">
                        Edad
                    </td>
                    <th
                        style="font-size: 12px; text-align:left; width:130px; padding-left:20px; border-bottom: 0.5px solid black">
                        {{ htmlspecialchars($theparticipant->edad) }}
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="font-size: 13px; width: 120px">
                        Dirección Completa
                    </td>
                    <th class="fila">
                        {{ htmlspecialchars($theparticipant->address) }}
                    </th>
                    <td style="font-size: 13px; width: 25px">
                        Ciudad
                    </td>
                    <th
                        style="font-size: 12px; width:120px; text-align:left; padding-left:20px; border-bottom: 0.5px solid black">
                        {{ htmlspecialchars($theparticipant->ciudad) }}
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="font-size: 13px; width: 110px">
                        Número de cédula
                    </td>
                    <th class="fila">
                        {{ htmlspecialchars($theparticipant->DNI) }}
                    </th>
                    <td style="font-size: 13px; width: 25px">
                        Teléfono
                    </td>
                    <th
                        style="font-size: 12px; width:110px; text-align:left; padding-left:20px; border-bottom: 0.5px solid black">
                        {{ htmlspecialchars($theparticipant->phone) }}
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="font-size: 13px; width: 40px">
                        E-mail
                    </td>
                    <th class="fila">
                        {{ htmlspecialchars($theparticipant->email) }}
                    </th>
                    <td style="font-size: 13px; width: 70px">
                        <span>Estado Civíl</span>
                    </td>
                    <th
                        style="font-size: 12px; width:85px; text-align:left; padding-left:20px; border-bottom: 0.5px solid black">
                        {{ htmlspecialchars($theparticipant->estado_civil) }}
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="font-size: 13px; width: 70px">
                        Ocupación
                    </td>
                    <th class="fila">
                        {{ htmlspecialchars($theparticipant->occupation) }}
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="font-size: 13px; width: 190px">
                        En caso de emergencia llamar a
                    </td>
                    <th class="fila">
                        {{ htmlspecialchars($theparticipant->emergency_contact) }}
                    </th>
                    <td style="font-size: 13px; width: 45px">
                        Teléfono
                    </td>
                    <th
                        style="font-size: 12px; width:110px; text-align:left; padding-left:20px; border-bottom: 0.5px solid black">
                        {{ htmlspecialchars($theparticipant->emergency_contact_phone) }}
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td style="font-size: 13px; width: 200px">
                        Quién te invitó a Focus Your Life?
                    </td>
                    <th class="fila">
                        {{ htmlspecialchars($theparticipant->enroller) }}
                    </th>
                    <td style="font-size: 13px; width: 45px">
                        Teléfono
                    </td>
                    <th
                        style="font-size: 12px; width:110px; text-align:left; padding-left:20px; border-bottom: 0.5px solid black">
                        {{ htmlspecialchars($theparticipant->phone_enroller) }}
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td colspan="6" style="font-size: 13px; ">
                        ¿Tienes algún antecedente personal de enfermedades psiquiátricas o estás bajo tratamiento
                        actualmente?
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 13px; width: 5px">
                        (SI)
                    </td>
                    <th
                        style="font-size: 12px; width:5px; text-align:left; padding:0px 5px; border-bottom: 0.5px solid black">
                        @if (htmlspecialchars($theparticipant->psychiatric_history) == 'SI')
                            X
                        @endif

                    </th>
                    <td style="font-size: 13px; width: 5px">
                        (NO)
                    </td>
                    <th
                        style="font-size: 12px; width:5px; text-align:left; padding:0px 5px; border-bottom: 0.5px solid black">
                        @if (htmlspecialchars($theparticipant->psychiatric_history) == 'NO')
                            X
                        @endif
                    </th>
                    <td style="font-size: 13px; width: 5px">
                        ¿Cuál?
                    </td>
                    <th class="fila">
                        @if (strlen(htmlspecialchars($theparticipant->psychiatric_history_details)) > 65)
                            {{ substr(htmlspecialchars($theparticipant->psychiatric_history_details), 0, 65) . '...' }}
                        @else
                            {{ htmlspecialchars($theparticipant->psychiatric_history_details) }}
                        @endif
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td colspan="6" style="font-size: 13px; ">
                        ¿Tienes algún antecedente médico del cuál debamos tener conocimiento?
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 13px; width: 5px">
                        (SI)
                    </td>
                    <th
                        style="font-size: 12px; width:5px; text-align:left; padding:0px 5px; border-bottom: 0.5px solid black">
                        @if (htmlspecialchars($theparticipant->medical_history) == 'SI')
                            X
                        @endif
                    </th>
                    <td style="font-size: 13px; width: 5px">
                        (NO)
                    </td>
                    <th
                        style="font-size: 12px; width:5px; text-align:left; padding:0px 5px; border-bottom: 0.5px solid black">
                        @if (htmlspecialchars($theparticipant->medical_history) == 'NO')
                            X
                        @endif
                    </th>
                    <td style="font-size: 13px; width: 5px">
                        ¿Cuál?
                    </td>
                    <th class="fila">
                        @if (strlen(htmlspecialchars($theparticipant->usual_medication_details)) > 65)
                            {{ substr(htmlspecialchars($theparticipant->medical_history_details), 0, 65) . '...' }}
                        @else
                            {{ htmlspecialchars($theparticipant->medical_history_details) }}
                        @endif
                    </th>
                </tr>
            </table>
            <table style="width:100%; margin-top:-3px">
                <tr>
                    <td colspan="6" style="font-size: 13px; ">
                        ¿Tomas algún medicamento que altere tu conducta habitual?
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 13px; width: 5px">
                        (SI)
                    </td>
                    <th
                        style="font-size: 12px; width:5px; text-align:left; padding:0px 5px; border-bottom: 0.5px solid black">
                        @if (htmlspecialchars($theparticipant->usual_medication) == 'SI')
                            X
                        @endif
                    </th>
                    <td style="font-size: 13px; width: 5px">
                        (NO)
                    </td>
                    <th
                        style="font-size: 12px; width:5px; text-align:left; padding:0px 5px; border-bottom: 0.5px solid black">
                        @if (htmlspecialchars($theparticipant->usual_medication) == 'NO')
                            X
                        @endif
                    </th>
                    <td style="font-size: 13px; width: 5px">
                        ¿Cuál?
                    </td>
                    <th class="fila">
                        @if (strlen(htmlspecialchars($theparticipant->usual_medication_details)) > 65)
                            {{ substr(htmlspecialchars($theparticipant->usual_medication_details), 0, 65) . '...' }}
                        @else
                            {{ htmlspecialchars($theparticipant->usual_medication_details) }}
                        @endif
                    </th>
                </tr>
            </table>
            <br>

            <table class="tablaPagos">
                <tr>
                    <td rowspan="3" class="tablaPagosRowspan">
                        <span class="tituloPago">FOCUS</span>
                    </td>
                    <td style="width:30%">
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    Método de pago:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td style="width:30%">
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    Fecha de pago:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 60px">
                                    Tarjeta:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 50px">
                                    Monto:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 60px">
                                    Plazo:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    No. Autoización:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table class="tablaFirmaf">
                            <tr>
                                <td style="font-size: 12px; text-align:center;">
                                    <b>{{ htmlspecialchars($theparticipant->dia) }}-{{ htmlspecialchars($theparticipant->dia) + 1 }}-
                                        {{ htmlspecialchars($theparticipant->dia) + 2 }}/{{ htmlspecialchars($theparticipant->mes) }}/
                                        {{ htmlspecialchars($theparticipant->anio) }}</b>
                                </td>
                                <td style="font-size: 12px; text-align:center;"><b>$
                                        {{ htmlspecialchars($theparticipant->price) }}.00</b></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center">
                                    @if (Str::length(htmlspecialchars($theparticipant->team_name_e)) > 10)
                                        <b><span
                                                style="font-size: 10px">{{ htmlspecialchars($theparticipant->team_name_e) }}</span></b>
                                    @else
                                        <b><span
                                                style="font-size: 12px">{{ htmlspecialchars($theparticipant->team_name_e) }}</span></b>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="filaFirma">Fecha del entrenamiento</td>
                                <td class="filaFirma">Precio</td>
                                <td class="filaFirma">Firma del participante
                                </td>
                                <td class="filaFirma">Firma de quién invita</td>
                                <td class="filaFirma">No. Equipo</td>
                            </tr>
                        </table>
                    </td>

                </tr>
            </table>

            <table class="tablaPagos" style="margin-top:-20px">
                <tr>
                    <td rowspan="3"class="tablaPagosRowspan">
                        <span class="tituloPago">YOUR</span>
                    </td>
                    <td style="width:30%">
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    Método de pago:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td style="width:30%">
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    Fecha de pago:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 60px">
                                    Tarjeta:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 50px">
                                    Monto:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 60px">
                                    Plazo:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    No. Autoización:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br><br>
                        <table style="width:100%; border-spacing: 30px; border-collapse: separate;">
                            <tr>
                                <td class="filaFirma">Fecha del entrenamiento</td>
                                <td class="filaFirma">Precio</td>
                                <td class="filaFirma">Firma del participante</td>
                            </tr>
                        </table>
                    </td>

                </tr>
            </table>

            <table class="tablaPagos" style="margin-top:-20px">
                <tr>
                    <td rowspan="3"class="tablaPagosRowspan">
                        <span class="tituloPago">LIFE</span>
                    </td>
                    <td style="width:30%">
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    Método de pago:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td style="width:30%">
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    Fecha de pago:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 60px">
                                    Tarjeta:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 50px">
                                    Monto:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td style="font-size: 13px; width: 60px">
                                    Plazo:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table class="tablaDetalle">
                            <tr>
                                <td class="metodoPago">
                                    No. Autoización:
                                </td>
                                <th class="fila">

                                </th>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <br><br>
                        <table style="width:100%; border-spacing: 30px; border-collapse: separate;">
                            <tr>
                                <td class="filaFirma">Fecha del entrenamiento</td>
                                <td class="filaFirma">Precio</td>
                                <td class="filaFirma">Firma del participante</td>
                            </tr>
                        </table>
                    </td>

                </tr>
            </table>

            <table class="tabla">
                <tr>
                    <td colspan="4" class="datosFactura"><b>DATOS PARA
                            LA FACTURA</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="text-align: center">FOCUS</td>
                    <td style="text-align: center">YOUR</td>
                    <td style="text-align: center">LIFE</td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>CC/RUC:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Correo Electrónico:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Teléfono:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <div style="page-break-before: always;"></div>

            <p style="text-align: center">
                <b>CONTRATO DE PRESTACIÓN DE SERVICIOS</b>
            </p>

            <p style="font-size:14px; text-align:justify">

                Comparecen la suscripción del presente contrato de prestación de servicios por una parte el señor ose
                Fabian Montoya Meneses,
                con número de cédula 1.030.591.777, en su calidad de representante legal de la compañía GRUPO FIND SAS,
                a quien y por efectos
                de este contrato se denominara PRESTADOR DE SERVICIO y por otra parte señor/ra
                <b>{{ htmlspecialchars($theparticipant->participant) }}</b>,
                con número de cédula <b>{{ htmlspecialchars($theparticipant->DNI) }}</b>, a quien para efectos de este
                contrato se denominara
                EL O LA CLIENTE, cuando se trate delos dos comparecientes se les denominara LAS PARTES ANTECEDENTES.
                <ol type="a">
                    <li>
                        <p style="font-size:14px; text-align:justify">
                GRUPO FIND SAS Es una empresa constituida en el año 2023 con domicilio en la ciudad Bogotá, tiene como
                objetivo dictar procesos
                de formación, capacitación y perfeccionamiento, dentro de lo cual podrá realizar actividades de: i)
                Capacitación, consultoría,
                talleres, seminarios, conferencias, charlas y encuentros académicos en el área interdisciplinarias; ii)
                Desarrollo de talleres
                vivenciales y experienciales, entrenamientos empresariales y de vida; así como de liderazgo personal y
                corporativo.
                        </p>
                    </li>
                <li>
                    <p style="font-size:14px; text-align:justify">
                    EL CLIENTE desea contratar los servicios ofertados por EL PRESTADOR DE SERVICIOS.
                    </p>
                    <p style="font-size:14px; text-align:justify">
                CLÁUSULA PRIMERA: OBJETO - El objeto del presente contrato es la prestación del servicio del
                entrenamiento ____________________,
                el mismo se desarrolla en modalidad grupal, con técnicas vivenciales para aplicación de distinciones
                ontológicas.
            </p>
            <p style="font-size:14px; text-align:justify">
                CLAUSULA SEGUNDA: PLAZO - El entrenamiento objeto de este contrato se desarrollará del
                <b>{{ htmlspecialchars($theparticipant->fechas) }}
                 de {{ htmlspecialchars($theparticipant->anio) }}
                </b>, en los horarios previamente fijados.
            </p>
            <p style="font-size:14px; text-align:justify">
                CLAUSULA TERCERA: HONORARIOS - El precio establecido para el entrenamiento FOCUS, es el valor de
                COL $<b>{{ htmlspecialchars($theparticipant->price) }}</b>.
            </p>
            <p style="font-size:14px; text-align:justify">
                CLAUSULA CUARTA: OBLIGACIONES DE LAS PARTES
                EL PRESTADOR DE SERVICIOS, se obliga a prestar y cumplir con el entrenamiento en las fechas y horarios
                establecidos, con calidad y calidez, en estricto apego a la ética profesional.
                EL O LA CLIENTE se obliga a trabajar dentro de los talleres para cumplir los objetivos y metas
                planteadas para sí mismo, así como realizar las tareas de cada sesión, adicionalmente se compromete
                asistir en los días y horarios fijados y respetar las reglas que previo a la suscripción del contrato
                conocerá, las mismas que serán parte anexa a este instrumento.
            </p>
            <p style="font-size:14px; text-align:justify">
                CLAUSULA QUINTA: CONFIDENCIALIDAD - Las partes declaran que la información relevada dentro del
                entrenamiento es confidencial, que no podrá ser divulgada fuera del proceso sin limitación de tiempo.
            </p>
            <p style="font-size:14px; text-align:justify">
                CLAUSULA SEXTA: TERMINACIÓN DEL CONTRATO - Este contrato podrá terminar por:
                vencimiento de plazo; acuerdo entre las partes o por fuerza mayor debidamente probada.
                En el caso de terminación anticipada EL CLIENTE, pagará el proporcional de los servicios prestados y el
                proporcional de los rublos que el PRESTADOR DE SERVICIOS haya incurrido para el cumplimiento del objeto
                contractual.
            </p>
            <p style="font-size:14px; text-align:justify">
                CLAUSULA SEPTIMA: CONTROVERSIAS – Las partes acuerdan llevar un proceso de acuerdo mutuo previo a la
                exposición motivada por escrito de las causas que provoquen la controversia, en caso de no llegar a un
                acuerdo podrán recurrir a la asesoría de la defensoría del pueblo, sin prejuicio de las acciones legales
                establecidas en el ministerio de comercio, industria y turismo de Colombia.
            </p>
                </li>
            </ol>

        <p style="font-size:14px; text-align:justify">
                Las partes aceptan todas y cada una de las estipulaciones establecidas en este contrato.
            </p>
            <p style="font-size:14px; text-align:justify">

                DECLARO QUE HE LEIDO EN SU INTEGRIDAD EL CONTRATO Y ACEPTO LAS CONDICIONES ESTABLECIDAS EN EL MISMO.

        </p>

            <table style="padding:0 5%; width:100%;  border-collapse: separate;">
                <tr>
                    <td style="text-align:center; font-weight:bold;">
                        <img src="{{ asset('images/FirmaFabian.png') }}" width="180px" alt="Mi Imagen">
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td
                        style="width: 40%; text-align:center; vertical-align:top; border-top: 0.5px solid black; font-size:14px">
                        <span style="font-size:12px">GRUPO FIND SAS</span>
                        <br>
                        <span style="font-size:12px">GERENTE GENERAL</span>
                    </td>
                    <td></td>
                    <td
                        style="width: 40%; text-align:center; vertical-align:top; border-top: 0.5px solid black; font-size:14px">
                        <span style="font-size:12px">C.C. {{ htmlspecialchars($theparticipant->DNI) }}</span>
                         <br>
                        <span style="font-size:12px">EL CLIENTE</span>

                    </td>
                </tr>
            </table>

            <div style="page-break-before: always;"></div>
        @endforeach
    @endif
</body>

</html>
