<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\Query\Query;

class VetmanagerApi
{
    private $key;
    private $url;

    public function __construct()
    {
        $this->key = User::class->usersettingapi();
        $this->url = new Client(['base_url' => User::class->usersettingapi()]);
    }

    public function getClient()
    {
        $paged = PagedQuery::forGettingAll(new Query());

        $result = [];
        do {
            $response = json_decode(
                strval(
                    $this->url->request(
                        'GET',
                        uri('invoice')->asString(),
                        [
                            'headers' => $headers->asKeyValue(),
                            'query' => $paged->asKeyValue()
                        ]
                    )->getBody()
                ),
                true
            );
            $paged = $paged->next();
            $result = array_merge(
                $response['data']['invoice'],
                $result
            );
        } while (count($result) < $response['data']['totalCount']);
    }
}
