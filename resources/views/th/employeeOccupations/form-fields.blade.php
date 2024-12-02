<div class="space-y-4" >
    
    <label class="flex flex-col px-4">
        <input type="hidden" 
                id="employee_id"
                name="employee_id" 
                value=" {{ old('employee_id', $employeeOccupation->employee_id) }}"/>
        <span class="{{ Config::get('style.label') }}">@lang('Employee')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                id="search" 
                name="search"
                onkeyup="spaces(this.id)"
                value=" {{ old('employee', $employeeOccupation->employee) }}"/>
    </label>

    <label class="flex flex-col px-4">
        <input  type="hidden" 
                id="department_id"
                name="department_id" 
                value=" {{ old('department_id', $employeeOccupation->department_id) }}"/>
        <span class="{{ Config::get('style.label') }}">@lang('Department')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                id="department" 
                name="department" 
                onkeyup="spaces(this.id)"
                value=" {{ old('department', $employeeOccupation->department) }}"/>
    </label>

    <label class="flex flex-col px-4">
        <input  type="hidden" 
                id="job_title_id"
                name="job_title_id" 
                value=" {{ old('job_title_id', $employeeOccupation->job_title_id) }}"/>
        <span class="{{ Config::get('style.label') }}">@lang('Job Title')</span>
        <input class="{{ Config::get('style.cajaTexto') }}" 
                type="text" 
                id="job_title" 
                name="job_title" 
                onkeyup="spaces(this.id)"
                value=" {{ old('job_title', $employeeOccupation->jobTitle) }}"/>
    </label>
            
    
    <div class="flex flex-row flex-wrap">
        <div class="basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Evaluator')</span>
                <select class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="evaluator" 
                        required/>
                    <option @if($employeeOccupation->evaluator =="NO") selected @endif
                        value="NO" >@lang('NO')</option>
                    <option @if($employeeOccupation->evaluator =="SI") selected @endif
                        value="SI" >@lang('SI')</option>
                </select>
                @error('evaluator')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="basis-1/4 px-4">    
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Entry Date')</span>
                <input class="{{ Config::get('style.cajaTexto') }} date" 
                        type="text" 
                        name="entry_date" 
                        value=" {{ old('entry_date', $employeeOccupation->entry_date) }}" required/>
                @error('entry_date')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="basis-1/4 px-4">    
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Departure Date')</span>
                <input class="{{ Config::get('style.cajaTexto') }} date" 
                        type="text" 
                        name="departure_date" 
                        value=" {{ old('departure_date', $employeeOccupation->departure_date) }}" required/>
                @error('departure_date')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>

        <div class="basis-1/4 px-4">
            <label class="flex flex-col">
                <span class="{{ Config::get('style.label') }}">@lang('Status')</span>
                <select class="{{ Config::get('style.cajaTexto') }} " 
                        type="text" 
                        name="status" 
                        required/>
                    <option value="ACTIVE" 
                        @if($employeeOccupation->status =="ACTIVE") selected @endif
                    >@lang('ACTIVE')</option>
                    <option value="INACTIVE" 
                        @if($employeeOccupation->status =="INACTIVE") selected @endif
                    >@lang('INACTIVE')</option>
                </select>
                @error('status')
                    <br>
                    <small class="font-bold text-red-500/80">{{ $message }}</small>
                @enderror
            </label>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $( ".date" ).datepicker({
            changeMonth: true;
            changeYear: true;
            dateFormat: "yy-mm-dd";
        });
    });

    function spaces(e) {
        let x = document.getElementById(e);
        x.value = x.value.trim();
    }

    $( "#search" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: '/search/'+request.term,
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
            return false;
        }
      });

      $( "#department" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: '/searchDepartment/'+request.term,
            type: 'GET',
            dataType: "json",
             minLength: 2,
            success: function( data ) {
               response( data );
            }
          });
        };
        select: function (event, ui) {
            $('#department').val(ui.item.label);
            $('#department_id').val(ui.item.id);
            return false;
        }
      });

      $( "#job_title" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: '/searchJobTitle/'+request.term,
            type: 'GET',
            dataType: "json",
             minLength: 2,
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
            $('#job_title').val(ui.item.label);
            $('#job_title_id').val(ui.item.id);
            return false;
        }
      });
  
  
</script>