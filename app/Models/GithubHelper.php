<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Facades\Socialite;

class GithubHelper extends Model
{
    //
    const GITHUB_API = 'https://api.github.com/';

    const ENDPOINT_OWNED_REPO = 'user/repos';
    const ENDPOINT_PROFILE_FROM_USERNAME = 'users/';

    const PERPAGE = 10;

    protected $client;
    protected $headers;

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = ['headers' => []];
    }

    private function requiredUserAuth($key)
    {
        $this->headers['headers']['Authorization'] = 'Bearer ' . $key;
    }

    public function post($endPoint)
    {
        return $this->client->post(self::GITHUB_API . $endPoint, $this->headers);
    }

    public function get($endPoint, $uri = "")
    {
        $res = $this->client->get(self::GITHUB_API . $endPoint . $uri, $this->headers);
        return json_decode($res->getBody(), true);
    }


    public function ownedRepo($token)
    {
        $this->requiredUserAuth($token);
        return $this->get(self::ENDPOINT_OWNED_REPO);
    }

    public function getProfile($token)
    {
        $user = Socialite::driver('github')->userFromToken($token);
        $data = [
            'email' => $user->email,
            'name' => $user->name,
            'nickname' => $user->nickname,
            'public_repo' => $user->user["public_repos"],
        ];
        return $data;
    }

    public function getRepoFromUsername($username, $page, $perPage)
    {
        return $this->get('users/' . $username . '/repos?page=' . $page . '&per_page=' . $perPage);
    }

    public function getProfileFromUsername($username)
    {
        return $this->get(self::ENDPOINT_PROFILE_FROM_USERNAME . $username);
    }

    public function postForkRepo($owner, $repo, $token)
    {
        $this->requiredUserAuth($token);
        return $this->post('repos/' . $owner . '/' . $repo . '/forks');
    }
}
