<?php
require 'vendor/autoload.php';

use HermesSdk\HttpApiClient;

$hubApiUrl = 'http://localhost:8104';

$hubApiClient = new HttpApiClient();
$hubApiClient->setBaseUrl($hubApiUrl);

$keyResponse = $hubApiClient->get('key');
$apiKey = $keyResponse['key'];

$hubClient = new HermesSdk\HermesClient($apiKey, $hubApiUrl);

$destination = 'demo@email.com';
$userName = 'Demo User';
$tempPassword = 'tmp';
$email = $hubClient->admin()->sendWelcomeUserMail($destination, $userName, $tempPassword);

print_r($email->toArray());
