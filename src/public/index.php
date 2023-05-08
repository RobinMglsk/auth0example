<?php

declare(strict_types=1);

require('../vendor/autoload.php');

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
$sdk = null;

function main(){
    throwErrorIfInvalidEnv();
    $configuration = new SdkConfiguration(
        domain: $_ENV["DOMAIN"],
        clientId: $_ENV["CLIENT_ID"],
        clientSecret: $_ENV["CLIENT_SECRET"],
        redirectUri: 'http://' . $_SERVER['HTTP_HOST'] . '/callback',
        cookieSecret: '4f60eb5de6b5904ad4b8e31d9193e7ea4a3013b476ddb5c259ee9077c05e1457'
    );
    
    $sdk = new Auth0($configuration);
    require('router.php');
}

function throwErrorIfInvalidEnv()
{
    $requiredEnvVars = ['DOMAIN', 'CLIENT_ID', 'CLIENT_SECRET'];
    foreach ($requiredEnvVars as $envVar) {
        if (!isset($_ENV[$envVar])) {
            throw new Exception(sprintf('Environment variable %s not found.', $envVar));
        }
    }
}

main();