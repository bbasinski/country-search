<?php


namespace App\Library;

/**
 * @method ListOfCountryNamesByName
 * @method FullCountryInfo($params)
 * @method FullCountryInfoAllCountries
 * @method ListOfContinentsByCode($params)
 * @method ListOfCurrenciesByCode($params)
 */
class CountryInfoSoap extends \SoapClient
{
    const WSDL = 'http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL';

    public function __construct()
    {
        parent::__construct(self::WSDL);
    }

    public function fetchCountries()
    {
        return $this->ListOfCountryNamesByName()->ListOfCountryNamesByNameResult->tCountryCodeAndName;
    }
}
