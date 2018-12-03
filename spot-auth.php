<?php require 'vendor/autoload.php';

/* Spotify Web API PHP : https://github.com/jwilsson/spotify-web-api-php */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$session = new SpotifyWebAPI\Session(
    'CLIENT_ID',
    'CLIENT_SECRET',
    'http://www.musiqueartbienetre.fr/musicshare/index.php'
);

$options = [
    'scope' => [
      'user-modify-playback-state',
      'user-read-playback-state',
      'user-library-read'
    ],
];

header('Location: ' . $session->getAuthorizeUrl($options));
die();



?>
