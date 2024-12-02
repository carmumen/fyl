<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('Training')
        </h2>
    </x-slot>

    <header>
        @include('partials/header', ['entidad' => 'Training'])
    </header>

    <div class="{{ Config::get('style.containerIndex') }}">
        <div class="flex flex-col mt-6 mb-8">
            <main class="border border-gray-200 md:rounded-lg">
                <div id="conResultados">
                    <table id="tablaDatos" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-sky-800">
                            <tr>
                                <th scope="col" rowspan="2" class="{{ Config::get('style.headerCenter') }}  w-12">
                                    @lang('Id')
                                </th>
                                <th scope="col" rowspan="2" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Campus')
                                </th>
                                <th scope="col" rowspan="2" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Number')
                                </th>
                                <th scope="col" colspan="2" class="{{ Config::get('style.headerCenter') }}" style="border-left: 0.5px solid #ffffff;border-right: 0.5px solid #ffffff; padding: 2px 0px; padding-left:0px; padding-right:0px">
                                    @lang('Focus')
                                </th>
                                <th scope="col" colspan="2" class="{{ Config::get('style.headerCenter') }}" style="padding: 2px 0px; padding-left:0px; padding-right:0px">
                                    @lang('Your')
                                </th>
                                <th scope="col" colspan="2" class="{{ Config::get('style.headerCenter') }}" style="border-left: 0.5px solid #ffffff;border-right: 0.5px solid #ffffff; padding: 2px 0px; padding-left:0px; padding-right:0px">
                                    @lang('Life')
                                </th>
                                <th scope="col" rowspan="2" class="{{ Config::get('style.headerCenter') }}">
                                    @lang('Status')
                                </th>
                                @auth
                                    <th scope="col" rowspan="2" class="w-24 relative py-3.5 px-4"></th>
                                @endauth
                            </tr>
                            <tr>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="border-left: 0.5px solid #ffffff; padding-right:0px;">
                                    @lang('Start')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="border-right: 0.5px solid #ffffff; padding-left:2px">
                                    @lang('End')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="padding-right:0px">
                                    @lang('Start')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="padding-left:2px">
                                    @lang('End')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="border-left: 0.5px solid #ffffff; padding-right:0px">
                                    @lang('Start')
                                </th>
                                <th scope="col" class="{{ Config::get('style.headerCenter') }}" style="border-right: 0.5px solid #ffffff; padding-left:2px">
                                    @lang('End')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-100">
                            @foreach ($training as $trainings)
                                <tr class="border-b border-gray-200">
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $trainings->id }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ $trainings->campus }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        <b>{{ 'FYL ' . $trainings->number }}</b> <br>
                                        {{ $trainings->team_name }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="padding-right:0px">
                                        {{ $trainings->start_date_focus }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="padding-left:0px">
                                        {{ $trainings->end_date_focus }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="padding-right:0px">
                                        {{ $trainings->start_date_your }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="padding-left:0px">
                                        {{ $trainings->end_date_your }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="padding-right:0px">
                                        {{ $trainings->start_date_life }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}" style="padding-left:0px">
                                        {{ $trainings->end_date_life }}
                                    </td>
                                    <td class="{{ Config::get('style.rowCenter') }}">
                                        {{ __($trainings->status) }}
                                    </td>
                                    @auth
                                        <td class="w-24 inline-flex text-center py-1.5">
                                            <a class="{{ Config::get('style.btnEdit') }}"
                                                href="{{ route('Training.edit', $trainings->id) }}">
                                                <span
                                                    class="icon-pencil text-orange-900 hover:bg-orange-500 hover:text-white"></span>
                                            </a>

                                            <form action="{{ route('Training.destroy', $trainings) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="{{ Config::get('style.btnDelete') }}" type="submit"
                                                    onclick="return confirm('¿Seguro que deseas eliminar el Entrenamiento?')">
                                                    <span
                                                        class="icon-bin2  text-red-900 hover:bg-red-500 hover:text-white"></span>
                                                </button>
                                            </form>
                                        </td>
                                    @endauth
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="pagina" class=" text-sky-800 bg-gray-50dark:text-sky-400">
                        {{ $training->links() }}
                    </div>
                </div>
                <div id="sinResultados" class="px-4 py-3 text-sky-800 bg-gray-50dark:text-sky-400">
                </div>
            </main>
        </div>
    </div>

</x-app-layout>
