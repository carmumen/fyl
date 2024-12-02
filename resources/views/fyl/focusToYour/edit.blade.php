<x-app-layout title="Focus To Your" meta-description="Focus To Your">

    <x-slot name="title">
        @lang('Focus To Your')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Focus To Your Follow')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <div class="px-8 py-4 bg-white" style="height:auto">

        <form method="POST" action="{{ route('FocusToYour.update', $focusParticipants) }}">
            @csrf @method('PATCH')

            <div class="space-y-4">
                <input type="hidden" id="training_id" name="training_id"
                    value=" {{ old('training_id', $focusParticipants->training_id) }}" />

                <input type="hidden" id="participant_DNI" name="participant_DNI"
                    value=" {{ old('participant_DNI', $focusParticipants->participant_DNI) }}" />

                <input type="hidden" id="program_id" name="program_id" value="2" />
                <input type="hidden" id="type_call" name="type_call" value="{{ old('type_call', $type_call) }}" />

                <div class="w-full text-center">
                    <b><span class="text-3xl">FOCUS TO YOUR</span></b>
                    </br>
                    <span class="text-2xl">{{ $focusParticipants->nickname }} {{ $focusParticipants->surnames }}</span>
                    </br>
                    <span class="text-2xl">{{ $focusParticipants->phone }}</span>
                    </br>
                    <b><span class="text-lg">{{$focusParticipants->city_of_residenceT}}</span></b>
                    </br>
                    <span><b>ENROLADOR: </b> {{ $focusParticipants->enroller }}</span>
                    </br>
                    <span>{{ $focusParticipants->enroller_phone }}</span>
                </div>
                <div class="flex flex-wrap mt-2">
                    <div class="w-32 pr-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Date Call')</span>
                            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text"
                                id="date_call" name="date_call" />
                        </label>
                    </div>
                    <div class="w-48 pr-4">
                        <label class="flex flex-col">
                            <span class="{{ Config::get('style.label') }}">@lang('Confirm Assistance')</span>
                            <select class="{{ Config::get('style.cajaTexto') }}" type="text"
                                name="confirm_assistance"
                                value=" {{ old('confirm_assistance', $focusParticipants->confirm_assistance) }}"
                                required />
                            <option value="">-- Seleccione --</option>
                            @foreach ($call->toArray() as $acronym => $name)
                                <option value="{{ $acronym }}" @if ($acronym == old('confirm_assistance', $focusParticipants->confirm_assistance)) selected @endif>
                                    {{ __($name) }}</option>
                            @endforeach
                            </select>

                        </label>
                    </div>
                </div>

                <div class="flex-1 pr-4 mt-2">
                    <label class="flex flex-col">
                        <span class="{{ Config::get('style.label') }}">@lang('Summary Call')</span>
                        <textarea class="{{ Config::get('style.cajaTexto') }}" type="text" id="summary_call" name="summary_call"></textarea>
                    </label>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <a class="{{ Config::get('style.btnReturn') }}"
                    href="{{ route('FocusToYour.index', ['training_id' => $focusParticipants->training_id]) }}">@lang('To return')</a>
                    
                <button class="{{ Config::get('style.btnSave') }}" type="submit">@lang('Save')</button>

            </div>

        </form>

        <table id="tablaDatos" class="min-w-full divide-y divide-gray-200 mt-4">
            <thead class="bg-sky-800">
                <tr>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} py-3.5 ">
                        @lang('Call')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }} py-3.5 ">
                        @lang('Date Call')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Confirm Assistance')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerLeftXs') }}">
                        @lang('Summary Call')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Call')
                    </th>
                    <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">
                        @lang('Register')
                    </th>
                </tr>
            </thead>
            <tbody class="bg-gray-100">
                @foreach ($followUp as $followUps)
                    <tr class="border-b border-gray-200">
                        <td class="{{ Config::get('style.rowCenter') }} w-40 py-2.5 ">
                            {{ $followUps->type_call }}
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }} w-40 py-3.5 ">
                            {{ $followUps->date_call }}
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }} w-48">
                            {{ $followUps->confirm_assistance }}
                        </td>
                        <td class="{{ Config::get('style.rowLeft') }}">
                            {{ $followUps->summary_call }}
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }} w-64">
                            {{ $followUps->name }}
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }} w-64">
                            {{ $followUps->created_at }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <script>
        $(document).ready(function() {
            var currentDate = new Date();
            $(".datePickerClass").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: "yy-mm-dd",
                maxDate: currentDate,
            });

            $('input').val(function(_, value) {
                return $.trim(value);
            });

        });

        document.addEventListener('DOMContentLoaded', function() {
            var paymentDateInput = document.querySelector('input[name="date_call"]');

            if (paymentDateInput.value.length < 10) {
                var currentDate = new Date();
                var year = currentDate.getFullYear();
                var month = String(currentDate.getMonth() + 1).padStart(2, '0');
                var day = String(currentDate.getDate()).padStart(2, '0');

                var formattedDate = year + '-' + month + '-' + day;

                // Asignar la fecha actual al campo de entrada
                paymentDateInput.value = formattedDate;

            }
        });
    </script>

</x-app-layout>