<?php

namespace App\Controller;

use App\Entity\Api;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    /**
     * @Route("getweather/{lat}/{log}")
     */
    public function getDataAction($lat, $log)
    {

        //get data from service by using API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'api.openweathermap.org/data/2.5/weather?lat=' . $lat .
            '&lon=' . $log . '&units=metric&lang=' . $this->getParameter('app.openweathermap_lang') .
            '&appid=' . $this->getParameter('app.openweathermap_api'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response_api = curl_exec($ch);

        //get status requesting data
        $info = curl_getinfo($ch);

        //Convert JSON to Array
        $data = json_decode($response_api, true);

        if (!curl_errno($ch) && $info['http_code'] == 200) {
            $date = new \DateTime();

            //if the country is missing, for example, if you have coordinates on Sea places or Ocean places
            if (!isset($data['sys']['country'])) {
                $data['sys']['country'] = 'No country';
                $data['name'] = 'No city';
            }

            //add entries to database
            $entityManager = $this->getDoctrine()->getManager();
            $api = new Api();
            $api->setLat($data['coord']['lat']);
            $api->setLog($data['coord']['lon']);
            $api->setCity($data['name']);
            $api->setTime($date->setTimestamp($data['dt']));
            $api->setCurtemp($data['main']['temp']);
            $api->setMaxtemp($data['main']['temp_max']);
            $api->setMintemp($data['main']['temp_min']);
            $api->setCountry($data['sys']['country']);
            $api->setWind(str_replace('=', ': ', http_build_query($data['wind'], null, ', ')));
            $api->setDescription($data['weather'][0]['description']);

            // tells Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($api);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            //prepare new template of modal for JSON
            $template = $this->get('twig')->render('Api/get_data.html.twig', $data);

            //return JSON response for JS handling
            return new JsonResponse(
                array(
                    'status' => true,
                    'response' => $template
                )
            );
        } else {
            //if you no any data from API
            return new JsonResponse(array(
                'status' => false,
                'response' => $data
                ));
        }
    }

}