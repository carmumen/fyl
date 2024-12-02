<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Focus Participants')
        </h2>
    </x-slot>

    <header>

        <div class="flex items-center justify-between m-4">
            <a class="{{ Config::get('style.btnReturn') }}"
                href="{{ route('FocusParticipants.index', ['training_id' => strval($trainingId)]) }}">@lang('To return')</a>

            <a href="#" title="COPIAR" class="text-sky-800 icon-copy text-2xl mx-8 tooltip"
                onclick="copyClipboard('tablaDatos')"></a>
        </div>


    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-2 py-2.5 text-xs font-bold text-center rtl:text-right uppercase">
                                    @lang('No.')
                                </th>
                                <th scope="col"
                                    class="px-2 py-2.5 text-xs font-bold text-center rtl:text-right uppercase">
                                    @lang('NOMBRE')
                                </th>
                                <th scope="col"
                                    class="px-2 py-2.5 text-xs font-bold text-center rtl:text-right uppercase">
                                    @lang('EQUIPO')
                                </th>
                                <th scope="col"
                                    class="px-2 py-2.5 text-xs font-bold text-center rtl:text-right uppercase">
                                    @lang('GAFETE')
                                </th>
                                <th scope="col"
                                    class="px-2 py-2.5 text-xs font-bold text-center rtl:text-right uppercase">
                                    @lang('NÚMERO')
                                </th>
                                <th scope="col"
                                    class="px-2 py-2.5 text-xs font-bold text-center rtl:text-right uppercase">
                                    @lang('QUIÉN TE INVITÓ')
                                </th>
                                <th scope="col"
                                    class="px-2 py-2.5 text-xs font-bold text-center rtl:text-right uppercase">
                                    @lang('NÚMERO ENROLADOR')
                                </th>
                                <th scope="col"
                                    class="px-2 py-2.5 text-xs font-bold text-center rtl:text-right uppercase">
                                    @lang('FIRMA')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($datos as $thedatos)
                                <tr class="border-b border-gray-800">
                                    <td class="px-3 py-3.5 text-sm font-bold text-center uppercase">
                                        {{ $thedatos->secuencial }}
                                    </td>
                                    <td class="px-3 text-left text-xs">
                                        {{ $thedatos->NOMBRE }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenterXs') }}">
                                        {{ $thedatos->EQUIPO }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenterXs') }}">
                                        {{ $thedatos->GAFETE }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenterXs') }}">
                                        {{ $thedatos->NUMERO }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenterXs') }}">
                                        {{ $thedatos->INVITA }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenterXs') }}">
                                        {{ __($thedatos->NUMERO_ENROLADOR) }}
                                    </td>
                                    <td class="w-64 h-16"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                        {{-- {{ $datos->links() }} --}}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>
    </div>

    <script>
        function copyClipboard(divId) {
            var elm = document.getElementById(divId);
            var range = document.createRange();
            range.selectNode(elm);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'Copiado al portapapeles' : 'Fallo al copiar al portapapeles';
                alert(msg);
            } catch (err) {
                console.error('Error al copiar al portapapeles:', err);
            }
            window.getSelection().removeAllRanges(); // Limpiar la selección después de copiar
        }

        // function copyClipboard(div) {
        //     var elm = document.getElementById(div);
        //     var range = document.createRange();
        //     range.selectNode(elm);
        //     window.getSelection().removeAllRanges();
        //     window.getSelection().addRange(range);
        //     document.execCommand("copy");
        //     alert("Copiado al portapapeles");
        //     window.getSelection().removeAllRanges(); // Limpiar la selección después de copiar
        // }


        //   function copyClipboard(div) {
        //         var elm = document.getElementById(div);
        //         if (document.body.createTextRange) {
        //             var range = document.body.createTextRange();
        //             range.moveToElementText(elm);
        //             range.select();
        //             document.execCommand("Copy");
        //             alert("Copiado al portapapeles");
        //         }
        //         else if (window.getSelection) {
        //             var selection = window.getSelection();
        //             var range = document.createRange();
        //             range.selectNodeContents(elm);
        //             selection.removeAllRanges();
        //             selection.addRange(range);
        //             document.execCommand("Copy");
        //             alert("Copiado al portapapeles");
        //         }
        //     }
    </script>

</x-app-layout>
