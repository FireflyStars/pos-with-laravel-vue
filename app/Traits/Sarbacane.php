<?php

namespace App\Traits;

use App\Models\Campagne;
use App\Models\CampagneCible;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;

trait Sarbacane
{
    

    public function sarbacane(){
       return $this;
    }

    public function post($path,$data=[]){
        return Http::withHeaders([
            'accountId'=>getenv('SARBACANE_ACCOUNT_ID'),
            'apiKey'=> getenv('SARBACANE_APIKEY')
       ])->post(getenv('SARBACANE_APIURL').$path,$data);
    }

    public function addCampagneFieldsAndContacts($id_list,$campagne_id,$testcontacts=array()){
        $campagne=Campagne::find($campagne_id);
        $affiliate=$campagne->affiliate;
        $campagneCibles=CampagneCible::where('campagne_id','=',$campagne_id)->get();

        //Permet d'ajouter un champ (une colonne) à une liste.
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Nom_agence']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Telephone_agence']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Email_agence']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Prenom_dirigeant']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Nom_dirigeant' ]);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Email_dirigeant']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Adresse_agence']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'CP_agence']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Ville_agence']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Portable_dirigeant']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Page_agence']);
        $this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Linkedin_agence']);
        $f_nom_client=$this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Nom_client']);
        $f_genre_contact=$this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Genre_contact']);
        $f_prenom_contact=$this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Prenom_contact']);
        $f_nom_contact=$this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Nom_contact']);
        $f_nom_contact=$this->sarbacane()->post('lists/'.$id_list.'/fields', [ "kind" => 'STRING',"caption" => 'Email_contact']);
        if(empty($testcontacts)){
        foreach ($campagneCibles as $cible){
            $customer=$cible->customer;
          
            $contact=$cible->contact;
            //Permet d'ajouter un contact à une liste.
            $this->sarbacane()->post('lists/'.$id_list.'/contacts', 
                array(
                    "email" => $cible->email,
                    "Nom_agence" => $affiliate->name,
                    "Telephone_agence" => $campagne->phone,
                    "Email_agence" => $campagne->email,
                    "Prenom_dirigeant"=>$affiliate->firstnamedirector,
                    "Nom_dirigeant"=>$affiliate->namedirector,
                    "Email_dirigeant"=>$affiliate->email,
                    "Portable_dirigeant"=>$affiliate->mobile,
                    "Adresse_agence"=>$affiliate->address.' '.$affiliate->address2,
                    "CP_agence"=>$affiliate->postcod,
                    "Ville_agence"=>$affiliate->city,
                    "Page_agence"=>$affiliate->urlagence,
                    "Linkedin_agence"=>$affiliate->linkedin,
                    "Nom_client"=>$customer!=null?$customer->name:$cible->name,
                    "Genre_contact"=>$contact->gender,
                    "Prenom_contact"=>$contact!=null?$contact->firstname:'',
                    "Nom_contact"=>$contact!=null?$contact->name:'',
                    "Email_contact" => $contact!=null?$contact->email:'',
                   
                )
            );
        }
    }else{
     
            foreach($testcontacts as $contact){
      
                $this->sarbacane()->post('lists/'.$id_list.'/contacts', 
                array(
                    "email" =>$contact['email'],
                    "Nom_agence" => $affiliate->name,
                    "Telephone_agence" => $campagne->phone,
                    "Email_agence" => $campagne->email,
                    "Prenom_dirigeant"=>$affiliate->firstnamedirector,
                    "Nom_dirigeant"=>$affiliate->namedirector,
                    "Email_dirigeant"=>$affiliate->email,
                    "Portable_dirigeant"=>$affiliate->mobile,
                    "Adresse_agence"=>$affiliate->address.' '.$affiliate->address2,
                    "CP_agence"=>$affiliate->postcod,
                    "Ville_agence"=>$affiliate->city,
                    "Page_agence"=>$affiliate->urlagence,
                    "Linkedin_agence"=>$affiliate->linkedin,
                    "Nom_client"=>'TESTCLIENT',
                    "Genre_contact"=>'Mr',
                    "Prenom_contact"=>'TESTPRENOM',
                    "Nom_contact"=>'TESTNOM',
                    "Email_contact" => 'TESTEMAIL',
                
                )
            );
        }
        
    }

    }

}
