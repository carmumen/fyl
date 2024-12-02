<div class="space-y-4">
    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Aplication')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="aplication_id" id="aplication_id"
            value=" {{ old('aplication_id', $functionality->aplication_id) }}" required />
        <option value="">-- Seleccione --</option>
        @foreach ($aplication as $id => $name)
            <option value="{{ $id }}" @if ($id == old('aplication_id', $functionality->aplication_id)) selected @endif>{{ __($name) }}
            </option>
        @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Module')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="module_id" id="module_id"
            value=" {{ old('module_id', $functionality->module_id) }}" required />
        <option value="">-- Seleccione --</option>
        @foreach ($module as $id => $name)
            <option value="{{ $id }}" @if ($id == old('module_id', $functionality->module_id)) selected @endif>{{ $name }}
            </option>
        @endforeach
        </select>
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Icon')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="icon"
            value=" {{ old('icon', $functionality->icon) }}" required />
        @error('icon')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Name')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="name"
            value=" {{ old('name', $functionality->name) }}" required />
        @error('name')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="font-serif text-slate-600">@lang('Order')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="order" id="order"
            onkeypress="javascript:return isNum(event)" maxlength = "3"
            value=" {{ old('order', $functionality->order) }}" required />
        @error('order')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Route')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="route"
            value=" {{ old('route', $functionality->route) }}" required />
        @error('route')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('State')</span>
        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="state" required />
        <option value="ACTIVE" @if ($functionality->state == 'ACTIVE') selected @endif>@lang('ACTIVE')</option>
        <option value="INACTIVE" @if ($functionality->state == 'INACTIVE') selected @endif>@lang('INACTIVE')</option>
        </select>
        @error('state')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
</div>

{{-- @dump($aplication->toArray()) --}}

<script>
    $(document).ready(function() {
        $('#aplication_id').on('change', onSelectAplicationChange);
        //$('#parent_module_id').on('change'; onSelectParentModuleChange)
    });

    function onSelectAplicationChange() {
        var aplication_id = $('#aplication_id').val();
        var url = '/modAplication/' + aplication_id;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#module_id').empty();
        $.get(url, function(data) {
            for (var i = 0; i < data.length; ++i)
                html_select += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
            $('#module_id').html(html_select);
        });
    }


    function onSelectAplicationChange1() {
        var aplication_id = $('#aplication_id').val();
        var url = '/parentModule/' + aplication_id;
        var html_select = '<option value="">-- Seleccione --</option><option value="0">ES PRINCIPAL</option>';
        $('#parent_module_id').empty();
        $.get(url, function(data) {
            for (var i = 0; i < data.length; ++i)
                html_select += '<option value="' + data[i].id + '">' + data[i].name + '</option>';


            $('#parent_module_id').html(html_select);
        });
    }

    function onSelectParentModuleChange() {
        var parent_module_id = $('#parent_module_id').val();
        var url = '/childModule/' + parent_module_id;
        var html_select = '<option value="">-- Seleccione --</option>';
        $('#module_id').empty();
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
