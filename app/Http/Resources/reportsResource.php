<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class reportsResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'lang_id' => $this->lang_id,
            'affiliate_id' => $this->affiliate_id,
            'customer' => [
                'id' => $this->customer->id,
                'taxe_id' => $this->customer->taxe_id,
                'customer_group_id' => $this->customer->customer_group_id,
                'gender' => $this->customer->gender,
                'name' => $this->customer->name,
                'firstname' => $this->customer->firstname,
                'company' => $this->customer->company,
                'signupdate' => $this->customer->signupdate,
                'active' => $this->customer->active,
                'address' => $this->get_customer_address($this->customer)
            ],
            'orderZones' => $this->get_order_zones($this->orderZones),
            'orderZoneComments' => $this->get_order_zone_comments($this->orderZones),
            'orderOuvrages' => $this->get_order_ouvrages($this->orderZones)
        ];
    }

    private function get_customer_address($customer) 
    {
        $customer_address = $customer?->addresses;
        if($customer_address->count()) 
        {
            return $customer_address->first()->only([
                'address1',
                'address2',
                'postcode',
                'city',
                'other',
                'phone',
                'phone_mobile',
                'vat_number',
                'dni',
                'active'
            ]);
        }
    }

    private function get_order_ouvrages($zones) 
    {
        $order_categories = $this->get_order_categories($zones);
        $foramtted_ouvrages = new Collection;
        foreach($order_categories as $category) 
        {
            $foramtted_ouvrages[$category->name] = $this->get_zone_ouvrages($zones, $category->id);
        }
        return $foramtted_ouvrages;
    }

    private function get_zone_ouvrages($zones, $id) 
    {
        $ouvrages = new Collection;
        foreach($zones as $zone) 
        {
            foreach($zone->orderOuvrage as $ouvrage) 
            {
                $ouvrages []= $ouvrage;
            }
        }
        return $ouvrages->where('order_cat_id', $id)
        ->filter()
        ->map(function($ouvrage) { 
            return [
                'id'   => $ouvrage->id,
                'type' => $ouvrage->type,
                'name' => $ouvrage->name
            ];
        });
    }


    private function get_order_zone_comments($orderZones) 
    {
        $formatted_orderzone_comments = [];
        $orderZoneComments = $orderZones
                ->map(function($item) { return $item->orderZoneComments; })
                ->filter(function($item) { return $item->isNotEmpty(); });
        
        foreach($orderZoneComments as $comments) 
        {
            foreach($comments as $comment) 
            {
                $formatted_orderzone_comments []= $comment;
            }
        }

        return $formatted_orderzone_comments;        
                
    }   

    private function get_order_zones($orderZones) 
    {
        return $orderZones->map(function($zone) {  
            return [
                'id' => $zone->id,
                'latitude' => $zone->latitude,
                'longitude' => $zone->longitude,
                'description' => $zone->description,
                'hauteur' => $zone->hauteur,
                'name' => $zone->name,
                'moyenacces' => $zone->moyenacces,
                'gedDetails' => $this->get_formatted_ged_details($zone->gedDetails),
            ];
        });
    }

    private function get_formatted_ged_details($details) 
    {
        
        $formatted_details = new Collection;
        $categories = $this->get_ged_categories($details);
        
        foreach($categories as $category) 
        {
            $category_name = $category['name'];
            $category_id = $category['id'];
            $formatted_details[$category_name] = $this->get_category_ged_details($details, $category_id);
        }

        return $formatted_details;

    }

    private function get_category_ged_details($details, $id) 
    {
        return $details
        ->where('ged_category_id', $id)
        ->map(function($detail) { 
            return [
                'id' => $detail->id,
                'ged_id' => $detail->ged_id,
                'order_zone_id' => $detail->order_zone_id,
                'order_ouvrage_id' => $detail->order_ouvrage_id,
                'user_id' => $detail->user_id,
                'description' => $detail->description,
                'file' => $detail->file,
                'human_readable_filename' => $detail->human_readable_filename,
                'storage_path' => $detail->storage_path,
                'type' => $detail->type,
                'longitude' => $detail->longitude,
                'latitude' => $detail->latitude,
                'timeline' => $detail->timeline,
            ];
        });
    }

    private function get_order_categories($zones) 
    {
        $ouvrage_categories = new Collection;
        $order_ouvrages = $zones->map(function($zone) { return $zone->orderOuvrage; });
        foreach($order_ouvrages as $ouvrages) 
        {
            foreach($ouvrages as $ouvrage) 
            {
                $ouvrage_categories []= $ouvrage->orderCategory;
            }
        }
        return $ouvrage_categories;
    }

    private function get_ged_categories($ged_details) 
    {
        return $ged_details
        ->map(function($item) { return $item->gedCategory; })
        ->filter(function($item) { return !is_null($item); })
        ->map(function($item) { 
            return [
                'id' => $item->id,
                'name' => $item->name
            ];
        });
    }

}
