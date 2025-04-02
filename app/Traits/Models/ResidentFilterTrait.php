<?php

namespace App\Traits\Models;

trait ResidentFilterTrait
{
   /**
         * 
         *  Adiciona uma condição de 'where' para filtrar registros pelo residente autenticado
         * 
         * @return self
         */
    
    public function whereResident(): self 
    {
        
        if(auth()->user()->inGroup('user')){
            $this->where("{$this->table}.resident_id", auth()->user()-> resident_id);
        }
        return $this;
    }   
   
     
}