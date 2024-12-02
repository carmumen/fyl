<div class="flex flex-col w-full">
    <div class="flex space-x-1 bg-gray-200 rounded-t-lg p-0" style="cursor:pointer">
        <a class="tab-button w-full py-2 text-left text-white rounded-t-lg focus:outline-none"
            style="font-weight:bold; color:#0284c7; background-color:#FFF; border:1px solid #0284c7; border-bottom:0px"
            href="">
            <center>Asignaciones Equipo</center>
        </a>
        <a class="tab-button w-full py-2 text-left text-gray-700 bg-gray-200 rounded-t-lg focus:outline-none" 
            style="color:#0284c7; background-color:#FFF; border:1px solid #0284c7"
            href="{{ route('AsignacionEquipo.index') }}">
            <center>Mantenimiento de asignaciones</center>
        </a>
    </div>
</div>
<!--
<div class="flex flex justify-between">
    
    
    <div class="p-1">
        <div class="flex items-center space-x-2 m-4">
        <a class="{{ Config::get('style.btnCreate') }}" href="">
            <div class="hidden md:inline-block">Asignaciones</div>
        </a>
        </div>
    </div>
    
    <div class="p-1">
        <div class="flex items-center space-x-2 m-4">
        <a class="{{ Config::get('style.btnCreate') }}" href="">
            <div class="hidden md:inline-block">Mantenimiento de Asignaciones</div>
        </a>
        </div>
    </div>
</div>

-->
    
<script>
    $(document).ready(function () {
        $('#training_id').on('change', onSelectChange);
    });
    
    function onSelectCampusChange() {
        document.getElementById('campus_form').submit();
    };
    
    function onSelectChange() {
        console.log
        var campusId = $('#campus_id').val();
        $('#campus').val(campusId);  // Actualizar el campus_id
        document.getElementById('training_form').submit();
    };
</script>