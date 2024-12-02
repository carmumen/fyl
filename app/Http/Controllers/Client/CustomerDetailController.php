<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Client\SaveCustomerDetailRequest;
use App\Models\Catalog\Catalog;
use App\Models\Client\CustomerDetail;
use Illuminate\Http\Request;
use Exception;

class CustomerDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }

    public function index()
    {
        $customerDetails = CustomerDetail::from('client_customer_details AS CD')
                            ->leftjoin('client_clients AS C', 'C.id', '=', 'CD.client_id')
                            ->leftjoin('global_countries as COU', 'COU.id', '=', 'CD.country_id')
                            ->leftjoin('global_provinces as PRO', 'PRO.id', '=', 'CD.province_id')
                            ->leftjoin('global_cantons as CAN', 'CAN.id', '=', 'CD.canton_id')
                            ->leftjoin('global_cities as CIU', 'CIU.id', '=', 'CD.city_id')
                            ->select('C.DNI',
                                    'C.names',
                                    'C.surnames',
                                    'C.birthdate',
                                    'C.gender_catalog_id',
                                    'C.civil_status_catalog_id',
                                    'C.address',
                                    'C.status')
                            ->groupby('C.DNI','C.names','C.surnames','C.birthdate','C.gender_catalog_id','C.civil_status_catalog_id','C.address','C.status')
                            ->orderBy('C.surnames','asc')
                            ->orderBy('C.names', 'asc')
                            ->paginate(10);
                           
        return view('client/customerDetails/index',['customerDetail' => $customerDetails]);
    }
    
    public function create()
    {
        return view('client/customerDetails/create', [
            'customerDetail' => new CustomerDetail,
            'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
            'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),
            'education_level' => Catalog::where('catalog_types_id',3)->pluck('name','id')
        ]);
    }

    public function store(SaveCustomerDetailRequest $request)
    {
        try {

            CustomerDetail::create($request->validated());

            return to_route('CustomerDetails.index')->with('status','CustomerDetail create!');
            
        } catch (Exception $e) {
            return to_route('CustomerDetails.index')->with('errors','Error. Imposible registrar, verifique que el cliente no se encuentre registrado.');
        }
        
    }
    
    public function show(Client $customerDetail)
    {
        return view('client/customerDetails/show',['customerDetail' => $customerDetail]);
    }

    public function edit($id)
    {
        $customerDetail = CustomerDetail::findOrFail($id);

        return view('client/customerDetails/edit',[
            'customerDetail' => $customerDetail,
            'gender' => Catalog::where('catalog_types_id',1)->pluck('name','id'),
            'civil_status' => Catalog::where('catalog_types_id',2)->pluck('name','id'),
            'education_level' => Catalog::where('catalog_types_id',3)->pluck('name','id')
        ]);
    }
    
    public function update(SaveCustomerDetailRequest $request, $id)
    {
        try {
            $customerDetail = CustomerDetail::findOrFail($id);
            $customerDetail->update($request->validated());

            return to_route('CustomerDetails.index', $customerDetail)->with('status','CustomerDetail updated!');

        } catch (Exception $e) {
            return to_route('EmployeeOccupations.index')->with('errors','Error. Imposible actualizar, verifique que el cliente no se encuentre registrado.');
        }
    }
    
    public function destroy( $id)
    {
        try {
            $customerDetail = CustomerDetail::findOrFail($id);
            $customerDetail->delete();

        } catch (Exception $e) {
            return to_route('CustomerDetails.index')->with('errors','Detalle de Cliente no puede ser eliminado.');
        }
        return to_route('CustomerDetails.index')->with('status','CustomerDetail deleted!');
    }


    public function findClient($parametro){
        return CustomerDetail::from('client_clients AS E')
        ->select( 'E.id',
                  DB::raw("(CONCAT(E.surnames,' ',E.names)) as label"))
        ->where('surnames','LIKE', '%'.$parametro.'%')->get();
    }

    
}
