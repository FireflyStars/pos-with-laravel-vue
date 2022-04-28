<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //
    public function geListInfoForCustomer(){
        return response()->json([
            'status'    => DB::table('customer_statut')->select('id as value', 'name as display')->orderBy('name')->get(),
            'types'     => DB::table('customer_categories')->select('id as value', 'name as display')->orderBy('name')->get(),
            'nafs'      => DB::table('customer_naf')->select('code as value', 'name as display')->orderBy('name')->get(),
            'taxs'      => DB::table('taxes')->select('taux as value', 'name as display')->orderBy('name')->get(),
            'addressTypes' => DB::table('address_type')->select('id as value', 'name as display')->orderBy('name')->get(),
            'contactTypes' => DB::table('address_type')->select('id as value', 'name as display')->orderBy('name')->get(),
        ]);
    }

    /**
     * 
     */
    public function storeCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'customerNaf'       => 'required',
            'customerStatus'    => 'required',
            'customerStatus'    => $request->email != '' ? 'required|email' : '',
            'customerTax'       => 'required'
        ]);
 
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->$validator->errors(), 'success'=> false]);
        }else{
            $customer = [
                'affiliate_id'          => auth()->user()->affiliate_id,
                'taxe_id'               => $request->customerTax,
                'customer_statut_id'    => $request->customerStatus,
                'customer_categories_id'=> $request->customerType,
                'naf'                   => $request->customerNaf,
                'naf'                   => $request->customerNaf,
                'siret'                 => $request->siret,
                'email'                 => $request->email,
                'telephone'             => $request->phoneCountryCode.'|'.$request->phoneNumber,
                'company'               => $request->company,
                'raisonsociale'         => $request->nomClient,
                'raisonsociale2'        => $request->nomClient2,
                'firstname'             => $request->firstName,
                'name'                  => $request->firstName.' '.$request->lastName,
                
                'libelleadresse'        => $request->address1,
                'libelleadresse'        => $request->address2,
                'centredistributeur'    => $request->address3,
                'codepostal'            => $request->postCode,

                'linkedin'              => $request->linkedin,
                'siteweb'               => $request->website,
                'litige'                => $request->litige,
                'active'                => $request->actif,
                'zpe'                   => $request->zpe,
                'environnement'         => $request->environment,
                'statutetablissement'   => $request->statusEtablissement,
                'statutetablissement'   => $request->statusEtablissement,
                'trancheca'             => $request->trancheCA,
                'trancheeffectif'       => $request->trancheEffectif,
                'tranchetaillecommune'  => $request->trancheCommune,
                'num_client_gx'         => $request->numLCDT,
                'datecreationetablissement'=> $request->dateCreated,
                'signupdate'            => now()->format('Y-m-d'),
                'created_at'            => now(),
                'updated_at'            => now(),
                
            ];
            DB::table('customers')->insert($customer);
            foreach ($request->addresses as $address) {
                $newAddress = [
                    'name'      => $customer['name'],
                    'gender'    => $customer['gender'],
                    ''
                ];
                DB::table('address')->insert($newAddress);
            }
        }
        return response()->json(['success'=> true]);
    }
}
