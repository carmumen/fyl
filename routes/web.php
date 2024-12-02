<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\DatabaseController;


// Ruta para ejecutar el script
//Route::get('/kill-connections', [DatabaseController::class, 'killConnections'])->name('kill.connections');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// DB::listen(function($query){
//  var_dump($query->sql);
// });

Route::view('/', 'welcome')->name('home');
Route::view('/users', 'users')->name('users');

//Route::resource('Managment';'App\Http\Controllers\ManagmentController')->names('Managment');
//Route::view('/profiles';'profiles')->name('profiles');

Route::resource('Aplications', 'App\Http\Controllers\Security\AplicationsController')->names('Aplications');
Route::resource('Modules', 'App\Http\Controllers\Security\ModulesController')->names('Modules');
Route::post('Modules/{aplicationId}', 'App\Http\Controllers\Security\ModulesController@findModuleByAplicationId')->name('Modules.findModuleByAplicationId');
Route::resource('Functionalities', 'App\Http\Controllers\Security\FunctionalitiesController')->names('Functionalities');
Route::resource('Profiles', 'App\Http\Controllers\Security\ProfilesController')->names('Profiles');
Route::resource('ProfileFunctionalities', 'App\Http\Controllers\Security\ProfileFunctionalitiesController')->names('ProfileFunctionalities');
Route::resource('Users', 'App\Http\Controllers\Security\UsersController')->names('Users');
Route::resource('UserProfiles', 'App\Http\Controllers\Security\UserProfilesController')->names('UserProfiles');


Route::resource('ProfilesFocus', 'App\Http\Controllers\Fyl\ProfilesController')->names('ProfilesFocus');
Route::post('/agregaUsuario', 'App\Http\Controllers\Fyl\ProfilesController@addUser')->name('ProfilesFocus.addUser');
Route::post('/agrega-funcionalidad', 'App\Http\Controllers\Fyl\ProfilesController@addFun')->name('ProfilesFocus.addFun');
Route::get('/editar-funcionalidad/{profileId}', 'App\Http\Controllers\Fyl\ProfilesController@editFun')->name('ProfilesFocus.editFun');
Route::delete('/destroy-funcionalidad/{profileFunctionalityId}', 'App\Http\Controllers\Fyl\ProfilesController@destroyFun')->name('ProfilesFocus.destroyFun');


Route::get('/sede-usuario/{user}', 'App\Http\Controllers\Fyl\ProfilesController@sedeUsuario')->name('ProfilesFocus.sedeUsuario');

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/managment', function () {
//    return view('managment');
//})->middleware(['auth', 'verified'])->name('managment');

Route::get('/managment', function ($fechas = null) {
    return view('managment', compact('fechas'));
})->middleware(['auth', 'verified'])->name('managment');


Route::get('/parentModule/{aplicationId}', 'App\Http\Controllers\Security\ModulesController@findParentModuleByAplicationId')->name('Modules.parentModule');
Route::get('/childModule/{parentModuleId}', 'App\Http\Controllers\Security\ModulesController@findModuleByParentModuleId')->name('Modules.childModule');

Route::get('/profileAplication/{aplicationId}', 'App\Http\Controllers\Security\ProfilesController@findProfileByAplicationId')->name('Profiles.aplication');
Route::get('/functionalityAplication/{aplicationId}', 'App\Http\Controllers\Security\FunctionalitiesController@findFunctionalityByAplicationId')->name('Functionalities.aplication');


Route::get('/modAplication/{aplicationId}', 'App\Http\Controllers\Security\ModulesController@findModuleByAplicationId')->name('Modules.modAplication');
Route::get('/profileUserProfile', 'App\Http\Controllers\Security\ProfilesController@findProfileAll')->name('Profiles.profileUserProfile');
Route::get('/userUserProfile', 'App\Http\Controllers\Security\UsersController@findUserAll')->name('Users.userUserProfile');
Route::get('/aplicationUser', 'App\Http\Controllers\Security\AplicationsController@findAplicationUser')->name('Aplications.aplicationUser');

Route::get('/managmen', 'App\Http\Controllers\ManagmentController@findMenuAplicationId')->name('Managment.aplication');

Route::get('/generar-factura/{id}', 'App\Http\Controllers\Fyl\PrinterController@generarFactura')->name('factura.generar');



// INGRESOS Y GASTOS

    Route::resource('EgressIncome', 'App\Http\Controllers\Fyl\EgressIncomeController')->names('EgressIncome');
    
    
// ESTE ES EL CAMBIO REALIZADO PARA CERRAR CONEXIONES   //////////////////////////// 

Route::middleware(['auth', 'closeInactiveSessions'])->group(function () {
    // Rutas que requieren autenticaci��n y el middleware
    //Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    // Otras rutas...
});  

//Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');

////////////////////////////////////////////////////////////////////////////////

// CATALOGOS
Route::middleware('auth')->group(function () {
    //Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::resource('CatalogType', 'App\Http\Controllers\Catalog\CatalogTypeController')->names('CatalogTypes');
    Route::resource('Catalog', 'App\Http\Controllers\Catalog\CatalogController')->names('Catalogs');
    Route::resource('Country', 'App\Http\Controllers\Catalog\CountryController')->names('Countries');
    Route::resource('Province', 'App\Http\Controllers\Catalog\ProvinceController')->names('Provinces');
    Route::resource('Canton', 'App\Http\Controllers\Catalog\CantonController')->names('Cantons');
    Route::resource('City', 'App\Http\Controllers\Catalog\CityController')->names('Cities');

    Route::get('/catTypeId/{catalogTypeId}', 'App\Http\Controllers\Catalog\CatalogController@findCatalogTypeId')->name('Catalog.catTypeId');
    Route::get('/searchCountry/{search}', 'App\Http\Controllers\Catalog\CountryController@findCountry')->name('Country.searchCountry');
    Route::get('/searchProvince/{country}', 'App\Http\Controllers\Catalog\ProvinceController@findProvince')->name('Province.searchProvince');
    Route::get('/searchCanton/{province}', 'App\Http\Controllers\Catalog\CantonController@findCanton')->name('Canton.searchCanton');
    Route::get('/searchCity/{canton}', 'App\Http\Controllers\Catalog\CityController@findCity')->name('City.searchCity');
    Route::delete('/academicTraining/{academicTraining}', 'App\Http\Controllers\TH\EmployeeController@destroyAcademicTraining')->name('AcademicTraining.destroyAcademicTraining');
});
// TALENTO HUMANO
Route::middleware('auth')->group(function () {
    Route::resource('Department', 'App\Http\Controllers\TH\DepartmentController')->names('Departments');
    Route::resource('JobTitle', 'App\Http\Controllers\TH\JobTitleController')->names('JobTitles');
    Route::resource('Employee', 'App\Http\Controllers\TH\EmployeeController')->names('Employees');
    Route::resource('EmployeeOccupation', 'App\Http\Controllers\TH\EmployeeOccupationController')->names('EmployeeOccupations');
    Route::resource('Salary', 'App\Http\Controllers\TH\SalaryController')->names('Salaries');


    Route::get('/actualizarTab', 'App\Http\Controllers\TH\EmployeeController@actualizarTab')->name('Employee.actualizarTab');
    Route::get('/search/{search}', 'App\Http\Controllers\TH\EmployeeController@findEmployee')->name('Employee.search');
    Route::get('/searchDetails/{search}', 'App\Http\Controllers\TH\EmployeeOccupationController@findEmployeeDetails')->name('Employee.searchDetails');
    Route::get('/searchDepartment/{search}', 'App\Http\Controllers\TH\DepartmentController@findDepartment')->name('Departments.search');
    Route::get('/searchJobTitle/{search}', 'App\Http\Controllers\TH\JobTitleController@findJobTitle')->name('JobTitles.search');
});

// CampusES
Route::middleware('auth')->group(function () {
    Route::resource('Campus', 'App\Http\Controllers\Client\ClientController')->names('Clients');
    Route::resource('CustomerDetail', 'App\Http\Controllers\Client\CustomerDetailController')->names('CustomerDetails');
});

//FYL
Route::middleware('auth')->group(function () {
    Route::resource('Campus', 'App\Http\Controllers\Fyl\CampusController')->names('Campus');
    Route::resource('Programs', 'App\Http\Controllers\Fyl\ProgramsController')->names('Programs');
    Route::resource('Training', 'App\Http\Controllers\Fyl\TrainingController')->names('Training');
    Route::resource('LifeTemplate', 'App\Http\Controllers\Fyl\LifeTemplateController')->names('LifeTemplate');
    Route::resource('Participants', 'App\Http\Controllers\Fyl\ParticipantsController')->names('Participants');
    
    //desarrollo
    Route::resource('ParticipantsDesarrollo', 'App\Http\Controllers\Fyl\ParticipantsDesarrolloController')->names('ParticipantsDesarrollo');
    Route::post('Participant-desarrollo-training', 'App\Http\Controllers\Fyl\ParticipantsDesarrolloController@obtenerEntrenamiento')->name('ParticipantsDesarrollo.obtenerEntrenamiento');
    Route::middleware('log.post.request')->post('Participant-desarrollo-recarga', 'App\Http\Controllers\Fyl\ParticipantsDesarrolloController@recarga')->name('ParticipantsDesarrollo.recarga');
    Route::middleware('log.post.request')->post('Participant-desarrollo-retorno', 'App\Http\Controllers\Fyl\ParticipantsDesarrolloController@retorno')->name('ParticipantsDesarrollo.retorno');
    //ParticipantsDesarrollo
    
    Route::post('Participant-training', 'App\Http\Controllers\Fyl\ParticipantsController@obtenerEntrenamiento')->name('Participants.obtenerEntrenamiento');
    Route::middleware('log.post.request')->post('Participant-recarga', 'App\Http\Controllers\Fyl\ParticipantsController@recarga')->name('Participants.recarga');
    Route::middleware('log.post.request')->post('Participant-retorno', 'App\Http\Controllers\Fyl\ParticipantsController@retorno')->name('Participants.retorno');
    
    Route::get('/participants/{id}/editar/{campusId}/{trainingId}/{parameter}/{search}/{pag}', 'App\Http\Controllers\Fyl\ParticipantsController@edit')->name('Participants.editar');
    
    
    Route::resource('Calendar', 'App\Http\Controllers\Fyl\CalendarController')->names('Calendar');
    Route::post('Calendar-training', 'App\Http\Controllers\Fyl\CalendarController@obtenerEntrenamiento')->name('Calendar.obtenerEntrenamiento');
    
    Route::middleware('log.post.request')->post('/calendar-save', 'App\Http\Controllers\Fyl\CalendarController@save')->name('Calendar.save');
    Route::post('/calendar-get', 'App\Http\Controllers\Fyl\CalendarController@getCalendar')->name('Calendar.getCalendar');
    
    Route::get('Campus-training', 'App\Http\Controllers\Fyl\ParticipantsController@training_in_game')->name('Campus.training');
    
    Route::resource('Clients', 'App\Http\Controllers\Fyl\ClientsController')->names('Clients');
    Route::resource('TeamStaff', 'App\Http\Controllers\Fyl\TeamStaffController')->names('TeamStaff');
    Route::resource('TeamStaffYour', 'App\Http\Controllers\Fyl\TeamStaffYourController')->names('TeamStaffYour');

    Route::get('FocusParticipants/team', 'App\Http\Controllers\Fyl\FocusParticipantsController@team')->name('FocusParticipants.team');
    Route::resource('FocusParticipants', 'App\Http\Controllers\Fyl\FocusParticipantsController')->names('FocusParticipants');
    
    //REZAGADOS
    Route::resource('FocusRezagados', 'App\Http\Controllers\Fyl\FocusRezagadosController')->names('FocusRezagados');
    Route::post('followRezagados', 'App\Http\Controllers\Fyl\FocusRezagadosController@call')->name('FocusRezagadosCall.call');
    //FIN REZAGADOS
    
    Route::resource('FocusToYour', 'App\Http\Controllers\Fyl\FocusToYourController')->names('FocusToYour');
    Route::resource('YourParticipants', 'App\Http\Controllers\Fyl\YourParticipantsController')->names('YourParticipants');
    Route::resource('LifeParticipants', 'App\Http\Controllers\Fyl\LifeParticipantsController')->names('LifeParticipants');
    
    Route::post('LifeParticipants-next', 'App\Http\Controllers\Fyl\LifeParticipantsController@storeNext')->name('LifeParticipants.storeNext');

    Route::resource('Prices', 'App\Http\Controllers\Fyl\PricesController')->names('Prices');
    Route::resource('Enroller', 'App\Http\Controllers\Fyl\EnrollerController')->names('Enroller');
    Route::resource('Staff', 'App\Http\Controllers\Fyl\StaffController')->names('Staff');
    Route::resource('StaffYour', 'App\Http\Controllers\Fyl\StaffYourController')->names('StaffYour');
    Route::resource('MasterLife', 'App\Http\Controllers\Fyl\MasterLifeController')->names('MasterLife');
    Route::resource('FocusStatement', 'App\Http\Controllers\Fyl\FocusStatementController')->names('FocusStatement');
    Route::resource('YourStatement', 'App\Http\Controllers\Fyl\YourStatementController')->names('YourStatement');
    Route::resource('FocusConsolidated', 'App\Http\Controllers\Fyl\FocusConsolidatedController')->names('FocusConsolidated');
    Route::resource('FocusDashboard', 'App\Http\Controllers\Fyl\FocusDashboardController')->names('FocusDashboard');
    Route::resource('YourDashboard', 'App\Http\Controllers\Fyl\YourDashboardController')->names('YourDashboard');
    Route::resource('CampusUser', 'App\Http\Controllers\Fyl\CampusUserController')->names('CampusUser');

    Route::resource('OldTraining', 'App\Http\Controllers\Fyl\OldTrainingController')->names('OldTraining');
    Route::resource('OldTeam', 'App\Http\Controllers\Fyl\OldTeamController')->names('OldTeam');

    Route::resource('Fds', 'App\Http\Controllers\Fyl\FdsController')->names('Fds');
    Route::post('FdsTeam', 'App\Http\Controllers\Fyl\FdsController@teamsRegister')->name('FdsTeam.teamsRegister');
    Route::get('FdsTeam/{fds}', 'App\Http\Controllers\Fyl\FdsController@teams')->name('FdsTeam.teams');

    Route::get('/campus_training/{campus_id}/{action}', 'App\Http\Controllers\Fyl\TrainingController@findTrainingForCampus')->name('TrainingC.findTrainingForCampus');
    
    Route::post('staff-yours/massive', 'App\Http\Controllers\Fyl\StaffYourController@storeMassive')->name('staff-yours.storeMassive');
    Route::post('master-life/massive', 'App\Http\Controllers\Fyl\MasterLifeController@storeMassive')->name('master-life.storeMassive');

    Route::post('follow', 'App\Http\Controllers\Fyl\FocusParticipantsController@call')->name('FocusCall.call');
    Route::post('followYour', 'App\Http\Controllers\Fyl\YourParticipantsController@call')->name('YourCall.call');
    Route::post('followFocusToYour', 'App\Http\Controllers\Fyl\FocusToYourController@call')->name('FocusToYourCall.call');

    Route::get('/dashboard-life', 'App\Http\Controllers\Fyl\LifeDashboardController@index')->name('LifeDashboard.index');
    Route::get('/reports-focus', 'App\Http\Controllers\Fyl\ReportsFocusController@index')->name('ReportsFocusTab.index');
    
    Route::get('/participants-name-change', 'App\Http\Controllers\Fyl\ParticipantsNameChangeController@index')->name('ParticipantsNameChange.index');

    Route::post('/calendarLife', 'App\Http\Controllers\Fyl\TrainingController@calendarLife')->name('Training.calendarLife');

    
    Route::post('/graduate/{id}', 'App\Http\Controllers\Fyl\ParticipantsController@graduate')->name('ParticipantsG.graduate');
    
    Route::get('/payment/{id}/{campus_id}/{program}/{training}/{training_id_enroller}/{training_id}/{parameter}/{search}/{pag}', 'App\Http\Controllers\Fyl\ParticipantsController@payment')->name('Participants.payment');
    Route::post('/paymentRegister', 'App\Http\Controllers\Fyl\ParticipantsController@payment_register')->name('Participants.payment_register');
    
    Route::get('/payment-edit/{id}/{campus}/{program}/{program_name}/{training}/{training_id_enroller}/{payment_id}/{training_id}/{parameter}/{search}/{pag}', 'App\Http\Controllers\Fyl\ParticipantsController@payment_edit')->name('Payment.editar');
    Route::patch('/payment-update', 'App\Http\Controllers\Fyl\ParticipantsController@payment_update')->name('PaymentU.update');
    
    Route::get('/payment-transferencia', 'App\Http\Controllers\Fyl\PaymentController@payment_transferencia')->name('PaymentT.transferencia');
    Route::get('/busca-transferencia', 'App\Http\Controllers\Fyl\PaymentController@busca_transferencia')->name('PaymentB.busca');
    Route::post('/transfiere-pago', 'App\Http\Controllers\Fyl\PaymentController@payment_transferir')->name('PaymentTr.transferir');
    
    
    
    
    Route::get('/otra_sede', 'App\Http\Controllers\Fyl\ParticipantsController@searchOtraSede')->name('ParticipantsOtraSede.searchOtraSede');
    Route::get('/otra_sede_for_your', 'App\Http\Controllers\Fyl\ParticipantsController@searchOtraSedeYour')->name('ParticipantsOtraSedeYour.searchOtraSedeYour');


    Route::get('/prices/{campus}/{program}/{priceType}', 'App\Http\Controllers\Fyl\PricesController@findProgram')->name('Prices.program');
    Route::get('/rolTraining/{search}', 'App\Http\Controllers\Fyl\TrainingController@findRolTraining')->name('RolTraining.search');
    Route::delete('/focusTeam/{trainingTeam}', 'App\Http\Controllers\Fyl\TrainingController@destroyFocusTeam')->name('Training.destroyFocusTeam');
    Route::delete('/yourTeam/{trainingTeam}', 'App\Http\Controllers\Fyl\TrainingController@destroyYourTeam')->name('Training.destroyYourTeam');
    Route::delete('/lifeTeam/{trainingTeam}', 'App\Http\Controllers\Fyl\TrainingController@destroyLifeTeam')->name('Training.destroyLifeTeam');
    Route::delete('/calendar/{calendar}', 'App\Http\Controllers\Fyl\TrainingController@destroyCalendar')->name('Training.destroyCalendar');
    Route::delete('/payment/{payment}', 'App\Http\Controllers\Fyl\ParticipantsController@destroyPayment')->name('Participants.destroyPayment');
    Route::post('/update-price-flash', 'App\Http\Controllers\Fyl\ParticipantsController@updatePriceFlash')->name('Participants.updatePriceFlash');
    Route::get('/dni_training/{training_id}', 'App\Http\Controllers\Fyl\ParticipantsController@findDNITrainingId')->name('Participants.findDNITrainingId');
    Route::post('/update-dni-flash', 'App\Http\Controllers\Fyl\ParticipantsController@updateDNIFlash')->name('Participants.updateDNIFlash');
    Route::get('/CC_RUC_client/{client_CC_RUC}', 'App\Http\Controllers\Fyl\ParticipantsController@findCC_RUCClient')->name('Participants.findCC_RUCClient');
    Route::post('/actualizar_estado_f/{focusParticipants_id}', 'App\Http\Controllers\Fyl\FocusParticipantsController@updateStatus')->name('Participants.updateStatusF');
    Route::post('/actualizar_estado_y/{yourParticipants_id}', 'App\Http\Controllers\Fyl\YourParticipantsController@updateStatus')->name('Participants.updateStatusY');
    Route::post('/actualizar_estado_l/{lifeParticipants_id}', 'App\Http\Controllers\Fyl\LifeParticipantsController@updateStatus')->name('Participants.updateStatusL');
    Route::post('/actualizar_estado_d/{focusParticipants_id}', 'App\Http\Controllers\Fyl\FocusStatementController@updateStatus')->name('FocusStatement.updateStatusD');
    Route::post('/actualizar_estado_dy/{yourParticipants_id}', 'App\Http\Controllers\Fyl\YourStatementController@updateStatus')->name('YourStatement.updateStatusDY');
    
    Route::post('/agregarFocusOtraSede', 'App\Http\Controllers\Fyl\FocusParticipantsController@agregaOtraSede')->name('FocusOtraSede.agregaOtraSede');
    Route::post('/agregarYourOtraSede', 'App\Http\Controllers\Fyl\YourParticipantsController@agregaOtraSede')->name('YourOtraSede.agregaOtraSede');
    
    Route::post('/agregarYourOtraSede', 'App\Http\Controllers\Fyl\YourParticipantsController@agregaOtraSede')->name('YourOtraSede.agregaOtraSede');
    


    Route::post('/save-comment', 'App\Http\Controllers\Fyl\FocusStatementController@insertComment')->name('FocusStatementC.insertComment');
    Route::post('/save-comment-y/{id}', 'App\Http\Controllers\Fyl\YourStatementController@insertComment')->name('YourStatementC.insertComment');

    Route::post('/actualizar_declaracion_l/{lifeParticipants_id}', 'App\Http\Controllers\Fyl\LifeParticipantsController@updateStatement')->name('Declaracion.updateStatementL');
    Route::get('/focus-consolidated', ['App\Http\Controllers\Fyl\FocusConsolidatedController'::class, 'index'])->name('focus-consolidated.index');

    Route::post('TeamStaff/updateLegendary', 'App\Http\Controllers\Fyl\TeamStaffController@updateLegendary')->name('TeamStaff.updateLegendary');
    Route::post('TeamStaffLegendary', 'App\Http\Controllers\Fyl\TeamStaffController@storeTS')->name('TeamStaffLegendary.storeTS');
    Route::delete('TeamStaffLegendary/{id}', 'App\Http\Controllers\Fyl\TeamStaffController@destroySL')->name('TeamStaffD.destroySL');

    Route::post('/actualizar_staff/{focusParticipants_id}', 'App\Http\Controllers\Fyl\FocusParticipantsController@updateStaff')->name('Participants.updateStaff');
    Route::get('/obtener-participantes/{letra}', 'App\Http\Controllers\Fyl\ParticipantsController@obtenerParticipantesPorLetra');
    Route::get('/sse', 'App\Http\Controllers\SSEController@stream')->name('Sse.stream');

    Route::get('/listado-focus/{trainingId}', 'App\Http\Controllers\Fyl\ListController@list')->name('list.listFocus');
    Route::get('/listado-your/{trainingId}', 'App\Http\Controllers\Fyl\ListController@list')->name('list.listYour');
    Route::get('/listado-life/{trainingId}', 'App\Http\Controllers\Fyl\ListController@list')->name('list.listLife');

    Route::get('/obtener_datos_ordenados', 'App\Http\Controllers\Fyl\FocusParticipantsController@ordenarDatos')->name('FocusParticipants.ordenarDatos');

    /////////LISTAS////////////////////////////////
    Route::get('listas/training', 'App\Http\Controllers\Fyl\ListasController@training');
    Route::get('listas/staffFocus/{trainingId}', 'App\Http\Controllers\Fyl\ListasController@staffFocus');
    Route::get('/code', 'App\Http\Controllers\Fyl\EnrollerController@code')->name('Enroller.code');
    Route::post('/life/generateCode', 'App\Http\Controllers\Fyl\EnrollerController@generateCode')->name('Enroller.generateCode');
    Route::post('/recuperado', 'App\Http\Controllers\Fyl\EnrollerController@newRegister')->name('EnrollerNR.newRegister');
    Route::get('/gafetes/{trainingId}', 'App\Http\Controllers\Fyl\ReportsController@gafete')->name('ReportsFicha.gafete');
    Route::get('/gafetes-your/{trainingId}', 'App\Http\Controllers\Fyl\ReportsController@gafeteYour')->name('ReportsFichaY.gafeteY');

    Route::get('/ficha/{id}', 'App\Http\Controllers\Fyl\ReportsController@generatePdf');

    Route::get('/ficha', 'App\Http\Controllers\Fyl\ReportsController@ficha')->name('Reports.ficha');
    Route::post('/paymentsFDS', 'App\Http\Controllers\Fyl\ReportsController@enrollerForTeam')->name('ReportsPlane.enrollerForTeam');
    Route::get('/payment-summary-focus', 'App\Http\Controllers\Fyl\ReportsController@payment_summary_focus')->name('ReportsFocus.payment_summary_focus');
    Route::get('/payment-summary-your', 'App\Http\Controllers\Fyl\ReportsController@payment_summary_your')->name('ReportsYour.payment_summary_your');
    Route::get('/payment-summary-life', 'App\Http\Controllers\Fyl\ReportsController@payment_summary_life')->name('ReportsLife.payment_summary_life');
    
    
    Route::get('/payment-summary', 'App\Http\Controllers\Fyl\ReportsController@payment_summary')->name('ReportsPayments.payment_summary');
    
    Route::get('/focus-list', 'App\Http\Controllers\Fyl\ReportsController@listado')->name('ReportsList.Listado');
    Route::get('/your-list', 'App\Http\Controllers\Fyl\ReportsController@listado_your')->name('ReportsListYour.Listado');
    Route::get('/life-list', 'App\Http\Controllers\Fyl\ReportsController@listado_life')->name('ReportsListLife.Listado');
    //Route::get('/payment-summary-your', 'App\Http\Controllers\Fyl\ReportsController@payment_summary_your')->name('ReportsYour.payment_summary_your');
    
    Route::get('/calls-focus', 'App\Http\Controllers\Fyl\ReportsController@calls')->name('ReportsFocusCalls.calls');
    Route::get('/calls-focus-to-your', 'App\Http\Controllers\Fyl\ReportsController@callsFTY')->name('ReportsFocusToYourCalls.callsFTY');
    Route::get('/calls-your', 'App\Http\Controllers\Fyl\ReportsController@callsYour')->name('ReportsYourCalls.calls');
    
    Route::get('/fichas/{trainingId}/{set}', 'App\Http\Controllers\Fyl\ReportsController@ficha')->name('ReportsFicha.ficha');
    Route::get('/fichas/{trainingId}/{set}', 'App\Http\Controllers\Fyl\ReportsController@lista')->name('ReportsFichaL.lista');
    Route::get('/focusParticipants', 'App\Http\Controllers\Fyl\ReportsController@focusParticipants')->name('ReportsFP.focusParticipants');



    Route::get('/fichas/{trainingId}/{set}', 'App\Http\Controllers\Fyl\ReportsController@ficha')->name('ReportsFicha.ficha');
    //Route::get('/payment-summary-your', 'App\Http\Controllers\Fyl\ReportsController@payment_summary_your')->name('ReportsYour.payment_summary_your');
    //Route::get('/payment-summary-life', 'App\Http\Controllers\Fyl\ReportsController@payment_summary_life')->name('ReportsLife.payment_summary_life');

    // Route::get('/exportar-tabla/{trainingId}', 'App\Http\Controllers\ExportarController@exportarTabla');
    Route::get('/exportar-tabla/{table}/{trainingId}/{second}', 'App\Http\Controllers\ExportarController@exportarTabla');
    Route::post('/rezagadoF', 'App\Http\Controllers\Fyl\FocusParticipantsController@left_over')->name('FocusParticipant.left_over');
    Route::post('/rezagadoY', 'App\Http\Controllers\Fyl\YourParticipantsController@left_over')->name('YourParticipant.left_over');
    Route::post('/rezagadoL', 'App\Http\Controllers\Fyl\LifeParticipantsController@left_over')->name('LifeParticipants.left_over');
    
    Route::get('/old-team', 'App\Http\Controllers\Fyl\TrainingController@oldTeam')->name('TrainingTeam.oldTeam');
    Route::post('/old-team-register', 'App\Http\Controllers\Fyl\TrainingController@oldTeamRegister')->name('TrainingTeamR.oldTeamRegister');
    Route::post('/team-register', 'App\Http\Controllers\Fyl\TrainingController@teamRegister')->name('TrainingTeamT.TeamRegister');

    Route::get('/internal-code', 'App\Http\Controllers\Fyl\EnrollerController@internalCode')->name('Enroller.internalCode');
    Route::post('/generate-internal-code', 'App\Http\Controllers\Fyl\EnrollerController@generateInternalCode')->name('EnrollerG.generateInternalCode');
    Route::post('/team-staff-legendary', 'App\Http\Controllers\Fyl\EnrollerController@')->name('EnrollerG2.generateInternalCode');
    
    //Route::get('/export-html/{viewName}', 'App\Http\Controllers\HtmlExportController@exportHtmlToExcel')->name('export.html');
    Route::post('/export-html', 'App\Http\Controllers\HtmlExportController@exportHtmlToExcel')->name('export.html');

    
    
    ////////COORDINACION
    Route::resource('Contrato', 'App\Http\Controllers\Coordinacion\ContratoController')->names('Contrato');
    Route::resource('Promesa', 'App\Http\Controllers\Coordinacion\PromesaController')->names('Promesa');
    Route::resource('Actividades', 'App\Http\Controllers\Coordinacion\ActividadesController')->names('Actividades');
    Route::resource('Asignaciones', 'App\Http\Controllers\Coordinacion\AsignacionesController')->names('Asignaciones');
    Route::resource('AsignacionEquipo', 'App\Http\Controllers\Coordinacion\AsignacionEquipoController')->names('AsignacionEquipo');

    Route::get('AsignacionesRecargadas', 'App\Http\Controllers\Coordinacion\AsignacionesController@indexRecargado')->name('Asignaciones.recarga');
    Route::get('Recarga', 'App\Http\Controllers\Coordinacion\AsignacionEquipoController@indexRecarga')->name('Recarga.equipo');
    
    
    
    Route::match(['get', 'post'], '/listado', 'App\Http\Controllers\Coordinacion\ListadoController@listadoEnJuego')->name('Listado.equiposEnJuego');
    
    Route::post('/contrato/{contrato}', 'App\Http\Controllers\Coordinacion\PromesaController@updateContrato')->name('Promesa.updateContrato');
    
    Route::resource('Seguimiento', 'App\Http\Controllers\Coordinacion\SeguimientoController')->names('Seguimiento');
    
    Route::post('Seguimiento-training', 'App\Http\Controllers\Coordinacion\SeguimientoController@obtenerEntrenamiento')->name('Seguimiento.obtenerEntrenamiento');
    
    
    
    Route::post('promesas', 'App\Http\Controllers\Coordinacion\SeguimientoController@promesas')->name('Seguimiento.promesas');
    Route::post('actividades', 'App\Http\Controllers\Coordinacion\SeguimientoController@actividades')->name('Seguimiento.actividades');
    Route::post('seguimiento_asignaciones', 'App\Http\Controllers\Coordinacion\SeguimientoController@asignaciones')->name('Seguimiento.asignaciones');
    Route::post('llamadas', 'App\Http\Controllers\Coordinacion\SeguimientoController@llamadas')->name('Seguimiento.llamadas');
    Route::post('equipo', 'App\Http\Controllers\Coordinacion\SeguimientoController@equipo')->name('Seguimiento.equipo');
    Route::post('comunidad', 'App\Http\Controllers\Coordinacion\SeguimientoController@comunidad')->name('Seguimiento.comunidad');
    Route::post('promesas', 'App\Http\Controllers\Coordinacion\SeguimientoController@promesas')->name('Seguimiento.promesas');
    
    
    Route::get('actualizar_actividad/{id}/{campo}', 'App\Http\Controllers\Coordinacion\SeguimientoController@actualizarActividad')->name('Seguimiento.actualizarActividad');
    Route::get('actualizar_asignacion/{id}/{campo}', 'App\Http\Controllers\Coordinacion\SeguimientoController@actualizarAsignacion')->name('Seguimiento.actualizarAsignacion');
    Route::get('actualizar_llamada/{id}/{campo}', 'App\Http\Controllers\Coordinacion\SeguimientoController@actualizarLlamadas')->name('Seguimiento.actualizarLlamadas');
    Route::get('actualizar_equipo/{id}/{campo}', 'App\Http\Controllers\Coordinacion\SeguimientoController@actualizarEquipo')->name('Seguimiento.actualizarEquipo');
    Route::get('actualizar_comunidad/{id}/{campo}', 'App\Http\Controllers\Coordinacion\SeguimientoController@actualizarComunidad')->name('Seguimiento.actualizarComunidad');
    Route::get('actualizar_promesa/{id}/{campo}', 'App\Http\Controllers\Coordinacion\SeguimientoController@actualizarPromesas')->name('Seguimiento.actualizarPromesas');
    
    
    //Route::get('Seguimiento/create', 'App\Http\Controllers\Coordinacion\SeguimientoController@create')->name('Seguimiento.create');
    

    ////////////////////////////////
    
    ///////PRUEBAS GENERA CODIGO ENROLAMIENTO
    //Route::get('/code1', 'App\Http\Controllers\Fyl\EnrollerController1@code')->name('Enroller.code1');
    
    



    ////////////////////////////////
    
    ////////PASARELA
    
    Route::resource('Payment', 'App\Http\Controllers\Pasarela\BotonPagosController')->names('Payment');
    Route::get('Datafast', 'App\Http\Controllers\Pasarela\BotonPagosController@datafast')->name('Datafast');
    
    
    
    
    
    
    //////CASH
    
    Route::resource('Empresa', 'App\Http\Controllers\Cash\EmpresaController')->names('Empresa');
    
    Route::resource('Proveedores', 'App\Http\Controllers\Cash\ProveedoresController')->names('Proveedores');
    
    Route::get('/generar-factura', 'App\Http\Controllers\Fyl\FacturaController@generarFactura')->name('Factura.generarFactura');
    
    Route::post('/uploadFirma', 'App\Http\Controllers\Cash\EmpresaController@uploadFirma')->name('Empresa.uploadFirma');
    
    Route::post('/datosFactura', 'App\Http\Controllers\Cash\EmpresaController@datosFactura')->name('Empresa.datosFactura');
    
    Route::resource('Producto', 'App\Http\Controllers\Cash\ProductoController')->names('Producto');
    
    Route::resource('Gastos', 'App\Http\Controllers\Cash\GastosController')->names('Gastos');
    
    Route::get('/categoria/{cat_id_tipo_gasto}', 'App\Http\Controllers\Cash\GastosController@buscaCategoria')->name('Gastos.buscaCategoria');
    
    Route::post('/crear-categoria', 'App\Http\Controllers\Cash\GastosController@crearCategoria')->name('GastosCategoria.crear_categoria');
    
    //Route::post('/cash/crear-proveedor', 'App\Http\Controllers\Cash\GastosController@crearProveedor')->name('GastosProveedorG.crear_proveedor');
    
    Route::match(['get', 'post'], '/cash/crear-proveedor', 'App\Http\Controllers\Cash\GastosController@crearProveedor')->name('GastosProveedorG.crear_proveedor');
    
    Route::get('/obtener-proveedor', 'App\Http\Controllers\Cash\GastosController@obtenerProveedor')->name('GastosProveedor.obtener_proveedor');
    
    Route::get('/proveedor-list', 'App\Http\Controllers\Cash\GastosController@proveedor')->name('GastosProveedor.proveedor');
    
    Route::get('/obtener-proveedor-json', 'App\Http\Controllers\Cash\GastosController@obtenerProveedorJson')->name('GastosProveedorJson.obtener_proveedor_json');
    
    Route::get('/obtener-estado-cuenta', 'App\Http\Controllers\Cash\GastosController@obtenerEstadoCuenta')->name('GastosEstadoCuenta.obtenerEstadoCuenta');
    
    Route::get('/obtener-ingresos', 'App\Http\Controllers\Cash\GastosController@obtenerIngresos')->name('GastosIngresos.obtenerIngresos');
    
    Route::get('/obtener-egresos', 'App\Http\Controllers\Cash\GastosController@obtenerEgresos')->name('GastosEgresos.obtenerEgresos');
    
    
    ///////CONTIFICO
    
    Route::get('/cargarProductosDesdeAPI', 'App\Http\Controllers\Cash\ContificoApiController@cargarProductosDesdeAPI')->name('Actualiza.Productos');
    
    Route::get('/actualizaPreciosDesdeContifico', 'App\Http\Controllers\Cash\ContificoApiController@actualizaPreciosDesdeContifico')->name('Actualiza.Precios');
    
    Route::get('/consulta_precios/{id}', 'App\Http\Controllers\Cash\ContificoApiController@consultaPrecios')->name('Contifico.ConsultaPrecios');
    
    Route::get('/contifico_productos', 'App\Http\Controllers\Cash\ContificoApiController@index_productos')->name('ContificoP.Productos');
    
    Route::get('/contifico_documentos', 'App\Http\Controllers\Cash\ContificoApiController@index_documentos')->name('ContificoD.Documentos');
    
    Route::get('/envia_documento', 'App\Http\Controllers\Cash\ContificoApiController@envia_documento')->name('ContificoE.EnviaContifico');
    
    Route::get('/actualiza_documento', 'App\Http\Controllers\Cash\ContificoApiController@actualiza_documento')->name('ContificoA.ActualizaContifico');
    
    Route::get('/regenera_documento', 'App\Http\Controllers\Cash\ContificoApiController@regenera_documento')->name('ContificoR.RegeneraContifico');
    
    
    
    Route::get('/fetch-data', 'App\Http\Controllers\Contifico\ContificoController@fetchData');
});

if (Auth::check()) {
    // Si el usuario está autenticado, usa POST para cerrar sesión
    Route::post('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
} else {
    // Si el usuario no está autenticado, usa GET para cerrar sesión
    Route::get('logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
}


    Route::resource('life', 'App\Http\Controllers\Life\LifeController')->names('Life');
    Route::get('life-generate-link', 'App\Http\Controllers\Life\LifeController@generaLink')->name('Life.generateLink');

    
    Route::get('life-enroller', 'App\Http\Controllers\Life\LifeController@enroller')->name('Life.Enroller');
    Route::post('/life-genera-codigo', 'App\Http\Controllers\Life\LifeController@generateCodeEnroller')->name('Life.generateCodeEnroller');
    
    
    


//Route::post('/notificacion-pago', 'App\Http\Controllers\Pasarela\PagoController@notificacionPago')->name('notificacion.pago');

use App\Http\Controllers\Pasarela\BotonPagosController;
Route::middleware('web')->match(['get', 'post'],'/pagomedios2/', [BotonPagosController::class, 'pagomediosCobros'])
    ->name('PagoMedios.cobros')
    ->withoutMiddleware(['auth']);

Route::post('/pagomedios', 'App\Http\Controllers\PagoMediosController@metodo');



Route::get('/link', 'App\Http\Controllers\Fyl\EnrollerController@link')->name('Enroller.link');
Route::post('/filter-participants', 'App\Http\Controllers\Fyl\EnrollerController@filter')->name('filter-participants');
Route::get('listas/lifeEnroller/{trainingId}', 'App\Http\Controllers\Fyl\ListasController@lifeEnroller');

Route::get('/generate/focus', 'App\Http\Controllers\Fyl\EnrollerController@generate')->name('Enroller.register');
Route::get('/inscription/focus', 'App\Http\Controllers\Fyl\EnrollerController@inscription')->name('Inscription.inscription');
Route::get('/inscriptionL/focus', 'App\Http\Controllers\Fyl\EnrollerController@inscriptionL')->name('InscriptionL.inscriptionL');
Route::post('/register/focus', 'App\Http\Controllers\Fyl\EnrollerController@register')->name('Register.register');
Route::get('/registerRezagado/focus', 'App\Http\Controllers\Fyl\EnrollerController@registerRezagado')->name('Register.registerRezagado');
Route::get('/registerchange/name', 'App\Http\Controllers\Fyl\EnrollerController@registerNameChange')->name('RegisterNCH.registerNameChange');
Route::post('/procesar-formulario', 'App\Http\Controllers\Fyl\EnrollerController@form')->name('Process.form');
Route::post('/procesar-change', 'App\Http\Controllers\Fyl\EnrollerController@formChange')->name('ProcessCH.formChange');
Route::post('/procesar-formulario-r', 'App\Http\Controllers\Fyl\EnrollerController@formRezagado')->name('ProcessR.formRezagado');

//Route::post('logout', 'App\Http\Controllers\Auth\AuthenticatedSessionController@destroy')->name('logout');


require __DIR__ . '/auth.php';
