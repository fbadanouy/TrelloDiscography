<?php

namespace API;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class Spotify
{

    private $api;

    public function __construct() {

        try {

            $config = json_decode(file_get_contents('config.json'));

            if ($config->SPOTIFY_CLIENT_ID === 'xxx' OR $config->SPOTIFY_CLIENT_SECRET === 'xxx') {
                throw new Exception();
            }

        } catch (Exception $e) {

            print_r('ERROR: Invalid config.json - Check the Usage section on the readme file.');
            exit;

        }

        $session = new Session(
            $config->SPOTIFY_CLIENT_ID,
            $config->SPOTIFY_CLIENT_SECRET
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $this->api = new SpotifyWebAPI();
        $this->api->setAccessToken($accessToken);

    }

    public function getCover($album)
    {
        $search = $this->api->search($album . ' Bob Dylan', 'album');

        $i = 0;

        $search = $search->albums->items;

        while ($i < count($search) && $search[$i]->artists[0]->name !== 'Bob Dylan') {
            $i++;
        }

        return $search[$i]->images[0]->url;
    }

}