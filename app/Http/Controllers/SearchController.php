<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public $limit = 3;

    public function search(Request $request) 
    {
        
        $customers = $this->customers($request);

        $contacts = $this->contacts($request);

        $orders = $this->orders($request);

        $events = $this->events($request);
          
        return response()->json(
            compact('customers', 'contacts', 'orders', 'events')
        );          

    }

    public function customers(Request $request) 
    {
        $customers = Customer::query();
        return $customers->select('customers.id as customer_id', 'customers.name as customer_name', 'customers.company', 'customers.email', 'customers.telephone', 'customers.raisonsociale', 
        'customers.raisonsociale2', 'customer_statut.name as statut_name', 'customer_statut.color as statut_color')
                    ->join('customer_statut', 'customer_statut.id', '=', 'customers.customer_statut_id')
                    ->where('customers.name', 'LIKE', "%{$request->search}%")
                    ->orWhere('company', 'LIKE', "%{$request->search}%")
                    ->orWhere('raisonsociale', 'LIke', "%$request->search%")
                    ->take($this->limit)
                    ->skip($this->limit * $request->skip ?? 0)
                    ->get();
    }

    public function contacts(Request $request) 
    {
        $contacts = Contact::query();   
        return $contacts->select('contacts.id as contact_id', 'contacts.firstname', 'contacts.name', 'contacts.mobile', 'contacts.email', 'contact_type.color as contact_color', 'contact_type.name as contact_name')
                    ->join('contact_type', 'contacts.contact_type_id', '=', 'contact_type.id')
                    ->where('contacts.name', 'LIKE', "%{$request->search}%")
                    ->orWhere('firstname', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIke', "%$request->search%")
                    ->limit($this->limit)
                    ->skip($this->limit * $request->skip ?? 0)
                    ->get();
    }


    public function orders(Request $request) 
    {
        $orders = Order::query();
        return $orders->select('orders.id as order_id', 'orders.nbheure', 'orders.datecommande', 'orders.total', 'order_states.name as states_name', 'order_states.color as states_color','customers.company', 'addresses.firstname', 'addresses.address1', 'addresses.address2', 'addresses.postcode', 'addresses.city', 'address_type.name as address_name')
                    ->join('order_states', 'order_states.id', '=', 'orders.order_state_id')
                    ->join('customers', 'customers.id', '=', 'orders.customer_id')
                    ->join('addresses', 'addresses.id', '=', 'orders.address_id')         
                    ->join('address_type', 'address_type.id', '=', 'addresses.address_type_id')
                    ->where('customers.company', 'LIKE', "%{$request->search}%")
                    ->orWhere('customers.raisonsociale', 'LIKE', "%{$request->search}%")
                    ->orWhere('addresses.postcode', 'LIKE', "%{$request->search}%")
                    ->orWhere('addresses.address1', 'LIKE', "%{$request->search}%")
                    ->orWhere('addresses.city', 'LIKE', "%{$request->search}%")
                    ->orWhere('orders.id', 'LIKE', "%{$request->search}%")
                    ->limit($this->limit)
                    ->skip($this->limit * $request->skip ?? 0)
                    ->get();   
    }

    public function events(Request $request) 
    {
        $events = Event::query();
        return $events->select('events.id as event_id', 'events.name as event_name', 'events.datedebut', 'events.description', 'event_statuses.name as status_name', 'event_statuses.color as status_color', 'customers.company', 'customers.firstname', 'customers.name as customer_name', 'addresses.address1')
                    ->join('event_statuses', 'event_statuses.id', '=', 'events.event_status_id')
                    ->join('customers', 'customers.id', '=', 'events.customer_id')
                    ->join('addresses', 'addresses.id', '=', 'events.address_id')
                    ->where('customers.company', 'LIKE', "%{$request->search}%")
                    ->orWhere('customers.raisonsociale', 'LIKE', "%{$request->search}%")
                    ->orWhere('addresses.postcode', 'LIKE', "%{$request->search}%")
                    ->orWhere('addresses.address1', 'LIKE', "%{$request->search}%")
                    ->orWhere('addresses.city', 'LIKE', "%{$request->search}%")
                    ->orWhere('events.name', 'LIKE', "%{$request->search}%")
                    ->orWhere('events.description', 'LIKE', "%{$request->search}%")
                    ->orWhere('events.id', 'LIKE', "%{$request->search}%")
                    ->limit($this->limit)
                    ->skip($this->limit * $request->skip ?? 0)
                    ->get();
    }


    public function search_append(Request $request) 
    {
        $action = $request->action;
        return response()->json($this->$action($request));
    }

}
