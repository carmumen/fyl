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
        <form class="px-8 py-4 bg-white" method="POST" action="{{ route('OldTraining.store') }}">
            @csrf
            @include('fyl/training.form-fields-old', ['team' => new App\Models\Fyl\Training()])

            <div class="flex items-center justify-between mt-4">
                <a class="{{ Config::get('style.btnReturn') }}"
                    href="{{ route('OldTraining.index') }}">@lang('To return')</a>
                <button class="{{ Config::get('style.btnSave') }}" type="submit">Enviar</button>
            </div>
        </form>
    </div>


</x-app-layout>
<script>
    $(document).ready(function() {
        $('input').val(function(_, value) {
            return $.trim(value);
        });
    });
</script>
