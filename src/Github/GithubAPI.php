<?php

namespace Acacha\Llum\Github;

use GuzzleHttp\Client;

class GithubAPI
{

    protected $client;

    protected $api_url = "https://api.github.com";

    protected $authorizations_uri = "/authorizations";

    protected $authorizations_request_json = [
        "scopes" => [ "public_repo" ],
        "note" =>  "llum"
    ];

    /**
     * GithubAPI constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }


    public function getPersonalToken($username, $password)
    {
        $response = $this->client->request('POST', $this->authorization_url(),
            [
                "auth" => [ $username, $password],
                "json" => $this->authorizations_request_json
            ]
        );
        return json_decode($response->getBody())->token;
    }

    protected function authorization_url() {
        return $this->api_url . $this->authorizations_uri;
    }
}