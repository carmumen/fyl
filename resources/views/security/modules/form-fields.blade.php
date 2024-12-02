<div class="space-y-4">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Aplication')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="aplication_id" id="aplication_id"
            value=" {{ old('aplication_id', $module->aplication_id) }}" required />
        <option value="">-- Seleccione --</option>
        @foreach ($aplication as $id => $name)
            <option value="{{ $id }}" @if ($id == old('aplication_id', $module->aplication_id)) selected @endif>{{ __($name) }}
            </option>
        @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Parent Module')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="parent" id="parent"
            value=" {{ old('parent', $module->parent) }}" required />
        @if (count($parent_module) >= 1)
            <option value="">-- Seleccione --</option>
            <option value="0" @if ($module->parent == 0) selected @endif>ES PRINCIPAL</option>
            @foreach ($parent_module as $id => $name)
                <option value="{{ $id }}" @if ($id == old('parent', $module->parent)) selected @endif>
                    {{ __($name) }}</option>
            @endforeach
        @endif
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Module')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="name"
            value=" {{ old('name', $module->name) }}" required />
        @error('name')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="font-serif text-slate-600">@lang('Order')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="order" id="order"
            onkeypress="javascript:return isNum(event)" maxlength = "3" value=" {{ old('order', $module->order) }}"
            required />
        @error('order')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('State')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="state" required />
        <option value="ACTIVE" @if ($module->state == 'ACTIVE') selected @endif>@lang('ACTIVE')</option>
        <option value="INACTIVE" @if ($module->state == 'INACTIVE') selected @endif>@lang('INACTIVE')</option>
        </select>
        @error('state')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

</div>
<script>
    $(document).ready(function() {
        $('#aplication_id').on('change', onSelectAplicationChange);
        $('#parent').on('change', onSelectParentModuleChange)
    });

    function onSelectAplicationChange() {
        var aplication_id = $('#aplication_id').val();
        var url = '/parentModule/' + aplication_id;
        $('#parent').empty();
        var html_select = '<option value="">-- Seleccione --</option>';

        $.get(url, function(data) {
            html_select += '<option value="0">ES PRINCIPAL</option>';
            for (var i = 0; i < data.length; ++i)
                html_select += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#parent').html(html_select);
        });
    }

    function onSelectParentModuleChange() {
        var parent = $('#parent').val();
        var url = '/childModule/' + parent;
        $('#module_id').empty();
        var html_select = '<option value="">-- Seleccione --</option>';
        $.get(url, function(data) {
            for (var i = 0; i < data.length; ++i)
                html_select += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#module_id').html(html_select);
        });
    }

    function isNum(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }
</script>
