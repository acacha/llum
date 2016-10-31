<?php

namespace Acacha\Llum\Github;

use Acacha\Llum\Filesystem\Filesystem;
use Acacha\Llum\Github\Exceptions\CredentialsException;
use GuzzleHttp\Client;

/**
 * Class GithubAPI
 * @package Acacha\Llum\Github
 */
class GithubAPI
{
    /**
     * Guzzle http client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Github API URL.
     *
     * @var string
     */
    protected $api_url = "https://api.github.com";

    /**
     * Authorization URI in github API.
     *
     * @var string
     */
    protected $authorizations_uri = "/authorizations";

    /**
     * Authorization URI in github API.
     *
     * @var string
     */
    protected $repos_uri = "/user/repos";


    /**
     * Acacha Llum Filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Token name;
     *
     * @var
     */
    protected $tokenName;

    /**
     * GithubAPI constructor.
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->client = new Client();
        $this->filesystem = $filesystem;
    }

    /**
     * Path to repo.json stub
     *
     * @return string
     */
    protected function repo_json_stub() {
        return __DIR__ . '/stubs/repo_json.stub';
    }

    /**
     * Authorization URL.
     *
     * @return string
     */
    protected function authorization_url() {
        return $this->api_url . $this->authorizations_uri;
    }

    /**
     * Create repo URL.
     *
     * @return string
     */
    protected function create_repo_url() {
        return $this->api_url . $this->repos_uri;
    }

    /**
     * Obtain personal token.
     *
     * @param $username
     * @param $password
     * @return mixed
     */
    public function getPersonalToken($username, $password)
    {
        $response = $this->client->request('POST', $this->authorization_url(),
            [
                "auth" => [ $username, $password],
                "json" => $this->authorizationsRequestJson()
            ]
        );
        $response = json_decode($response->getBody());
        $this->tokenName = $response->app->name;
        return $response->token;
    }

    /**
     * @return array
     */
    protected function authorizationsRequestJson(){
        return [
            'scopes' => [ 'public_repo' ],
            'note' =>  uniqid('llum_')
        ];
    }

    /**
     * Create repo in github.
     *
     * @param $repo_name
     * @param $repo_description
     * @return mixed
     */
    public function createRepo($repo_name, $repo_description)
    {
        return $this->client->request('POST', $this->create_repo_url(),
            [
                "auth" => $this->credentials(),
                "json" => json_decode($this->compileStub($repo_name, $repo_description),true),
            ]
        );
    }

    /**
     * Set github credentials.
     *
     * @param array $credentials
     */
    public function setCredentials(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Get github credentials.
     *
     * @return mixed
     * @throws CredentialsException
     */
    protected function credentials()
    {
        if (isset($this->credentials))
            return $this->credentials;
        throw new CredentialsException;
    }

    /**
     * Compile stub.
     *
     * @param $repo_name
     * @param $repo_description
     * @return mixed
     */
    protected function compileStub($repo_name, $repo_description)
    {
        $data = [
            "REPO_NAME" => $repo_name,
            "REPO_DESCRIPTION" => $repo_description
        ];
        return $this->compile(
            $this->filesystem->get($this->repo_json_stub()) ,
            $data);
    }

    /**
     * Compile the template using the given data.
     *
     * @param $template
     * @param $data
     * @return mixed
     */
    protected function compile($template, $data)
    {
        foreach($data as $key => $value)
        {
            $template = preg_replace("/\\$$key\\$/i", $value, $template);
        }
        return $template;
    }

    /**
     * @return mixed
     */
    public function tokenName()
    {
        return $this->tokenName;
    }


}