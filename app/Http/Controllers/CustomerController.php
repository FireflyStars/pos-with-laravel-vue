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
            'contactTypes' => DB::table('contact_type')->select('id as value', 'name as display')->orderBy('id')->get(),
        ]);
    }

    /**
     * 
     */
    public function storeCustomer(Request $request){
        $validator = Validator::make($request->all(), [
            'customerNaf'       => 'required',
            'customerStatus'    => 'required',
            'email'             => $request->email != '' ? 'email' : '',
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
                'gender'                => $request->gender,
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
            $customerID = DB::table('customers')->insertGetId($customer);
            foreach ($request->addresses as $address) {
                $newAddress = [
                    'address_type_id'       => $address['addressType'],
                    'country_id'            => 1, // france
                    'customer_id'           => $customerID, // france
                    'alias'                 => $address['alias'],
                    'company'               => $customer['company'],
                    'lastname'              => $request->lastName,
                    'gender'                => $customer['gender'],
                    'firstname'             => $request->firstName,
                    'address1'              => $address['address1'],
                    'address2'              => $address['address2'],
                    'address3'              => $address['address3'],
                    'postcode'              => $address['postCode'],
                    'city'                  => $address['city'],
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ];
                $addressID = DB::table('addresses')->insertGetId($newAddress);
            }

            foreach ($request->contacts as $contact) {
                $newContact = [
                    'contact_type_id'       => $contact['type'],
                    'customer_id'           => $customerID,
                    'address_id'            => $addressID,
                    'num_contact_gx'        => $contact['numGx'],
                    'name'                  => $contact['name'],
                    'firstname'             => $contact['firstName'],
                    'gender'                => $contact['gender'],
                    'email'                 => $contact['email'],
                    'mobile'                => $contact['phoneCountryCode1'].'|'.$contact['phoneNumber1'],
                    'telephone'             => $contact['phoneCountryCode2'].'|'.$contact['phoneNumber2'],
                    'type'                  => 'Suspect',
                    'comment'               => $contact['note'],
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ];
                DB::table('contacts')->insert($newContact);
            }
        }
        return response()->json(['success'=> true]);
    }
}
