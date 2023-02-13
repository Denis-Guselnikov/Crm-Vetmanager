<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\Query\Query;
use Otis22\VetmanagerRestApi\Query\Sorts;
use Otis22\VetmanagerRestApi\Query\Filters;

use function Otis22\VetmanagerRestApi\uri;

class VetmanagerApi
{
    private $key;
    private Client $client;

    public function __construct(User $user)
    {
        $this->key = $user->userSettingApi->key;
        $this->client = new Client(['base_uri' => 'https://' . $user->userSettingApi->url]);
    }

    // Api key auth
    private function authHeaders()
    {
        return new \Otis22\VetmanagerRestApi\Headers\WithAuth(
            new \Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey(
                new \Otis22\VetmanagerRestApi\Headers\Auth\ApiKey($this->key)
            )
        );
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    // Получить всех активных клиентов
    public function getClients()
    {
        $paged = PagedQuery::forGettingAll(new Query(new Sorts(),
            new Filters(
                new \Otis22\VetmanagerRestApi\Query\Filter\EqualTo(
                    new \Otis22\VetmanagerRestApi\Model\Property('status'),
                    new \Otis22\VetmanagerRestApi\Query\Filter\Value\StringValue('active')
                )
        )));
        $model = 'client';

        $response = json_decode(
            strval(
                $this->client->request(
                    'GET',
                    uri($model)->asString(),
                    [
                        'headers' => $this->authHeaders()->asKeyValue(),
                        'query' => $paged->asKeyValue(),
                    ]
                )->getBody()
            ),
            true
        );
        return $response['data'][$model];
    }

    // Создать клиента
    public function createClient($validated): void
    {
        $model = 'client';

        $this->client->request(
            'POST',
            uri($model)->asString(),
            [
                'headers' => $this->authHeaders()->asKeyValue(),
                'json' => $validated
            ]
        )->getBody();
    }

    /**
     * @throws GuzzleException
     */
    // Удалить клиента
    public function deleteClient($id): void
    {
        $model = 'client';

        $this->client->delete(
            uri($model)->asString() . "/$id",
            ['headers' => $this->authHeaders()->asKeyValue()]
        );
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    // Получить клиента
    public function getClient(int $id)
    {
        $model = 'client';

        $response = json_decode(
            strval(
                $this->client->request(
                    'GET',
                    uri($model)->asString() . "/$id",
                    ['headers' => $this->authHeaders()->asKeyValue()]
                )->getBody()
            ),
            true
        );
        return $response['data'][$model];
    }

    // Редактировать клиента
    public function editClient($validated, int $id): void
    {
        $model = 'client';

        $this->client->request(
            'PUT',
            uri($model)->asString() . "/$id",
            [
                'headers' => $this->authHeaders()->asKeyValue(),
                'json' => $validated
            ]
        )->getBody();
    }
}
