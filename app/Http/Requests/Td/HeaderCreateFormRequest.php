<?php

namespace Sibas\Http\Requests\Td;

use Sibas\Http\Requests\Request;

class HeaderCreateFormRequest extends Request
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
        $genders    = join(',', array_keys(config('base.client_genders')));
        $term_types = join(',', array_keys(config('base.term_types')));
        $currencies = join(',', array_keys(config('base.currencies')));

        return [
            'first_name'             => 'required|alpha_space',
            'locality'               => 'alpha_space',
            'last_name'              => 'required|alpha_space',
            'mother_last_name'       => 'alpha_space',
            'married_name'           => 'alpha_space',
            'dni'                    => 'required|numeric',
            'phone_number_office'    => 'numeric',
            'complement'             => 'alpha',
            'extension'              => 'required|exists:ad_cities,abbreviation',
            'gender'                 => 'required|in:' . $genders,
            'birthdate'              => 'required|date_format:d/m/Y',
            'ad_activity_id'         => 'required|exists:ad_activities,id',
            'occupation_description' => 'required|ands_full',
            'avenue_street'          => 'required|ands_full',
            'home_address'           => 'required|ands_full',
            'home_number'            => 'required|ands_full',
            'phone_number_home'      => 'required|numeric|digits_between:7,8',
            'phone_number_mobile'    => 'numeric|digits_between:7,8',
            'email'                  => 'email',

            'number_de'      => 'exists:op_de_headers,id',
            'warranty'       => 'required|integer|in:1,0',
            'validity_start' => 'required|date_format:d/m/Y',
            'term'           => 'required|integer|min:1',
            'type_term'      => 'required|in:' . $term_types,
            'currency'       => 'required|in:' . $currencies,
        ];
    }
}