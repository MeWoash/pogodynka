<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        WeatherUtil $util,
        #[MapQueryParameter('country')] string $country,
        #[MapQueryParameter('city')] string $city,
        #[MapQueryParameter('format')] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {

        $measurements = $util->getWeatherForCountryAndCity($country, $city);

        if ($format === 'csv') {
            if ($twig) {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }
            else
            {
                $csv = "city,country,date,temp,wind,humidity,atm,fahrenheit\n";
                $csv .= implode(
                    "\n",
                    array_map(fn(Measurement $m) => sprintf(
                        '%s,%s,%s,%s,%s,%s,%s,%s',
                        $city,
                        $country,
                        $m->getDateOfMeasurement()->format('Y-m-d'),
                        $m->getTemperature(),
                        $m->getWindSpeed(),
                        $m->getHumidity(),
                        $m->getAtmPressure(),
                        $m->getFahrenheit(),
                    ), $measurements)
                );

                return new Response($csv, 200, [
                ]);
            }

        }
        else if ($format === 'json')
        {
            if ($twig) {
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }
            else {
                return $this->json([
                    'city' => $city,
                    'country' => $country,
                    'measurements' => array_map(fn(Measurement $m) => [
                        'date' => $m->getDateOfMeasurement()->format('Y-m-d'),
                        'temp' => $m->getTemperature(),
                        'wind' => $m->getWindSpeed(),
                        'humidity'=>$m->getHumidity(),
                        'atm'=>$m->getAtmPressure(),
                        'fahrenheit' => $m->getFahrenheit(),
                    ], $measurements),
                ]);
            }
        }
        return new Response("Wrong Arguments", 200, []);

    }
}
