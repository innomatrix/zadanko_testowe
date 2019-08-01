<?php

namespace App\Controller;

use App\Entity\Api;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    /**
     * @Route("getweather/{lat}/{log}/{persist}"), defaults={"persist"=1}
     */
    public function getDataAction($lat, $log, $persist)
    {

        //get data from service by using API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'api.openweathermap.org/data/2.5/weather?lat=' . $lat .
            '&lon=' . $log . '&units=metric&lang=' . $this->getParameter('app.openweathermap_lang') .
            '&appid=' . $this->getParameter('app.openweathermap_api'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response_api = curl_exec($ch);

        $data = null;

        $info = curl_getinfo($ch);

        if (!curl_errno($ch) && $info['http_code'] == 200) {
            $date = new \DateTime();

            $data = json_decode($response_api, true);

            if (!isset($data['sys']['country'])) {
                $data['sys']['country'] = 'No country';
                $data['name'] = 'No city';
            }

            if((bool) $persist) {
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

                $entityManager->persist($api);

                $entityManager->flush();
            }

            // $template = $this->get('twig')->render('Api/get_data.html.twig', $data);

            return new JsonResponse(
                array(
                    'status' => true,
                    'response' => $data
                )
            );
        } else {
            return new JsonResponse(array(
                'status' => false,
                'response' => $data
                ));
        }
    }

}