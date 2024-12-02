<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-sky-800">
        <tr>
            <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">{{ $title }}</th>
            <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">EST</th>
            <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">LLAM</th>
            <th scope="col" class="{{ Config::get('style.headerCenterXs') }}">%</th>
        </tr>
        <tr>
            <th scope="col" colspan="4" class="{{ Config::get('style.headerCenterXs') }}"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                @if ($item->confirm_assistance == 'SI')
                    <td class="{{ Config::get('style.rowLeftXs') }}" style="color:black"><b>{{ $item->name }}</b></td>
                    <td class="{{ Config::get('style.rowCenterXs') }}" style="color:black">
                        <b>{{ $item->confirm_assistance }}</b>
                    </td>
                    <td class="{{ Config::get('style.rowCenterXs') }}" style="color:black"><b>{{ $item->CANTIDAD }}</b>
                    </td>
                    <td class="{{ Config::get('style.rowCenter') }}" style="color:black">
                        <b>{{ $item->porcentaje }}</b>
                    </td>
                @else
                    @if ($item->confirm_assistance == 'ENR')
                        <td class="{{ Config::get('style.rowLeftXs') }}" style="color:navy"><b>{{ $item->name }}</b></td>
                        <td class="{{ Config::get('style.rowCenterXs') }}" style="color:navy">
                            <b>{{ $item->confirm_assistance }}</b>
                        </td>
                        <td class="{{ Config::get('style.rowCenterXs') }}" style="color:navy"><b>{{ $item->CANTIDAD }}</b>
                        </td>
                        <td class="{{ Config::get('style.rowCenter') }}" style="color:navy">
                            <b>{{ $item->porcentaje }}</b>
                        </td>
                    @else
                        <td class="{{ Config::get('style.rowLeftXs') }}" style="color:black">{{ $item->name }}</td>
                        <td class="{{ Config::get('style.rowCenterXs') }}" style="color:black">
                            {{ $item->confirm_assistance }}</td>
                        @if ($item->confirm_assistance == 'SLL')
                            <td class="{{ Config::get('style.rowCenterXs') }}" style="color:red"><b>{{ $item->CANTIDAD }}</b></td>
                        @else
                            <td class="{{ Config::get('style.rowCenterXs') }}" style="color:black">{{ $item->CANTIDAD }}</td>
                        @endif
                        <td class="{{ Config::get('style.rowCenterXs') }}" style="color:black">{{ $item->porcentaje }}
                        </td>
                    @endif
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
