<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Otis22\VetmanagerRestApi\Query\Filter\NotEqualTo;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\Query\Query;
use Otis22\VetmanagerRestApi\Query\Sorts;
use Otis22\VetmanagerRestApi\Query\Filters;
use Otis22\VetmanagerRestApi\Query\Filter\EqualTo;
use Otis22\VetmanagerRestApi\Model\Property;
use Otis22\VetmanagerRestApi\Query\Filter\Value\StringValue;

use Otis22\VetmanagerRestApi\Headers\WithAuth;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;

use function Otis22\VetmanagerRestApi\uri;

class VetmanagerApi
{
    const CLIENT = 'client';
    const PET = 'pet';

    private $key;
    private Client $client;

    public function __construct(User $user)
    {
        $this->key = $user->userSettingApi->key;
        $this->client = new Client(['base_uri' => 'https://' . $user->userSettingApi->url]);
    }

    // Api key auth
    private function authHeaders(): WithAuth
    {
        return new WithAuth(
            new ByApiKey(
                new ApiKey($this->key)
            )
        );
    }

    // Получить всех активных клиентов
    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function getClients(string $model)
    {
        $paged = PagedQuery::forGettingAll(new Query(new Sorts(),
            new Filters(
                new EqualTo(
                    new Property('status'),
                    new StringValue('active')
                )
            )));

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
    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function createClient(string $model, $validated): void
    {
        //dd($model);
        //dd($validated);
        $this->client->request(
            'POST',
            uri($model)->asString(),
            [
                'headers' => $this->authHeaders()->asKeyValue(),
                'json' => $validated
            ]
        )->getBody();
    }

    // Удалить клиента
    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function deleteClient($id): void
    {
        $model = 'client';

        $this->client->delete(
            uri($model)->asString() . "/$id",
            ['headers' => $this->authHeaders()->asKeyValue()]
        );
    }

    // Получить клиента
    /**
     * @throws GuzzleException
     * @throws \Exception
     */
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
    /**
     * @throws GuzzleException
     * @throws \Exception
     */
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

    // Поисковик
    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function searchClient($query)
    {
        $paged = PagedQuery::forGettingAll(new Query(new Sorts(),
            new Filters(
                new EqualTo(
                    new Property('first_name'),
                    new StringValue($query)
                ),
                new NotEqualTo(
                    new Property('status'),
                    new StringValue('DELETED')
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

    public function getPetsByClientId(int $id)
    {
//        VetmanagerApi::PET
    }
}
