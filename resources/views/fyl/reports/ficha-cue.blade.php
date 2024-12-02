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
            font-size: 13px; width: 100px;
        }
        .fila {
            font-size: 12px; text-align:left; padding-left:20px; border-bottom: 0.5px solid black
        }
        .tablaFirmaf{
            width:100%; border-spacing: 15px; border-collapse: separate; margin-bottom: 15px;
        }
        .tablaFirma{
            width:100%; border-spacing: 30px; border-collapse: separate;
        }
        .filaFirma{
            border-top: 0.5px solid black; font-size: 13px;
        }
        .tablaDetalle{
            width:100%; margin-top:-5px
        }
        .datosFactura{
            text-align: center; border: 0px solid white; padding:10px;
        }
    </style>
</head>

<body style="margin:-20px -5px; font-family: 'Montserrat', sans-serif;">
    @php
       ini_set('max_execution_time', 300);
        set_time_limit(300);
    @endphp
    @if (isset($participant) && count($participant) > 0)
    @foreach ($participant as $theparticipant)
    <table style="width:100%; margin-top:-3px">
        <tr>
            <td style="width:50%;">
                
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
                    <td style="width:40%"><span style="font-weight:bold; font-size:13px; padding-top:10px; padding-bottom:10px">DATOS
                        PERSONALES</span></td>
                    <td style="text-align: center"><span style="font-size:10px;">-- {{ htmlspecialchars($theparticipant->secuencial) }} --</span></td>
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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                    <b>{{ htmlspecialchars($theparticipant->fechas) }}/{{ htmlspecialchars($theparticipant->anio) }}</b>
                                    <!--
                                    <b>{{ htmlspecialchars($theparticipant->dia) }}-{{ htmlspecialchars($theparticipant->dia) + 1 }}-
                                    {{ htmlspecialchars($theparticipant->dia) + 2 }}/{{ htmlspecialchars($theparticipant->mes) }}/
                                    {{ htmlspecialchars($theparticipant->anio) }}</b>
                                    -->
                                </td>
                                <td style="font-size: 12px; text-align:center;"><b>$ {{ htmlspecialchars($theparticipant->price) }}</b></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center">
                                    @if(Str::length(htmlspecialchars($theparticipant->team_name_e)) > 10)
                                    <b><span style="font-size: 10px">{{ htmlspecialchars($theparticipant->team_name_e) }}</span></b>
                                    @else
                                    <b><span style="font-size: 12px">{{ htmlspecialchars($theparticipant->team_name_e) }}</span></b>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="filaFirma">Fecha del entrenamiento</td>
                                <td class="filaFirma">Precio</td>
                                <td class="filaFirma">Firma del participante
                                </td>
                                <td class="filaFirma">Firma de quién invita</td>
                                <td class="filaFirma">Equipo</td>
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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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
                                <th
                                    class="fila">

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

                En la ciudad de <b>{{ htmlspecialchars($theparticipant->sede) }}</b> a los <b>{{ htmlspecialchars($theparticipant->dia) }}</b> días del
                mes de <b>{{ htmlspecialchars($theparticipant->mes) }}</b> de <b>{{ htmlspecialchars($theparticipant->anio) }}</b>
                se suscribe el presente contrato de servicios profesionales de manera libre y voluntariamente, al tenor
                de las siguientes cláusulas:
                PRIMERA: COMPARECIENTES.- Comparecen a la suscripción del presente contrato, por una parte, la empresa
                FULL POTENTIAL SAS legalmente representada por su Gerente General el señor:
                Diego Coronel López portador de la cédula de ciudadanía No 1707083810, a quien se denominará como “EL
                PRESTADOR”; y,
                por otra el/la Señor: (a-ita): <b>{{ htmlspecialchars($theparticipant->participant) }}</b> mayor de edad, y titular de la
                cédula de ciudadanía No <b>{{ htmlspecialchars($theparticipant->DNI) }}</b>,
                quién para efectos del presente contrato se denominará “EL/LA CONTRATANTE”.
                SEGUNDA: ANTECEDENTES.- EL PRESTADOR, es una empresa cuyo objeto social se centra en la prestación de
                servicios profesionales en capacitación, formación y
                perfeccionamiento del potencial humano; a través de capacitaciones, consultorías, talleres, seminarios,
                conferencias, charlas y encuentros académicos interdisciplinarios
                así como el desarrollo de talleres vivenciales y experienciales, de entrenamientos de vida y
                empresariales, de liderazgo personal y corporativo;
                EL CONTRATANTE es una persona legalmente capaz para contratar y obligarse por sus propios y personales
                derechos que declara conocer los servicios que ofrece El prestador.
                TERCERA: OBJETO.- Constituye el objeto del presente Contrato:
                1) El/la Contratante suscribe el presente contrato para el entrenamiento FOCUS YOUR LIFE el mismo que se
                desarrolla en modalidad grupal con técnicas vivenciales
                para la aplicación de distinciones ontológicas, el mismo que se encuentra dividido en tres etapas
                consecutivas:
                1era Etapa denominada FOCUS el cual es la introducción a varias distinciones que permiten ampliar el
                estado de conciencia personal;
                2da Etapa denominada YOUR que profundiza las distinciones introductorias; y la
                3ra Etapa LIFE la misma que se subdivide en tres fines de semana de acuerdo al calendario que se otorga
                al Contratante el cual desarrolla actividades complementarias
                y un cuarto fin de semana al cual se accede luego de cumplir con todos los parámetros establecidos
                mediante requerimiento informado promovido y aceptado por el contratante.
                De lo expuesto el contratante adquiere el entrenamiento FOCUS; y, sí luego de concluido dicho
                entrenamiento el contratante decide acceder a la 2da etapa y/o 3ra etapa del entrenamiento
                el presente contrato surtirá los mismos efectos para las dos precitadas etapas.
                CUARTA: PLAZO.- El entrenamiento FOCUS se desarrollará del
                <b>{{ htmlspecialchars($theparticipant->fechas) }}
                 de {{ htmlspecialchars($theparticipant->anio) }}
                </b> en el horario de ingreso de 10h00 a 22h00 aproximadamente; Si el contratante luego de concluida esta
                etapa, por decisión propia y voluntaria accede al entrenamiento YOUR y/o LIFE
                los horarios y días de desarrollo del entrenamiento serán comunicados y notificados de manera verbal,
                física o electrónica así como los honorarios para dichos entrenamientos.
                CLAUSULA QUINTA: HONORARIOS. - El precio establecido para el entrenamiento FOCUS tiene un valor de $
                <b>{{ htmlspecialchars($theparticipant->price) }}</b> Dólares Americanos cancelados de la siguiente manera:
                1.- Mediante dinero efectivo, transferencia a la cuenta de ahorros No 2212187625 del Banco Pichincha a nombre de la
                Empresa FULL POTENTIAL SAS o mediante tarjeta de crédito a la suscripción del presente contrato.
                SEXTA: RESPONSABILIDADES Y OBLIGACIONES.- EL PRESTADOR se responsabiliza y obliga a cumplir con el
                objeto del presente contrato de manera objetiva, clara y eficaz en las fechas y horarios establecidos;
                por su parte EL CONTRATANTE se responsabiliza, obliga y declara asistir en los días y horarios
                establecidos y a cumplir con las indicaciones, normas, tareas, actividades y
                reglas que serán puestas a su conocimiento durante el desarrollo del o los entrenamientos contratados
                mismas que serán notificadas y puestas en su conocimiento de manera verbal,
                física o electrónica y tendrá la misma validez que un contrato sin que se pueda alegar falta de
                aceptación del mismo.
                SEPTIMA: CONFIDENCIALIDAD Y CONTROVERSIAS.- Las partes de manera voluntaria declaran que toda la
                información que se produzca en el entrenamiento contratado son de absoluta reserva y
                confidencialidad y que por lo tanto bajo ninguna circunstancia podrán ser reveladas a terceros a menos
                que las partes así lo decidan previo consentimiento de los intervinientes
                en el presente contrato; En caso del surgimiento de controversia sobre el presente documento y/o el
                desarrollo del entrenamiento contratado serán resueltas de manera consensuada y
                mutua entre los suscriptores del presente contrato en primera instancia, caso contrario se contará con un centro
                de mediación que ponga fin a la controversia.
                OCTAVA: TERMINACIÓN DEL CONTRATO.- El presente contrato termina bajo los siguientes aspectos:
                1.- Por cumplimiento del plazo;
                2.- Por acuerdo entre las partes previa determinación de impuestos, comisiones, promociones, gastos
                administrativos y operacionales incurridos;
                3.- Por Caso fortuito o fuerza mayor debidamente justificados y comprobados.
            </p>
            <p style="font-size:14px">
                Las partes declaran haber leído el presente contrato y suscribirlo de manera libre y voluntaria
                aceptando su total contenido por estar acorde a sus intereses.
            </p>

            <table style="width:100%; border-spacing: 10px; border-collapse: separate;">
                <tr>
                    <td style="text-align:center">
                        <img src="{{ url('images/firmaDiego.jpg') }}" width="150px" alt="Mi Imagen">
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td
                        style="width: 40%; text-align:center; vertical-align:top; border-top: 0.5px solid black; font-size:14px">
                        EL PRESTADOR<br>
                        <span style="font-size:12px">FULL POTENTIAL SAS</span>
                    </td>
                    <td></td>
                    <td
                        style="width: 40%; text-align:center; vertical-align:top; border-top: 0.5px solid black; font-size:14px">
                        EL CONTRATANTE <br><span style="font-size:12px">{{ htmlspecialchars($theparticipant->participant) }}</span> <br>
                        <span style="font-size:12px">{{ htmlspecialchars($theparticipant->DNI) }}</span>
                    </td>
                </tr>
            </table>
            <div style="page-break-before: always;"></div>
        @endforeach
    @endif

</body>

</html>
