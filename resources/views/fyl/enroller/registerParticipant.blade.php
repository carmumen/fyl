<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Participantes</title>
    <link rel="icon" href="{{ asset('images/focus5.png') }}" type="image/x-icon">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        form {
            background-color: #ffffff;
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #0056b3;
        }


        /* Estilos generales para la selección */
        .select-custom {
            font-size: 16px;
            /* Tamaño de fuente normal */
        }

        /* Estilos para dispositivos móviles */
        @media (max-width: 768px) {
            .select-custom {
                font-size: 12px;
                /* Tamaño de fuente más pequeño para dispositivos móviles */
            }
        }
    </style>
</head>

<body>
    <form action="{{ route('Process.form') }}" method="POST">
        @csrf
        <input type="hidden" id="training_id_enroller" name="training_id_enroller" value=" {{ $training_id_enroller }}" required>
        <input type="hidden" id="training_id" name="training_id" value=" {{ $training_id }}" required>
        <input type="hidden" id="DNI_enroller" name="DNI_enroller" value=" {{ $DNI_enroller }}" required>
        <input type="hidden" id="price" name="price" value=" {{ $price }}" required>
        <input type="hidden" id="campus_id" name="campus_id" value=" {{ $campus_id }}" required>
        
        
        <div class="max-w-7xl mx-auto p-6 lg:p-8 mb-2">
            <div class="flex justify-center ">
                <img width="100%" class=" py-2" src="{{ url('images/fyl.jpeg') }}" />

            </div>
        </div>
        <center><h2>DATOS PARTICIPANTE</h2></center>
        
        <center><h3 style='color:red'>{{$fechaH}}</h3></center>
            
        <label for="tipo_identidad" style="margin-left: 5px; width:140px">Tipo Identidad:</label>
        <select class="{{ Config::get('style.cajaTexto') }} w-24 mr-4" id="tipo_identidad" name="tipo_identidad" required>
            <option value="">-- Seleccione --</option>
            <option value="CEDULA" @if (old('tipo_identidad') === 'CEDULA') selected @endif>
                @lang('CEDULA')
            </option>
            <option value="PASAPORTE" @if (old('tipo_identidad') === 'PASAPORTE') selected @endif>
                @lang('PASAPORTE')
            </option>
        </select>
        
        <label for="DNI">Número de Identidad:</label>
        <input type="text" id="DNI" name="DNI" minlength="8" maxlength="13" placeholder="Cédula o pasaporte..."
            onkeypress="return valideKey(event);" value=" {{ old('DNI') }}" required />
        @error('DNI')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="names">Nombres:</label>
        <input type="text" id="names" name="names" value=" {{ old('names') }}" required
            oninput="this.value = this.value.toUpperCase();" />
        @error('names')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="surnames">Apellidos:</label>
        <input type="text" id="surnames" name="surnames" value=" {{ old('surnames') }}" required
            oninput="this.value = this.value.toUpperCase();" />
        @error('surnames')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="nickname">Nombre por el que prefiero que me llamen:</label>
        <input type="text" id="nickname" name="nickname" value=" {{ old('nickname') }}" required
            oninput="this.value = this.value.toUpperCase();" />
        @error('nickname')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="birthdate">Fecha de Nacimiento:</label>
        {{-- <div class="flex flex-row flex-wrap py-1"> --}}

        <select name="birth_year" id="birth_year" style="width: 30%" onchange="updateDays()" required>
            <option value="">----</option>
            @php
                $year = date('Y')-18;
                $yearI = date('Y') -110;
            @endphp
            @for ($year; $year >= $yearI; $year--)
                <option value="{{ $year }}" {{ $year == old('birth_year') ? 'selected' : '' }}>
                    {{ $year }}</option>
            @endfor
        </select>
        @error('birth_year')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <select name="birth_month" id="birth_month" style="width: 25%" onchange="updateDays()" required>
            <option value="">--</option>
            <option value="1" {{ '1' == old('birth_month') ? 'selected' : '' }}>Enero</option>
            <option value="2" {{ '2' == old('birth_month') ? 'selected' : '' }}>Febrero</option>
            <option value="3" {{ '3' == old('birth_month') ? 'selected' : '' }}>Marzo</option>
            <option value="4" {{ '4' == old('birth_month') ? 'selected' : '' }}>Abril</option>
            <option value="5" {{ '5' == old('birth_month') ? 'selected' : '' }}>Mayo</option>
            <option value="6" {{ '6' == old('birth_month') ? 'selected' : '' }}>Junio</option>
            <option value="7" {{ '7' == old('birth_month') ? 'selected' : '' }}>Julio</option>
            <option value="8" {{ '8' == old('birth_month') ? 'selected' : '' }}>Agosto</option>
            <option value="9" {{ '9' == old('birth_month') ? 'selected' : '' }}>Septiembre</option>
            <option value="10" {{ '10' == old('birth_month') ? 'selected' : '' }}>Octubre</option>
            <option value="11" {{ '11' == old('birth_month') ? 'selected' : '' }}>Noviembre</option>
            <option value="12" {{ '12' == old('birth_month') ? 'selected' : '' }}>Diciembre</option>
        </select>
        @error('birth_month')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror
        <select name="birth_day" id="birth_day" style="width: 20%" required>
        </select>

        <label for="gender_catalog_id">Género:</label>
        <select id="gender_catalog_id" name="gender_catalog_id" required>
            <option value="">-- Seleccione --</option>
            @foreach ($gender as $id => $name)
                <option value="{{ $id }}" @if ($id == old('gender_catalog_id')) selected @endif>
                    {{ __($name) }}</option>
            @endforeach
        </select>
        @error('gender_catalog_id')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="civil_status_catalog_id">Estado Civil:</label>
        <select id="civil_status_catalog_id" name="civil_status_catalog_id" required>
            <option value="">-- Seleccione --</option>
            @foreach ($civil_status as $id => $name)
                <option value="{{ $id }}" @if ($id == old('civil_status_catalog_id')) selected @endif>
                    {{ __($name) }}</option>
            @endforeach
        </select>
        @error('civil_status_catalog_id')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror


        <label for="city_of_residence">Ciudad de Residencia:</label>
        <input type="text" id="city_of_residence" name="city_of_residence" value=" {{ old('city_of_residence') }}" required
            oninput="this.value = this.value.toUpperCase();" />
        @error('city_of_residence')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="address">Dirección Domiciliaria:</label>
        <input type="text" id="address" name="address" value=" {{ old('address') }}" required
            oninput="this.value = this.value.toUpperCase();" />
        @error('address')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="email">Correo Electrónico:</label>
        <input type="text" id="email" name="email" value=" {{ old('email') }}" required
            oninput="this.value = this.value.toLowerCase();" />
        @error('email')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="phone">Teléfono 1:</label>
        <input type="text" id="phone" name="phone" value=" {{ old('phone') }}"
            onkeypress="return valideKey(event);" required />
        @error('phone')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="phone2">Teléfono 2:</label>
        <input type="text" id="phone2" name="phone2" 
            placeholder="Opcional..."
            value=" {{ old('phone2') }}"
            onkeypress="return valideKey(event);"  />
        @error('phone2')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="occupation">Ocupación:</label>
        <input type="text" id="occupation" name="occupation" value=" {{ old('occupation') }}" required
            oninput="this.value = this.value.toUpperCase();" />
        @error('occupation')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="emergency_contact">Nombre de Contacto de Emergencia:</label>
        <input type="text" id="emergency_contact" name="emergency_contact"
            value=" {{ old('emergency_contact') }}" required oninput="this.value = this.value.toUpperCase();" />
        @error('emergency_contact')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="emergency_contact_phone">Teléfono de Contacto de Emergencia:</label>
        <input type="text" id="emergency_contact_phone" name="emergency_contact_phone"
            value=" {{ old('emergency_contact_phone') }}" onkeypress="return valideKey(event);" required />
        @error('emergency_contact_phone')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="psychiatric_history">Tienes algún antecedente personal de enfermedades psiquiátricas o estás bajo
            tratamiento actualmente?</label>
        <select id="psychiatric_history" name="psychiatric_history" onchange="togglePsychiatricDetails();" required>
            <option value="">@lang('---')</option>
            <option value="SI" @if (old('psychiatric_history') === 'SI') selected @endif>
                @lang('SI')
            </option>
            <option value="NO" @if (old('psychiatric_history') === 'NO') selected @endif>
                @lang('NO')
            </option>
        </select>
        <input type="text" id="psychiatric_history_details" name="psychiatric_history_details"
            placeholder="Cuál?" value="{{ old('psychiatric_history_details') }}" style="display: none;" />
        @error('psychiatric_history_details')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="medical_history">Tienes algún antecedente médico del cuál debamos tener conocimiento?:</label>
        <select id="medical_history" name="medical_history" onchange="toggleMedicalHistory();" required>
            <option value="">@lang('---')</option>
            <option value="SI" @if (old('medical_history') === 'SI') selected @endif>
                @lang('SI')
            </option>
            <option value="NO" @if (old('medical_history') === 'NO') selected @endif>
                @lang('NO')
            </option>
        </select>
        <input class="{{ Config::get('style.cajaTexto') }} w-full " type="text" id="medical_history_details"
            name="medical_history_details" placeholder="Cuál?" value="{{ old('medical_history_details') }}"
            style="display: none;" />
        @error('medical_history_details')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror


        <label for="usual_medication">Tomas algún medicamento que altere tu conducta habitual?:</label>
        <select class="{{ Config::get('style.cajaTexto') }} w-24 mr-4" id="usual_medication" name="usual_medication"
            onchange="toggleUsualMedication();" required>
            <option value="">@lang('---')</option>
            <option value="SI" @if (old('usual_medication') === 'SI') selected @endif>
                @lang('SI')
            </option>
            <option value="NO" @if (old('usual_medication') === 'NO') selected @endif>
                @lang('NO')
            </option>
        </select>
        <input type="text" id="usual_medication_details" name="usual_medication_details" placeholder="Cuál?"
            value="{{ old('usual_medication_details') }}" style="display: none;" />
        @error('usual_medication_details')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror
        
        
        <br />
        
        <div style="display: flex; align-items: start;">
            <input type="checkbox" id="aceptollamadas" name="aceptollamadas" style="width:40px;"  
            @if (old('aceptollamadas') === 'on') checked @endif required >
            <label for="aceptollamadas" style="margin-left: 5px; color:red; text-align:justify">
                Conforme a los datos proporcionados acepto recibir llamadas para mi entrenamiento
            </label>
        </div>
            @error('aceptollamadas')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
            @enderror
        
        <center><h2>DATOS FACTURA</h2></center>
        
        <div style="display: flex; align-items: start;">
            <input type="checkbox" id="mismosDatos" name="mismosDatos" style="width:40px;"  
            @if (old('mismosDatos') === 'on') checked @endif
            onclick="llamarTransferirDatos()" >
            <label for="mismosDatos" style="margin-left: 5px; width:140px">Mismos datos</label>
            <br>
        </div>
            
        
        <label for="fac_tipo_identidad">Tipo Identidad:</label>
        <select class="{{ Config::get('style.cajaTexto') }} w-24 mr-4" id="fac_tipo_identidad" name="fac_tipo_identidad" required>
            <option value="">-- Seleccione --</option>
            <option value="CEDULA" @if (old('fac_tipo_identidad') === 'CEDULA') selected @endif >
                @lang('CÉDULA')
            </option>
            <option value="PASAPORTE" @if (old('fac_tipo_identidad') === 'PASAPORTE') selected @endif >
                @lang('PASAPORTE')
            </option>
            <option value="RUC" @if (old('fac_tipo_identidad') === 'RUC') selected @endif>
                @lang('R.U.C.')
            </option>
        </select>
        
        <label for="fac_DNI">Número de Cédula:</label>
        <input type="text" id="fac_DNI" name="fac_DNI" minlength="8" maxlength="13"
            onkeypress="return valideKey(event);" value=" {{ old('fac_DNI') }}" required />
        @error('fac_DNI')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="fac_razon_social">Razón Social:</label>
        <input type="text" id="fac_razon_social" name="fac_razon_social" value=" {{ old('fac_razon_social') }}" required
            oninput="this.value = this.value.toUpperCase();" />
        @error('fac_razon_social')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="fac_email">Correo Electrónico:</label>
        <input type="text" id="fac_email" name="fac_email" value=" {{ old('fac_email') }}" required
            oninput="this.value = this.value.toLowerCase();" />
        @error('fac_email')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="fac_direccion">Dirección:</label>
        <input type="text" id="fac_direccion" name="fac_direccion" value=" {{ old('fac_direccion') }}" required
            oninput="this.value = this.value.toUpperCase();" />
        @error('fac_direccion')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror

        <label for="fac_telefono">Teléfono:</label>
        <input type="text" id="fac_telefono" name="fac_telefono" value=" {{ old('fac_telefono') }}" required
            onkeypress="return valideKey(event);"  />
        @error('fac_telefono')
            <small style="color:red; font-weight:bold">{{ $message }}</small>
        @enderror
        
        
        <button class="mb-2" type="submit">Registrar</button>

        <hr />
        <div class="text-center">
            <img width="100%" class=" py-2" src="{{ url('images/impetus1.jpeg') }}" />
        </div>
        <hr />
        </div>
    </form>

</body>

</html>

<script>
        function validarFormulario(event) {
            const errores = [];
            
            // Buscar todos los elementos <small> que contienen mensajes de error
            const mensajesErrores = document.querySelectorAll('small.error');

            // Imprimir en consola para depuración
            console.log('Mensajes de error:', Array.from(mensajesErrores).map(m => m.textContent.trim()));

            // Revisar cada mensaje de error y agregarlo al array si no está vacío
            mensajesErrores.forEach((mensaje) => {
                if (mensaje.textContent.trim()) {
                    errores.push(mensaje.textContent.trim());
                }
            });

            // Si hay errores, mostrar una alerta y evitar el envío del formulario
            if (errores.length > 0) {
                alert('Errores:\n' + errores.join('\n'));
                event.preventDefault(); // Evita el envío del formulario
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', validarFormulario);
            } else {
                console.error('No se encontró el formulario.');
            }
        });
    </script>

<script>


    function llamarTransferirDatos() {
        // Verificar si el checkbox está marcado
        var checkbox = document.getElementById("mismosDatos");
        if (checkbox.checked) {
            transferirDatos();
        }
        else
        {
            limpiarDatosFactura();
        }
    }
    
    function transferirDatos() {
        // Obtener valores de los campos de entrada
        var DNI = document.getElementById("DNI").value;
        var names = document.getElementById("names").value;
        var surnames = document.getElementById("surnames").value;
        var email = document.getElementById("email").value;
        var address = document.getElementById("address").value;
        var phone = document.getElementById("phone").value;
    
        // Asignar valores a los campos de destino
        document.getElementById('fac_tipo_identidad').value = document.getElementById('tipo_identidad').value;
        document.getElementById("fac_DNI").value = DNI;
        document.getElementById("fac_razon_social").value = names + ' ' + surnames;
        document.getElementById("fac_email").value = email;
        document.getElementById("fac_direccion").value = address;
        document.getElementById("fac_telefono").value = phone;
    }
    
    document.querySelectorAll('#tipo_identidad, #DNI, #names, #surnames, #email, #address, #phone').forEach(function(field) {
        field.addEventListener('input', llamarTransferirDatos);
    });
    
    function limpiarDatosFactura() {
    
        // Asignar valores a los campos de destino
        document.getElementById("fac_DNI").value = "";
        document.getElementById("fac_razon_social").value = "";
        document.getElementById("fac_email").value = "";
        document.getElementById("fac_direccion").value = "";
        document.getElementById("fac_telefono").value = "";
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var birthYearSelect = document.getElementById('birth_year');
        var birthMonthSelect = document.getElementById('birth_month');
        var birthDaySelect = document.getElementById('birth_day');

        // Función para obtener el máximo número de días en un mes específico y año específico
        function getMaxDays(year, month) {
            return new Date(year, month, 0).getDate();
        }

        // Función para actualizar los días disponibles en el select
        function updateDays() {
            var year = parseInt(birthYearSelect.value);
            var month = parseInt(birthMonthSelect.value);
            var maxDays = getMaxDays(year, month);

            if (!isNaN(year) && !isNaN(month)) {
                birthDaySelect.innerHTML = '';

                for (var day = 1; day <= maxDays; day++) {
                    var option = document.createElement('option');
                    option.value = day;
                    option.textContent = day;
                    birthDaySelect.appendChild(option);
                }
            }
        }

        // Función para actualizar los meses disponibles
        function updateMonths() {
            var year = parseInt(birthYearSelect.value);
            var currentYear = new Date().getFullYear();
            var currentMonth = new Date().getMonth() + 1; // 1-based month

            if (!isNaN(year)) {
                var maxMonth = (year === currentYear - 18) ? currentMonth : 12;

                birthMonthSelect.innerHTML = '<option value="">--</option>';
                for (var month = 1; month <= maxMonth; month++) {
                    var option = document.createElement('option');
                    option.value = month;
                    option.textContent = getMonthName(month);
                    birthMonthSelect.appendChild(option);
                }

                // Recalcular los días al cambiar los meses
                updateDays();
            }
        }

        // Función para obtener el nombre del mes
        function getMonthName(month) {
            var months = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            return months[month - 1];
        }

        // Validar que la fecha no sea menor a 18 años
        function validateDate() {
            var year = parseInt(birthYearSelect.value);
            var month = parseInt(birthMonthSelect.value);
            var day = parseInt(birthDaySelect.value);
            var currentYear = new Date().getFullYear();
            var currentMonth = new Date().getMonth() + 1;
            var currentDay = new Date().getDate();

            if (!isNaN(year) && !isNaN(month) && !isNaN(day)) {
                var age = currentYear - year;

                if (currentMonth < month || (currentMonth === month && currentDay < day)) {
                    age--;
                }

                // Si la edad es menor de 18 años, muestra un mensaje o realiza alguna acción
                if (age < 18) {
                    alert('La fecha de nacimiento debe ser mayor de 18 años.');
                    // Opcional: Limpia o deshabilita los campos para evitar datos incorrectos
                    //birthYearSelect.value = '';
                    //birthMonthSelect.value = '';
                    birthDaySelect.innerHTML = '';
                    updateDays();
                }
            }
        }

        // Agrega eventos a los selects
        birthYearSelect.addEventListener('change', function() {
            updateMonths();
            validateDate();
        });

        birthMonthSelect.addEventListener('change', updateDays);

        birthDaySelect.addEventListener('change', validateDate);

        // Inicializar el formulario
        updateMonths();
    });
</script>


<script>
    $(document).ready(function() {

        $('input').val(function(_, value) {
            return $.trim(value);
        });
    });

    $('.decimales').on('input', function() {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });

    function valideKey(evt) {
        var code = (evt.which) ? evt.which : evt.keyCode;

        if (code == 8) { // backspace.
            return true;
        } else if (code >= 48 && code <= 57) { // is a number.
            return true;
        } else { // other keys.
            return false;
        }
    }

    function togglePsychiatricDetails() {
        //console.log('psychiatricDetails');
        var psychiatricHistory = document.getElementById('psychiatric_history');
        var psychiatricDetails = document.getElementById('psychiatric_history_details');

        if (psychiatricHistory.value === 'SI') {
            psychiatricDetails.style.display = 'block';
            psychiatricDetails.setAttribute('required', 'required');
        } else {
            psychiatricDetails.value = "";
            psychiatricDetails.style.display = 'none';
            psychiatricDetails.removeAttribute('required');
        }
    }

    function toggleMedicalHistory() {
        var medicalHistory = document.getElementById('medical_history');
        var medicalDetails = document.getElementById('medical_history_details');

        //console.log(medicalHistory);
        if (medicalHistory.value === 'SI') {
            medicalDetails.style.display = 'block';
            medicalDetails.setAttribute('required', 'required');
        } else {
            medicalDetails.value = "";
            medicalDetails.style.display = 'none';
            medicalDetails.removeAttribute('required');
        }
    }

    function toggleUsualMedication() {
        //console.log('usualMedication');
        var usualMedication = document.getElementById('usual_medication');
        var usualMedicationDetails = document.getElementById('usual_medication_details');

        if (usualMedication.value === 'SI') {
            usualMedicationDetails.style.display = 'block';
            usualMedicationDetails.setAttribute('required', 'required');
        } else {
            usualMedicationDetails.value = "";
            usualMedicationDetails.style.display = 'none';
            usualMedicationDetails.removeAttribute('required');
        }
    }

    window.onload = function() {
        togglePsychiatricDetails();
        toggleMedicalHistory();
        toggleUsualMedication();
    };
    
    /*

    var birthYearSelect = document.getElementById('birth_year');
    var birthMonthSelect = document.getElementById('birth_month');
    var birthDaySelect = document.getElementById('birth_day');



    function updateDays() {
        var year = parseInt(birthYearSelect.value);
        var month = parseInt(birthMonthSelect.value);
        var maxDays = getMaxDays(year, month);

        //console.log(year, month, maxDays);
        if (year != "NaN" & month != "NaN") {
            birthDaySelect.innerHTML = '';

            for (var day = 1; day <= maxDays; day++) {
                var option = document.createElement('option');
                option.value = day;
                option.textContent = day;
                birthDaySelect.appendChild(option);
            }
        }
    }

    function getMaxDays(year, month) {
        if (month === 2) {
            return isLeapYear(year) ? 29 : 28;
        } else if ([4, 6, 9, 11].includes(month)) {
            return 30;
        } else {
            return 31;
        }
    }

    function isLeapYear(year) {
        return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
    }
    */
    // //employee ocupation
</script>
