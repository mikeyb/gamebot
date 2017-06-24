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
            function(BotMan $bot)
            {

                $prices = $this->events->getDefaultPrices();

                $user = $bot->getUser();

                $message = '|-> Brought to you by `https://GameBot.chat` <-|

*GAME* | `https://coinmarketcap.com/currencies/gamecredits/`

```
USD: ' . $prices['game'][0]->price_usd . '
BTC: ' . $prices['game'][0]->price_btc . '
```

*MGO* | `https://coinmarketcap.com/currencies/mobilego/`

```
USD: ' . $prices['mog'][0]->price_usd . '
BTC: ' . $prices['mog'][0]->price_btc . '
```
                ';

                $bot->reply($message);

            }

        );

        $botman->hears('!price {token}',
            function (BotMan $bot, $token)
            {

                $user = $bot->getUser();

                $prices = $this->events->getToken($token);

                $message = '|-> Brought to you by `https://GameBot.chat` <-|

*' . $prices[0]->symbol . '* | `https://coinmarketcap.com/currencies/' . $prices[0]->id . '/`

```
USD: ' . $prices[0]->price_usd . '
BTC: ' . $prices[0]->price_btc . '
```
                ';

                $bot->reply($message);       

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
