<?php

namespace App\Entity;

trait Updatable
{
    public function updateFromArray(array $data): array
    {
        $resultat=[];
        $error=[];
        $modif=[];
        
        foreach($data as $property => $value){
            if(property_exists($this,$property)){
                if($this->{$property} === $value){
                    $error[] = ["Valeur déjà initialisé"=>[$property,$value]];
                }else{
                    $this->{$property} = $value;
                    $modif[] = [$property,$value];
                }
            }else{
                $error[] = ["Propriété inexistantes"=>[]];
                //$doublon = $error["Propriété inexistantes"];
                //array_push($doublon,[$property,$value]);
            }
        }
        $resultat[]=['Erreur'=>$error, 'Modification'=>$modif];

        return $resultat;
    }
}