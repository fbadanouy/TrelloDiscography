<?php

require __DIR__ . '/vendor/autoload.php';
require 'API/Trello.php';
require 'API/Spotify.php';

use API\Spotify;
use API\Trello;


$discography = getDiscography();

$trello = new Trello();

$trello->createBoard('Bob Dylan Discography');

$spotify = new Spotify();

$decade = 0;

foreach ($discography as $d) {

    $decadeNew = getDecade($d);

    if ($decadeNew != $decade) {
        $decade = $decadeNew;
        $listId = $trello->createList($decade . 's');
    }

    $cardId = $trello->createCard($listId, substr($d,5), $d);
    $trello->updateCardCover($cardId, $spotify->getCover(substr($d,5)));

}

function getDecade($name)
{

    $d = substr($name, 0, 4) - 10;

    return ceil($d/10)*10;

}

function getDiscography()
{

    $content = file('assets/discography.txt', FILE_IGNORE_NEW_LINES);
    sort($content);

    return $content;

}