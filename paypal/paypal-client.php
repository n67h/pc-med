<?php

namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); //or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    // Returns PayPal HTTP client instance with environment that has access credentials context. Use this instance to invoke PayPal APIs, provided the credentials have access.
    
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    // Set up and return Paypal PHP SDK environment with PayPal access credentials. This sample uses SandboxEnvironment. In production, use LiveEnvironment.

    public static function environment()
    {
        $clientId = getenv("CLIENT_ID") ?: "AUu5zoJ_q4bYnIOx-obNVF0jUm2XJSJCNIQ7Dr5cP8YkOBekxutIHYrLDDLIFSwcrqbFmFxaUUzL89Ch";
        $clientSecret = getenv("CLIENT_SECRET") ?: "EPHYXvAq45NIpcbzayfcNEQU3k3ZlpeBnFdvCvs9YGOeSqWV57-AQkhL8_IVfJeO-Gj6HNjxA9xU2T3q";
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}