<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Customer;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class EmailingController extends Controller
{

    public function __construct() {}

    
    /**
     * Get customers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCustomer()
    {
        $customer = Customer::get();
        if($customer) {
            return response()->json([
                'Customer' => $customer
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get customers'
            ], 400);
        }

    }
    
    /**
     * Get customers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContacts()
    {
        $contacts = Contact::get();
        if($contacts) {
            return response()->json([
                'contacts' => $contacts
            ]);
        }else {
            return response()->json([
                'error' => 'error 400 : can\'t get customers'
            ], 400);
        }

    }
}
    