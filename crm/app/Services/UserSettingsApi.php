<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Otis22\VetmanagerRestApi\Headers\WithAuth;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;

use function Otis22\VetmanagerRestApi\uri;

class UserSettingsApi
{
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    static function checkUserSettings(string $key, string $url): void
    {
        $client = new Client(['base_uri' => $url]);
        $authHeaders = new WithAuth(
            new ByApiKey(
                new ApiKey($key)
            )
        );
        $model = 'user';

        $response = json_decode(
            strval(
                $client->request(
                    'GET',
                    uri($model)->asString(),
                    ['headers' => $authHeaders->asKeyValue()]
                )->getBody()
            ),
            true
        );
        if (
            filter_var(
                $response['success'],
                FILTER_VALIDATE_BOOL
            ) === false
        ) {
            throw new Exception("Wrong user settings");
        }
    }
}
