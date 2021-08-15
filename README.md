# TrelloDiscography
Simple PHP script that creates a Trello board with Bob Dylan's Discography.

## Requirements

- PHP 7.3 or later
- Composer 2.0

## Installation

Run  [Composer](https://getcomposer.org/):

    composer install

## Usage

Before using this script, you'll need to get your credentials for [Trello](https://trello.com/app-key) (Key and Token) and [Spotify](https://developer.spotify.com/) (Client ID and Client Secret) for the [config.json](https://github.com/fbadanouy/TrelloDiscography/blob/master/config.json) file.

**Config.json**
In order to get your ***Trello*** credentials you need to access [Trello's App Key page](https://trello.com/app-key). Get your developer api key and replace the  "TRELLO_API_KEY" default value on the config.json file. In order to get the token you have to manually generate it by clicking the 'Token' link. Then replace the  "TRELLO_TOKEN" default value on the config.json file.
For your ***Spotify*** credentials you'll need to create an app at [Spotify’s developer site](https://developer.spotify.com/). Once created you can get your Client Id and Secret inside your app. Then replace the default values for Spotify's credentials inside the config.json file.

To run the script:

    php main.php
