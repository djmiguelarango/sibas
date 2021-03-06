<?php

namespace Sibas\Entities;

use Illuminate\Database\Eloquent\Model;
use Sibas\Entities\Vi\Detail as DetailVi;
use Sibas\Entities\De\Detail as DetailDe;

class Client extends Model
{

    protected $table = 'op_clients';

    public $incrementing = false;

    protected $appends = [
        'full_name',
    ];


    public function detailsDe()
    {
        return $this->hasMany(DetailDe::class, 'op_client_id', 'id');
    }


    public function detailsVi()
    {
        return $this->hasMany(DetailVi::class, 'op_client_id', 'id');
    }


    public function activity()
    {
        return $this->belongsTo(Activity::class, 'ad_activity_id', 'id');
    }


    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . $this->mother_last_name;
    }


    public function getImcAttribute()
    {
        $imc = false;

        $result = ceil($this->weight / ( ( $this->height / 100 ) * ( $this->height / 100 ) ));

        if ($result < 18) {
            $imc = true;
        } elseif (( $result >= 18 ) and ( $result <= 24 )) {
            $imc = false;
        } elseif (( $result >= 25 ) and ( $result <= 29 )) {
            $imc = false;
        } elseif (( $result >= 30 ) and ( $result <= 39 )) {
            $imc = true;
        } elseif ($result >= 40) {
            $imc = true;
        }

        return $imc;
    }


    public function getImcStatusAttribute()
    {
        $imc = '';

        $result = ceil($this->weight / ( ( $this->height / 100 ) * ( $this->height / 100 ) ));

        if ($result < 18) {
            $imc = 'Desnutricion';
        } elseif (( $result >= 18 ) and ( $result <= 24 )) {
            $imc = 'Saludable';
        } elseif (( $result >= 25 ) and ( $result <= 29 )) {
            $imc = 'Sobrepeso aceptable';
        } elseif (( $result >= 30 ) and ( $result <= 39 )) {
            $imc = 'Obeso';
        } elseif ($result >= 40) {
            $imc = 'Obesidad morbida';
        }

        return $imc;

    }


    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = mb_strtoupper($value);
    }


    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = mb_strtoupper($value);
    }


    public function setMotherLastNameAttribute($value)
    {
        $this->attributes['mother_last_name'] = mb_strtoupper($value);
    }


    public function setMarriedNameAttribute($value)
    {
        $this->attributes['married_name'] = mb_strtoupper($value);
    }


    public function setBirthPlaceAttribute($value)
    {
        $this->attributes['birth_place'] = mb_strtoupper($value);
    }


    public function setComplementAttribute($value)
    {
        $this->attributes['complement'] = strtoupper($value);
    }


    public function setLocalityAttribute($value)
    {
        $this->attributes['locality'] = mb_strtoupper($value);
    }


    public function setHomeAddressAttribute($value)
    {
        $this->attributes['home_address'] = mb_strtoupper($value);
    }


    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = mb_strtoupper($value);
    }


    public function setOccupationDescriptionAttribute($value)
    {
        $this->attributes['occupation_description'] = mb_strtoupper($value);
    }


    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }


    public function setBusinessAddressAttribute($value)
    {
        $this->attributes['business_address'] = strtoupper($value);
    }
    
}
