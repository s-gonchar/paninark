<?php

namespace App\Service;

use App\Entity\Person;
use GuzzleHttp\Client;


class PassportCloudService
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function fillGeneratedValue(Person $person): Person
    {
        $headers = array(
            'Connection' => 'keep-alive',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-cache',
            'sec-ch-ua' => '" Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"',
            'X-CSRF-TOKEN' => 'NjiROcVv4vjF648eE2EhUdoLl5EYwxfKSCDbxGPC',
            'sec-ch-ua-mobile' => '?0',
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36',
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
            'Accept' => '*/*',
            'X-Requested-With' => 'XMLHttpRequest',
            'sec-ch-ua-platform' => '"Linux"',
            'Origin' => 'https://passport-cloud.ru',
            'Sec-Fetch-Site' => 'same-origin',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Dest' => 'empty',
            'Referer' => 'https://passport-cloud.ru/generator',
            'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'Cookie' => 'XSRF-TOKEN=eyJpdiI6IkRQM1RoeXhaaHRUWHNFQWxHN2piUkE9PSIsInZhbHVlIjoiVk5CL2UrV3VIbTU2b2ZUSUpOWGhxVEdOTjZpRFNDZE8xZ1paZFVQWXVUTkkxQUJGNWVCVzM0ajNxV2N3NG85QkN2WC9HckFwamhkY3J6K0c5MkptUWVJQ05YYWZpYTRBWmJuN3ZrWVBtWDZnSTh3QmE5end1aFZhdFpjZ0NnRjEiLCJtYWMiOiI3OTFjNDY4MGU4ZWM1YTZjZDhkYzRkZmE0ZWFkNzI4MDcxZWZkOTVkNTEyYTMxYzRkNzcyODU1Y2ViYjgyMTU3In0%3D; laravel_session=eyJpdiI6ImthZTZVTFVMRUhZaFJlc0R4VHZpMXc9PSIsInZhbHVlIjoiSFMvU0U3bytJUGd3RWkvRXd4ZDdMR3BVODcvOEVZQVl6a1Y2NTRYSjRrQ2plNG5qem9uSDFKUHhyZUFscVFvSG4veEo1cnB4dHJsUmJRaS9mMG5pWi9GQzY2VzZRQWFYcDk1c2JyQzhWUVFIVU9PamcwdGM3RVJCNGxQMmM0bnMiLCJtYWMiOiIxZWYwODM5MmM2YTQ2NmEyZTMxMzMxNTY1NTM0MmFmMGZiNDZlNGYwZjkwNDQwMjJkZDA0M2RlMDA4MWRlMzE1In0%3D'
        );
        $data = array(
            '_token' => 'NjiROcVv4vjF648eE2EhUdoLl5EYwxfKSCDbxGPC',
            'sex' => '0',
            'country' => 'RUS',
            'first_name' => $person->getName(),
            'last_name' => $person->getLastname(),
            'sur_name' => '',
            'birth_year' => $person->getPassportDateOfBirth()->format('Y'),
            'birth_month' => $person->getPassportDateOfBirth()->format('m'),
            'birth_day' => $person->getPassportDateOfBirth()->format('d'),
            'expir_year' => $person->getPassportExpirDate()->format('Y'),
            'expir_month' => $person->getPassportExpirDate()->format('m'),
            'expir_day' => $person->getPassportExpirDate()->format('d'),
            'code' => '',
            'number' => '2234556699',
            'codeCheck' => '0'
        );

        $client = new Client();

        $response = $client->request('POST', 'https://test.cashfree.com/api/v2/cftoken/order', [
            'form_params' => [
                'orderId' => 'Order0001',
                'orderAmount' => 1,
                'orderCurrency' => 'INR'
            ],
            $headers,
        ]);

        $result = $response->getBody();
        $jsonData = json_decode($result->getContents(), associative: true,flags: JSON_THROW_ON_ERROR);

        $person->setGeneratedValue($jsonData['gen1'] . ' ' . $jsonData['gen2']);

        return $person;
    }
}