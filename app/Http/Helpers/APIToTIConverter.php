<?php

namespace App\Http\Helpers;

final class APIToTIConverter
{
    /**
     * @param string $responseString response sent from BlackBook
     * @param int    $realm_id       realm_id sent from client
     * @return array
     */
    public static function convertBlackBookPowerSportsToDto(string $responseString)
    {
        $response = json_decode($responseString, true);
        $vehicles_list = $response['powersports_vehicles']['powersports_vehicle_list'];
        if (empty($vehicles_list)) {
            return [];
        }

        return [
            'vin' => $vehicles_list[0]['vin'],
            'model_year' => $vehicles_list[0]['model_year'],
            'make' => $vehicles_list[0]['make'],
            'model' => $vehicles_list[0]['model'],
            'class_name' => $vehicles_list[0]['class_name'],
            'whole_avg' => $vehicles_list[0]['whole_avg'],
            'retail_avg' => $vehicles_list[0]['retail_avg'],
            'tradein_clean' => $vehicles_list[0]['tradein_clean'],
            'tradein_fair' => $vehicles_list[0]['tradein_fair'],
            'finadv' => $vehicles_list[0]['finadv'],
            'msrp' => $vehicles_list[0]['msrp'],
        ];
    }

    /**
     * @param string $responseString response sent from BlackBook
     * @param int    $realm_id       realm_id sent from client
     * @return array
     */
    public static function convertBlackBookRvToDto(string $responseString)
    {
        $response = json_decode($responseString, true);
        $vehicles_list = $response['rv_vehicles']['rv_vehicle_list'];
        if (empty($vehicles_list)) {
            return [];
        }

        return [
            'uvc' => $vehicles_list[0]['uvc'],
            'model_year' => $vehicles_list[0]['model_year'],
            'make' => $vehicles_list[0]['make'],
            'model' => $vehicles_list[0]['model'],
            'style' => $vehicles_list[0]['style'],
            'class_name' => $vehicles_list[0]['class_name'],
            'whole_avg' => $vehicles_list[0]['whole_avg'],
            'retail_avg' => $vehicles_list[0]['retail_avg'],
            'whole_clean' => $vehicles_list[0]['whole_clean'],
            'finadv' => $vehicles_list[0]['finadv'],
            'msrp' => $vehicles_list[0]['msrp'],
        ];
    }
}