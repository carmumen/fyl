<div class="space-y-4">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " id="campus_id" name="campus_id" required>
            <option value="">-- Seleccione --</option>
            @foreach ($campus as $id => $name)
                <option value="{{ $id }}" @if ($id == old('campus_id', $campusId)) selected @endif>
                    {{ __($name) }}
                </option>
            @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Training in Game')</span>
        <select class="{{ Config::get('style.cajaTexto') }} " id="training_in_game" name="training_in_game" required>
            <option value="">-- Seleccione --</option>
        </select>
    </label>

    <div class="flex flex-row">

        <label class="flex flex-col">
            <span class="{{ Config::get('style.label') }}">@lang('Start Date')</span>
            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass" type="text" id="start_date"
                name="start_date" value=" {{ old('start_date', $fds->start_date) }}" />
            @error('start_date')
                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
            @enderror
        </label>

        <label class="flex flex-col mx-4">
            <span class="{{ Config::get('style.label') }}">@lang('End Date')</span>
            <input class="{{ Config::get('style.cajaTexto') }} datePickerClass w-40 " type="text" id="end_date"
                name="end_date" value=" {{ old('end_date', $fds->end_date) }}" />
            @error('end_date')
                <small class="font-bold text-red-500/80 h-3 text-xs py-0 px-2">{{ $message }}</small>
            @enderror
        </label>

    </div>


</div>
<script>
    $(document).ready(function() {
        onSelectTrainingChange();
        $('#campus_id').on('change', onSelectTrainingChange);

        var currentDate = new Date();

        $(".datePickerClass").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            minDate: currentDate,
            firstDay: 1,
            width: "80px"
        });

        $('input').val(function(_, value) {
            return $.trim(value);
        });
    });

    function onSelectTrainingChange() {
        var campus_id = $('#campus_id').val();
        if (campus_id == "") return;
        var selectedOptionValue = "{{ $fds->training_in_game }}" ? "{{ $fds->training_in_game }}" : 0;
        var action = $('#action').val();
        var url = '/campus_training/' + campus_id + '/'+ selectedOptionValue;
        var html_select = '<option value="">-- Seleccione --</option>';

        $.get(url, function(data) {
            console.log(data)
            for (var i = 0; i < data.length; ++i) {
                html_select += '<option value="' + data[i].id + '"';
                if (selectedOptionValue !== null && data[i].id == selectedOptionValue) {
                    html_select += ' selected';
                }
                html_select += '>' + data[i].name + '</option>';
            }
            console.log(html_select)
            $('#training_in_game').html(html_select);
        });

    }


    $('.validador').on('input', function() {
        this.value = this.value.replace(/[^0-9()\/]/g, '');
    });

    $('input').val(function(_, value) {
        return $.trim(value);
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
</script>
