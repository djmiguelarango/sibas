<?php

namespace Sibas\Http\Requests\Client;

use Sibas\Http\Requests\Request;

class ClientQuoteFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $civil_status   = join(',', array_keys(\Config::get('base.client_civil_status')));
        $document_types = join(',', array_keys(\Config::get('base.client_document_types')));
        $genders        = join(',', array_keys(\Config::get('base.client_genders')));

        return [
            'first_name'        => 'required|alpha_space',
            'last_name'         => 'required|alpha_space',
            'mother_last_name'  => 'required|alpha_space',
            'married_name'      => 'alpha_space',
            'civil_status'      => 'required|in:' . $civil_status,
            'document_type'     => 'required|in:' . $document_types,
            'dni'               => 'required|alpha_dash',
            'complement'        => 'alpha',
            'extension'         => 'required|exists:ad_cities,abbreviation',
            'country'           => 'required|alpha_space',
            'birthdate'         => 'required|date',
            'birth_place'       => 'required|alpha_dash_space',
            'place_residence'   => 'required|exists:ad_cities,slug',
            'locality'          => 'required|alpha_dash_space',
            'home_address'      => 'required|ands_full',
            'ad_activity_id'    => 'required|exists:ad_activities,id',
            'occupation_description' => 'required|ands_full',
            'phone_number_home'      => 'required|numeric|digits_between:7,8',
            'phone_number_mobile'    => 'numeric|digits_between:7,8',
            'phone_number_office'    => 'numeric|digits_between:7,8',
            'email'             => 'email',
            'weight'            => 'required|numeric|min:1|digits_between:1,3',
            'height'            => 'required|numeric|min:1|digits_between:1,3',
            'gender'            => 'required|in:' . $genders
        ];
    }
}