<div class="space-y-0  p-3 border-b-2   text-lg font-mono bg-white">

        <div class="flex-1 md:w-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Training')</span>
                <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="training_id"
                    id="training_id"
                    value=" {{ old('training_id', $participants->training_id) }}" required />
                <option value="">-- Seleccione --</option>
                @foreach ($training as $trainings)
                    <option value="{{ $trainings->id }}" @if ($trainings->id == old('training_id', $participants->training_id)) selected @endif>
                        {{ __($trainings->name) }}</option>
                @endforeach
                </select>
                @error('training_id')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror

            </label>
        </div>

        <div class="flex flex-row flex-wrap py-1">
            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('DNI')</span>
                    <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="DNI" minlength="8"
                        maxlength="13" onkeypress="return valideKey(event);"
                        value=" {{ old('DNI', $participants->DNI) }}" required />
                    @error('DNI')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>

            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col ">
                    <span class="{{ Config::get('style.label') }}">@lang('Names')</span>
                    <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="names"
                        value=" {{ old('names', $participants->names) }}" required oninput="this.value = this.value.toUpperCase();"/>
                    @error('names')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>

            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Surnames')</span>
                    <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="surnames"
                        value=" {{ old('surnames', $participants->surnames) }}" required oninput="this.value = this.value.toUpperCase();"/>
                    @error('surnames')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>
        </div>

        <div class="flex flex-row flex-wrap py-1">

            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Pseudonym')</span>
                    <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="nickname"
                        value=" {{ old('nickname', $participants->nickname) }}" required oninput="this.value = this.value.toUpperCase();"/>
                    @error('nickname')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>

            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Birthdate')</span>
                    <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text" name="birthdate"
                        value=" {{ old('birthdate', $participants->birthdate) }}"  />
                    @error('birthdate')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>

            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Gender')</span>
                    <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="gender_catalog_id"
                        id="gender_catalog_id"
                        value=" {{ old('gender_catalog_id', $participants->gender_catalog_id) }}"  />
                    <option value="">-- Seleccione --</option>
                    @foreach ($gender as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('gender_catalog_id', $participants->gender_catalog_id)) selected @endif>
                            {{ __($name) }}</option>
                    @endforeach
                    </select>
                </label>
            </div>
        </div>

        <div class="flex flex-row flex-wrap py-1">

            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Civil Status')</span>
                    <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="civil_status_catalog_id"
                        id="civil_status_catalog_id"
                        value=" {{ old('civil_status_catalog_id', $participants->civil_status_catalog_id) }}"
                         />
                    <option value="">-- Seleccione --</option>
                    @foreach ($civil_status as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('civil_status_catalog_id', $participants->civil_status_catalog_id)) selected @endif>
                            {{ __($name) }}</option>
                    @endforeach
                    </select>
                </label>
            </div>

            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Email')</span>
                    <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="email"
                        value=" {{ old('email', $participants->email) }}" oninput="this.value = this.value.toLowerCase();"/>
                    @error('email')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>

            <div class="flex-1 md:w-1/3 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Phone')</span>
                    <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="phone"
                        value=" {{ old('phone', $participants->phone) }}" onkeypress="return valideKey(event);"
                        required />
                    @error('phone')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>
        </div>

        <div class="flex flex-row flex-wrap px-4 py-1">

            <div class="flex-grow md:w-3/4 ">
                <label class="flex flex-col ">
                    <span class="{{ Config::get('style.label') }}">@lang('City of Residence')</span>
                    <select class="{{ Config::get('style.cajaTexto') }} w-full" type="text" name="city_of_residence"
                        id="city_of_residence"
                        value=" {{ old('city_of_residence', $participants->city_of_residence) }}"  />
                    <option value="">-- Seleccione --</option>
                    @foreach ($cities->toArray() as $id => $name)
                        <option value="{{ $id }}" @if ($id == old('city_of_residence', $participants->city_of_residence)) selected @endif>
                            {{ __($name) }}</option>
                    @endforeach
                    </select>
                    @error('city_of_residence')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>
        </div>

        <div class="px-4 py-1">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Address')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="address"
                    value=" {{ old('address', $participants->address) }}"  />
                @error('address')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="px-4 py-1">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Occupation')</span>
                <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="occupation"
                    value=" {{ old('occupation', $participants->occupation) }}"  />
                @error('occupation')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="flex flex-row flex-wrap py-1">
            <div class="flex-1 md:w-1/4 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Emergency Contact')</span>
                    <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="emergency_contact"
                        value=" {{ old('emergency_contact', $participants->emergency_contact) }}"  />
                    @error('emergency_contact')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>

            <div class="flex-1 md:w-1/4 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Emergency Contact Phone')</span>
                    <input class="{{ Config::get('style.cajaTexto') }}" type="text"
                        name="emergency_contact_phone"
                        value=" {{ old('emergency_contact_phone', $participants->emergency_contact_phone) }}"
                        onkeypress="return valideKey(event);"  />
                    @error('emergency_contact_phone')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>

            <div class="flex-1 md:w-1/4 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Inviting Team')</span>
                    <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="training_id_enroller"
                        id="training_id_enroller"
                        value=" {{ old('training_id_enroller', $participants->training_id_enroller) }}"  />
                    <option value="">-- Seleccione --</option>
                    @foreach ($training_enroler as $trainingEnrollers)
                        <option value="{{ $trainingEnrollers->id }}" @if ($trainingEnrollers->id == old('training_id_enroller', $participants->training_id_enroller)) selected @endif>
                            {{ __($trainingEnrollers->team_name) }}</option>
                    @endforeach
                    </select>
                    @error('training_id_enroller')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror

                </label>
            </div>

            <div class="flex-1 md:w-1/4 px-4">
                <label class="flex flex-col">
                    <span class="{{ Config::get('style.label') }}">@lang('Enroller')</span>
                    <select class="{{ Config::get('style.cajaTexto') }} mr-4" id="DNI_enroller" name="DNI_enroller"
                    value=" {{ old('DNI_enroller', $participants->DNI_enroller) }}" >
                    </select>
                    @error('DNI_enroller')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>
        </div>

        <div class="flex flex-row flex-wrap px-4 py-1">
            <div class="flex flex-col flex-1">
                <span class="{{ Config::get('style.label') }}">@lang('Tienes algún antecedente personal de enfermedades psiquiátricas o estás bajo tratamiento actualmente?')</span>
                <div class="flex flex-row">
                    <select class="{{ Config::get('style.cajaTexto') }} w-24 mr-4" id="psychiatric_history"
                        name="psychiatric_history" onchange="togglePsychiatricDetails();" >
                        <option value="">@lang('---')</option>
                        <option value="SI" @if (old('psychiatric_history', $participants->psychiatric_history) === 'SI') selected @endif>
                            @lang('SI')
                        </option>
                        <option value="NO" @if (old('psychiatric_history', $participants->psychiatric_history) === 'NO') selected @endif>
                            @lang('NO')
                        </option>
                    </select>
                    <input class="{{ Config::get('style.cajaTexto') }} w-full " type="text"
                        id="psychiatric_history_details" name="psychiatric_history_details" placeholder="Cuál?"
                        value="{{ old('psychiatric_history_details', $participants->psychiatric_history_details) }}"
                        style="display: none;" />
                    @error('psychiatric_history_details')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </div>
                @error('psychiatric_history')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="flex flex-row flex-wrap px-4 py-1">
            <div class="flex flex-col flex-1">
                <span class="{{ Config::get('style.label') }}">@lang('Tienes algún antecedente personal de enfermedades psiquiátricas o estás bajo tratamiento actualmente?')</span>
                <div class="flex flex-row">
                    <select class="{{ Config::get('style.cajaTexto') }} w-24 mr-4" id="medical_history"
                        name="medical_history" onchange="toggleMedicalHistory();" >
                        <option value="">@lang('---')</option>
                        <option value="SI" @if (old('medical_history', $participants->medical_history) === 'SI') selected @endif>
                            @lang('SI')
                        </option>
                        <option value="NO" @if (old('medical_history', $participants->medical_history) === 'NO') selected @endif>
                            @lang('NO')
                        </option>
                    </select>
                    <input class="{{ Config::get('style.cajaTexto') }} w-full " type="text"
                        id="medical_history_details" name="medical_history_details" placeholder="Cuál?"
                        value="{{ old('medical_history_details', $participants->medical_history_details) }}"
                        style="display: none;" />
                    @error('medical_history_details')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </div>
                @error('medical_history')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="flex flex-row flex-wrap px-4 py-1">
            <div class="flex flex-col w-full">
                <span class="{{ Config::get('style.label') }}">@lang('Tienes algún antecedente personal de enfermedades psiquiátricas o estás bajo tratamiento actualmente?')</span>
                <div class="flex flex-row">
                    <select class="{{ Config::get('style.cajaTexto') }} w-24 mr-4" id="usual_medication"
                        name="usual_medication" onchange="toggleUsualMedication();" >
                        <option value="">@lang('---')</option>
                        <option value="SI" @if (old('usual_medication', $participants->usual_medication) === 'SI') selected @endif>
                            @lang('SI')
                        </option>
                        <option value="NO" @if (old('usual_medication', $participants->usual_medication) === 'NO') selected @endif>
                            @lang('NO')
                        </option>
                    </select>
                    <input class="{{ Config::get('style.cajaTexto') }} w-full " type="text"
                        id="usual_medication_details" name="usual_medication_details" placeholder="Cuál?"
                        value="{{ old('usual_medication_details', $participants->usual_medication_details) }}"
                        style="display: none;" />
                    @error('usual_medication_details')
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </div>
                @error('usual_medication')
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="px-4 py-1">
            <span class="{{ Config::get('style.label') }}">@lang('State')</span>
            <div class="flex flex-row flex-wrap py-1 justify-between">
                <label class="flex flex-col w-48">
                    <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="status" required />
                    <option value="ACTIVE" @if ($participants->status == 'ACTIVE') selected @endif>@lang('ACTIVE')
                    </option>
                    <option value="INACTIVE" @if ($participants->status == 'INACTIVE') selected @endif>@lang('INACTIVE')
                    </option>
                    </select>
                    @error('status')
                        <br>
                        <small class="font-bold text-red-500/80">{{ $message }}</small>
                    @enderror
                </label>
            </div>
        </div>
    {{-- </fieldset> --}}
    {{-- </div> --}}
</div>

<script>
    $(document).ready(function() {
        var tab = @php echo json_encode(session('tab', false)); @endphp;

        if (tab) {
            cambiaTab(tab);
        }

        $(".tabs a").on("click", function() {
            var id = $(this).attr("mostrar");

            $(this).addClass("activar").siblings().removeClass("activar");
            $(".views>div").removeClass("activar").siblings(id).addClass("activar");

        });

        $(".datePickerClass").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });

        $('input').val(function(_, value) {
            return $.trim(value);
        });

        onSelectTrainingChange();

        $('#training_id_enroller').on('change', onSelectTrainingChange);

    });



    function onSelectTrainingChange() {
        var training_id_enroller = $('#training_id_enroller').val();
        if (training_id_enroller == "") return;
        var url = '/dni_training/' + training_id_enroller;
        var html_select = '<option value="">-- Seleccione --</option>';
        //var selectedPrice = @php echo json_encode(session('price', false)); @endphp;

        var selectedOptionValue = "{{ $participants->DNI_enroller }}";

        $.get(url, function(data) {
            for (var i = 0; i < data.length; ++i) {
                html_select += '<option value="' + data[i].DNI + '"';
                if (selectedOptionValue !== null && data[i].DNI == selectedOptionValue) {
                    html_select += ' selected';
                }
                html_select += '>' + data[i].name + '</option>';
            }
            $('#DNI_enroller').html(html_select);
        });

    }

    document.addEventListener('DOMContentLoaded', function() {

        var dropdown = document.getElementById('DNI_enroller');

        dropdown.addEventListener('change', function() {
            var selectedValue = dropdown.value;

            $.ajax({
                type: 'POST',
                url: '{{ route('Participants.updateDNIFlash') }}',
                data: {
                    selectedValue: selectedValue,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Sesión actualizada');
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error al actualizar la sesión');
                }
            });
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

    // // Ejecutar al cargar la página para establecer el estado inicial
    // window.onload = togglePsychiatricDetails;
    // window.onload = toggleMedicalHistory;
    // window.onload = toggleUsualMedication;
    window.onload = function() {
        togglePsychiatricDetails();
        toggleMedicalHistory();
        toggleUsualMedication();
    };
    // //employee ocupation
</script>
