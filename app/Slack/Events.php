<?php

namespace App\Slack;

use GuzzleHttp\Client;

class Events
{

	function __construct()
	{

		$this->tokenMap = [
			"BTC" => "bitcoin",
			"GAME" => "gamecredits",
			"MOG" => "mobilego",
			"MGO" => "mobilego"
		];

		$this->client = new Client();

	}

	/**
	* @return array $defaults
	**/
	function getDefaultPrices ()
	{
        $GAME = json_decode($this->client->request('GET', 'https://api.coinmarketcap.com/v1/ticker/gamecredits/')->getBody());
        $MOG = json_decode($this->client->request('GET', 'https://api.coinmarketcap.com/v1/ticker/mobilego/')->getBody());

        $defaults = ["game" => $GAME, "mog" => $MOG];

        return $defaults;

	}

	/**
	* @param string $token
	* @return array $token
	**/
	function getToken ($token)
	{

		$token = strtoupper($token);
        
		if($this->tokenMap["$token"])
		{

			$tokenId = $this->tokenMap["$token"];

	        $token = json_decode($this->client->request('GET', "https://api.coinmarketcap.com/v1/ticker/$tokenId/")->getBody());

	        return $token;

	    }

	    return $token = json_decode('{}');

	}

}