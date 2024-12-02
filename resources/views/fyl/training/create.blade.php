<x-app-layout>

    <x-slot name="title">
        @lang('Training')
    </x-slot>

    <h1 class="px-8 py-4 text-2xl text-left text-sky-800 font-semibold">@lang('Create Training')</h1>

    @if (session()->has('info'))
        <div class="alert alert-success">
            {{ session('info') }}
        </div>
    @endif

    <div class="space-y-0  p-3 border-b-2   text-lg font-mono bg-white">
        <div class="tabs flex text-sm -mb-0.5">
            <a id="tab1"
                class="{{ Config::get('style.tag') }} bg-sky-700 text-white hover:text-white hover:bg-sky-700 rounded-t-lg mx-0 activar"
                mostrar="#uno">@lang('Training')</a>
        </div>

        <div class="views">
            <div id="uno" class=" border-2 rounded-b-lg rounded-r-lg activar">
                <form class="px-8 py-4 bg-white" method="POST" action="{{ route('Training.store') }}">
                    @csrf

                    <input type="hidden" name="tagName" value="1" />

                    <label class="flex flex-col">
                        <span class="{{ Config::get('style.label') }}">@lang('Campus')</span>
                        <select class="{{ Config::get('style.cajaTexto') }}" type="text" name="campus_id"
                            value=" {{ old('campus_id', $training->campus_id) }}" required />
                        <option value="">-- Seleccione --</option>
                        @foreach ($campus as $id => $name)
                            <option value="{{ $id }}" @if ($id == old('campus_id', $training->campus_id)) selected @endif>
                                {{ __($name) }}</option>
                        @endforeach
                        </select>
                    </label>


                    <div class="flex flex-wrap ">
                        <div class="mt-2">
                            <label class="flex flex-col w-16">
                                <span class="{{ Config::get('style.label') }}">@lang('Number')</span>
                                <input class="{{ Config::get('style.cajaTexto') }}" type="text" name="number"
                                    onkeypress="return valideKey(event);"
                                    value=" {{ old('number', $training->number) }}" required />
                                @error('number')
                                    <small class="pt-1 font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>
                    </div>


                    <div class="flex flex-wrap ">

                        <div class="mr-4 mt-2">
                            <label class="flex flex-col w-32">
                                <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
                                <select class="{{ Config::get('style.cajaTexto') }} " type="text" name="status"
                                    required />
                                <option value="ACTIVE" @if ($training->status == 'ACTIVE') selected @endif>
                                    @lang('ACTIVE')</option>
                                <option value="INACTIVE" @if ($training->status == 'INACTIVE') selected @endif>
                                    @lang('INACTIVE')</option>
                                </select>
                                @error('status')
                                    <br>
                                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                                @enderror
                            </label>
                        </div>

                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <a class="{{ Config::get('style.btnReturn') }}"
                            href="{{ route('Training.index') }}">@lang('To return')</a>
                        <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>
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
