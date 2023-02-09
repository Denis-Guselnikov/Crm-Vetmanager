<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use function Otis22\VetmanagerRestApi\uri;

use App\Models\User;
use GuzzleHttp\Client;
//use GuzzleHttp\Exception\GuzzleException;

use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\Query\Query;
use Otis22\VetmanagerRestApi\Query\Sorts;
use Otis22\VetmanagerRestApi\Query\SortBy;


class VetmanagerApi
{
    private $key;
    private $url;

    public function __construct(User $user)
    {
        $this->key = '36819535a844c0c5077f309610386a7b';
        $this->url = new Client(['base_url' => 'https://devdeni24.vetmanager2.ru']);
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function getClient()
    {
        $paged = PagedQuery::forGettingAll(new Query(new Sorts()));
        //$paged = PagedQuery::forGettingAll(new Query());
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
                    'https://devdeni24.vetmanager2.ru' . uri($model)->asString(),
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
}
