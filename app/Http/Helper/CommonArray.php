<?php
namespace App\Http\Helper;

class CommonArray{
    public static function messages($key)
    {
       $array=[
                   'CountryNameRequired' => 'Country name is required.',
                   'CountryCodeRequired' => 'Country code is required.',
                   'CountryStatusRequired' => 'Status of country is required.',
                   'CountryDelConfirmation' => 'Are you sure you want to delete the country?',
                   'ZoneCountryRequired' => 'Please select country of your zone.',
                   'ZoneNameRequired' => 'Zone name is required.',
                   'PostCodeRequired' => 'Zipcode of your is required.',
                   'ZoneStatusRequired' => 'Status of your zone is required.',
                   'ZoneDelConfirmation' => 'Are you sure you want to delete the zone?',

       ];

        return $array[$key];

    }
}
?>