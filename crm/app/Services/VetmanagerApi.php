<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\ValidatedInput;
use function Otis22\VetmanagerRestApi\uri;
use App\Models\User;
use GuzzleHttp\Client;

use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\Query\Query;
use Otis22\VetmanagerRestApi\Query\Sorts;

class VetmanagerApi
{
    private $key;
    private $url;

    public function __construct(User $user)
    {
        $this->key = $user->userSettingApi->key;
        $this->url = new Client(['base_uri' => 'https://' . $user->userSettingApi->url]);
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function getClient()
    {
        $paged = PagedQuery::forGettingAll(new Query(new Sorts()));
        $model = 'client';

        $authHeaders = new \Otis22\VetmanagerRestApi\Headers\WithAuth(
            new \Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey(
                new \Otis22\VetmanagerRestApi\Headers\Auth\ApiKey($this->key)
            )
        );

        $response = json_decode(
            strval(
                $this->url->request(
                    'GET',
                    uri($model)->asString(),
                    [
                        'headers' => $authHeaders->asKeyValue(),
                        'query' => $paged->asKeyValue(),
                    ]
                )->getBody()
            ),
            true
        );
        return $response['data'][$model];
    }

    public function createClient(ValidatedInput|array $validated)
    {
        $model = 'client';
        $authHeaders = new \Otis22\VetmanagerRestApi\Headers\WithAuth(
            new \Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey(
                new \Otis22\VetmanagerRestApi\Headers\Auth\ApiKey($this->key)
            )
        );

        $this->url->request(
            'POST',
            uri($model)->asString(),
            [
                'headers' => $authHeaders->asKeyValue(),
                'json' => $validated
            ]
        )->getBody();
    }
}
