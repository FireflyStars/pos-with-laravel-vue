<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntiteController extends Controller
{
    public function index(Request $request) 
    {
        $customer = Customer::query()
        ->select(
            'customers.id',
            'raisonsociale',
            'customers.firstname',
            'customers.name',
            'customers.email',
            'customers.telephone',
            'addresses.address1',
            'addresses.address2',
            'addresses.address3',
            'addresses.postcode',
            'addresses.city',
            'customers.origine',
            'customer_statut.name as statut',
            'customers.litige',
            DB::raw(
                'TRIM(
                    CONCAT(
                        customers.firstname, " " ,customers.name,
                        "<br>",
                        customers.email,
                        IF(customers.email, "<br>", ""),
                        customers.telephone
                    )
                ) 
            as contact'),
            DB::raw(
                'TRIM(
                    CONCAT(
                        addresses.address1,
                        "<br>",
                        IFNULL(addresses.address2, ""),
                        IF(addresses.address2, "<br>", ""),
                        IFNULL(addresses.address3, ""), 
                        IF(addresses.address3, "<br>", ""),
                        addresses.postcode,
                        "<br>", 
                        addresses.city
                    )
                ) 
            as address'),
            DB::raw('DATE_FORMAT(customers.created_at, "%Y-%m-%d") as created_at'),
            DB::raw('IFNULL(campagne_detail.qty, 0) as qty'),
            DB::raw('IFNULL(campagne_detail.price, 0) as price'),
            DB::raw('qty * price as montant')
        )
        ->join('addresses', 'addresses.customer_id', '=', 'customers.id')
        ->join('customer_statut', 'customer_statut.id', '=', 'customers.customer_statut_id')
        ->join('campagnes', 'campagnes.affiliate_id', '=', 'customers.affiliate_id')
        ->join('campagne_detail', 'campagne_detail.campagne_id', '=', 'campagnes.id')
        ->where('customers.affiliate_id', $request->user()->affiliate_id);

        $data = (new TableFiltersController)->sorts($request, $customer, 'customers.id');
        $data = (new TableFiltersController)->filters($request, $customer);

        $data = $customer
        ->take($request->take ?? 15)
        ->skip($request->skip ?? 0)
        ->groupBy('customers.id')
        ->get();

        return response()->json($data);

    }
}
