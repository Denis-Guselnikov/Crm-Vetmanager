<?php

namespace App\Services;

use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\WithAuth;

use Otis22\VetmanagerRestApi\Query\Filter\EqualTo;
use Otis22\VetmanagerRestApi\Query\Filter\NotEqualTo;
use Otis22\VetmanagerRestApi\Query\Filter\Value\StringValue;
use Otis22\VetmanagerRestApi\Query\Filters;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\Query\Query;
use Otis22\VetmanagerRestApi\Query\Sort\AscBy;
use Otis22\VetmanagerRestApi\Query\Sorts;

use function Otis22\VetmanagerRestApi\uri;
use Otis22\VetmanagerRestApi\Model\Property;

class ClientApi
{
    private Client $client;
    private $key;
    private string $model;

    public function __construct(User $user, $model)
    {
        $this->key = $user->userSettingApi->key;
        $this->client = new Client(['base_uri' => $user->userSettingApi->url]);
        $this->model = $model;
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

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getClients()
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
                    uri($this->model)->asString(),
                    [
                        'headers' => $this->authHeaders()->asKeyValue(),
                        'query' => $paged->asKeyValue(),
                    ]
                )->getBody()
            ),
            true
        );
        return $response['data'][$this->model];
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getClient(int $id)
    {
        $response = json_decode(
            strval(
                $this->client->request(
                    'GET',
                    uri($this->model)->asString() . "/$id",
                    ['headers' => $this->authHeaders()->asKeyValue()]
                )->getBody()
            ),
            true
        );
        return $response['data'][$this->model];
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function createClient($validated): void
    {
        $this->client->request(
            'POST',
            uri($this->model)->asString(),
            [
                'headers' => $this->authHeaders()->asKeyValue(),
                'json' => $validated
            ]
        );
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function deleteClient(int $id): void
    {
        $this->client->delete(
            uri($this->model)->asString() . "/$id",
            ['headers' => $this->authHeaders()->asKeyValue()]
        );
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function editClient($validated, int $id): void
    {
        $this->client->request(
            'PUT',
            uri($this->model)->asString() . "/$id",
            [
                'headers' => $this->authHeaders()->asKeyValue(),
                'json' => $validated
            ]
        )->getBody();
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function searchClient(string $query)
    {
        $response = json_decode(
            strval(
                $this->client->request(
                    'GET',
                    uri($this->model)->asString() . "/clientsSearchData?search_query=$query",
                    [
                        'headers' => $this->authHeaders()->asKeyValue(),
                    ]
                )->getBody()
            ),
            true
        );
        return $response['data'][$this->model];
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function getPetsByClientId(int $id)
    {
        $paged = PagedQuery::forGettingAll(new Query(new Sorts(
            new AscBy(
                new Property('id')
            )
        ),
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
}
