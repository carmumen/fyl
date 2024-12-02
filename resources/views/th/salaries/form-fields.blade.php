<div class="space-y-4">

    <label class="flex flex-col">
        <input type="hidden" 
                id="employee_id"
                name="employee_id" 
                value=" {{ old('employee_id', $salary->employee_id) }}"/>
        <span class="{{ Config::get('style.label') }}">@lang('Employee')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                id="search" 
                name="search"
                onkeyup="spaces(this.id)"
                value=" {{ old('employee', $salary->employee) }}"/>
    </label>

    <div class="flex flex-row flex-wrap">
        <div class="basis-1/2  px-4">
        <label class="flex flex-col" >
            <span class="{{ Config::get('style.label') }} py-1">@lang('Minimum Salary')</span>
            <input style="border:0" 
                    type="text" 
                    id="minimum_salary"
                    name="minimum_salary" 
                    disabled
                    value=" {{ old('minimum_salary', $salary->minimum_salary) }}"/>
        </label>
        </div>

        <div class="basis-1/2  px-4">
        <label class="flex flex-col">
            <span class="{{ Config::get('style.label') }}">@lang('Maximum Salary')</span>
            <input style="border:0" 
                    type="text" 
                    id="maximum_salary"
                    name="maximum_salary" 
                    disabled
                    value=" {{ old('maximum_salary', $salary->maximum_salary) }}"/>
        </label>
        </div>
    </div>

    <label class="flex flex-col">
        <span class="{{ Config::get('style.label') }}">@lang('Salary')</span>
		<input class="{{ Config::get('style.cajaTexto') }} decimales" 
                type="text" 
                name="amount" 
                value=" {{ old('amount', $salary->amount) }}" required/>
        @error('amount')
            <br>
            <small class="font-bold text-red-500/80">{{ $message }}</small>
        @enderror
    </label>
    
</div>

<script>
    function spaces(e) {
        let x = document.getElementById(e);
        x.value = x.value.trim();
    }

    $( "#search" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: '/searchDetails/'+request.term,
            type: 'GET',
            dataType: "json",
             minLength: 2,
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
            $('#search').val(ui.item.label);
            $('#employee_id').val(ui.item.id);
            $('#minimum_salary').val(ui.item.minimum_salary);
            $('#maximum_salary').val(ui.item.maximum_salary);
            return false;
        }
    });
    
    $('.decimales').on('input', function () {
        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });
</script>