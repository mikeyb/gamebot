<?php

namespace App\Http\Controllers;

use App\Slack\Events;

use App\Conversations\ExampleConversation;
use Illuminate\Http\Request;
use Mpociot\BotMan\BotMan;

class GameBotController extends Controller
{

    public function __construct()
    {

        $this->events = new Events;

    }

    public function handle()
    {

        $botman = app('botman');

        $botman->verifyServices(env('TOKEN_VERIFY'));

        $botman->hears('!prices',
            function($bot)
            {

                $prices = $this->events->getDefaultPrices();

                $user = $bot->getUser();
                
                $bot->say('
                    Current Prices
                    ```
                    GAME
                      USD: ' . $prices['game'][0]->price_usd . '
                      BTC: ' . $prices['game'][0]->price_btc . '
                    MGO
                      USD: ' . $prices['mog'][0]->price_usd . '
                      BTC: ' . $prices['mog'][0]->price_btc . '
                    ```
                ', $user->getId());

            }

        );

        $botman->listen();
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }
}
