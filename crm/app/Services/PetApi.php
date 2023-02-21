<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;

use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\WithAuth;
use function Otis22\VetmanagerRestApi\uri;

class PetApi
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
     * @throws \Exception
     */
    public function getPet(int $id)
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
     * @throws \Exception
     */
    public function createPet($validated): void
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
     * @throws \Exception
     */
    public function deletePet(int $id): void
    {
        $this->client->delete(
            uri($this->model)->asString() . "/$id",
            ['headers' => $this->authHeaders()->asKeyValue()]
        );
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function editPet($validated, int $id): void
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
}
