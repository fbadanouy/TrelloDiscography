<?php

namespace API;

use \Curl\Curl;
use Exception;

class Trello
{

    private $apiKey, $token, $boardId;

    public function __construct()
    {

        try {

            $config = json_decode(file_get_contents('config.json'));

            if ($config->TRELLO_API_KEY === 'xxx' OR $config->TRELLO_TOKEN === 'xxx') {
                throw new Exception();
            }

        } catch (Exception $e) {

            print_r('ERROR: Invalid config.json - Check the handy guide to fill the config.json file on readme file.');
            exit;

        }

        $this->apiKey   = $config->TRELLO_API_KEY;
        $this->token    = $config->TRELLO_TOKEN;

    }

    public function deleteTestBoard() {

        $this->boardId = file_get_contents('assets/last_board_id.txt');

        $this->deleteBoard();

    }

    public function createBoard($name)
    {

        $curl = new Curl();

        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);

        $response = $curl->post('https://api.trello.com/1/boards', [
            'key'           => $this->apiKey,
            'token'         => $this->token,
            'name'          => $name,
            'defaultLists'  => false
        ]);

        $curl->close();

        file_put_contents('assets/last_board_id.txt', $response->id);

        $this->boardId = $response->id;

        return $response;

    }

    public function createList($name)
    {

        $curl = new Curl();

        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);

        $response = $curl->post('https://api.trello.com/1/boards/'. $this->boardId .'/lists', [
            'key'   => $this->apiKey,
            'token' => $this->token,
            'id'    => $this->boardId,
            'name'  => $name
        ]);

        $curl->close();

        return $response->id;

    }

    public function createCard($idList, $name, $desc)
    {

        $curl = new Curl();

        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);

        $response = $curl->post('https://api.trello.com/1/cards', [
            'key'   => $this->apiKey,
            'token' => $this->token,
            'idList' => $idList,
            'name'  => $name,
            'desc'  => $desc
        ]);

        $curl->close();

        return $response->id;

    }

    private function deleteBoard()
    {
        $curl = new Curl();

        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);

        $response = $curl->delete('https://api.trello.com/1/boards/' . $this->boardId, [
            'key'   => $this->apiKey,
            'token' => $this->token,
            'id'    => $this->boardId
        ]);

        $curl->close();

        $this->boardId = '';

        return $response;
    }

    public function updateCardCover($id, $cover)
    {

        $curl = new Curl();

        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);

        $response = $curl->post('https://api.trello.com/1/cards/' . $id . '/attachments', [
            'key'       => $this->apiKey,
            'token'     => $this->token,
            'id'        => $id,
            'url'       => $cover,
            'setCover'  => true
        ]);

        $curl->close();

        return $response;

    }

}