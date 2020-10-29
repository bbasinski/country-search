<?php


namespace App\Controller;


use App\Library\CountryInfoSoap;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CountriesController extends AbstractController
{
    /**
     * @Route("/countries")
     */
    public function getCountries(Request $request, CountryInfoSoap $countryInfoSoap)
    {
        $query = $request->get('q');
        $countries = $countryInfoSoap->fetchCountries(); //todo cache

        if (!empty($query)) {
            $countries = array_values(
                array_filter($countries, function(\stdClass $object) use ($query) {
                    return stripos($object->sName, $query) !== false;
                })
            );
        }

        return new JsonResponse([
            'countries' => $countries
        ]);
    }
}
