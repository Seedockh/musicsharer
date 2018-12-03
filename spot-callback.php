<?php require 'vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$session = new SpotifyWebAPI\Session(
    'CLIENT_ID',
    'CLIENT_SECRET',
    'http://www.musiqueartbienetre.fr/musicshare/index.php'
);

// Request a access token using the code from Spotify
$session->requestAccessToken($_GET['code']);

$accessToken = $session->getAccessToken();
$refreshToken = $session->getRefreshToken();

// Store the access and refresh tokens somewhere. In a database for example.
session_start();
$_SESSION['accesstoken'] = $accessToken;
$_SESSION['refreshtoken'] = $refreshToken;

// Send the user along and fetch some data!
header('Location: index.php');
die();
?>
