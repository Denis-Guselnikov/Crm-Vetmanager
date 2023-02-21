<?php

namespace App\Services;

use GuzzleHttp\Client;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\WithAuth;
use function Otis22\VetmanagerRestApi\uri;

class PetApi
{
    private Client $client;
    private $key;
    private $model;

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

    public function createPet($validated)
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


    public function deletePet(int $id)
    {
        $this->client->deleteClient(
            uri($this->model)->asString() . "/$id",
            ['headers' => $this->authHeaders()->asKeyValue()]
        );
    }

    public function editPet($validated, int $id)
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
