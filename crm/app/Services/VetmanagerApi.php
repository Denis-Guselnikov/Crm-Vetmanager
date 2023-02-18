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
use Otis22\VetmanagerRestApi\Query\Filter\Value\StringValue;
use Otis22\VetmanagerRestApi\Query\Sort\AscBy;
use Otis22\VetmanagerRestApi\Query\Sort\DescBy;

use Otis22\VetmanagerRestApi\Headers\WithAuth;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;

use Otis22\VetmanagerRestApi\Model\Property;
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
        $this->client = new Client(['base_uri' => $user->userSettingApi->url]);
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
        $paged = PagedQuery::forGettingTop(new Query(new Sorts(
            new AscBy(
                new Property('id')
            )
        ),
            new Filters(
                new EqualTo(
                    new Property('status'),
                    new StringValue('active')
                )
            )), 50);

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
    public function deleteClient(string $model, int $id): void
    {
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
    public function getClient(string $model, int $id)
    {
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
    public function editClient(string $model, $validated, int $id): void
    {
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
        $paged = PagedQuery::forGettingTop(new Query(new Sorts(
            new DescBy(
                new Property('id')
            )
        ),
            new Filters(
                new EqualTo(
                    new Property('first_name'),
                    new StringValue($query)
                ),
                new NotEqualTo(
                    new Property('status'),
                    new StringValue('DELETED')
                )
            )), 50);
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
        $paged = PagedQuery::forGettingAll(new Query(new Sorts(),
            new Filters(
                new NotEqualTo(
                    new Property('status'),
                    new StringValue('DELETED')
                ),
                new EqualTo(
                    new Property('owner_id'),
                    new StringValue($id)
                ),

            )));
        $model = 'pet';

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

    static function checkUserSattings(string $key, string $url): bool
    {
        $client = new Client(['base_uri' => $url]);
        $authHeaders = new WithAuth(
            new ByApiKey(
                new ApiKey($key)
            )
        );

        $response = json_decode(
            strval(
                $client->request(
                    'GET',
                    '/rest/api/user',
                    ['headers' => $authHeaders->asKeyValue()]
                )->getBody()
            ),
            true
        );

        if ($response['success']) {
            return true;
        }
        return false;
    }
}
