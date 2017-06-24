<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('!prices', function($bot){
    $bot->reply('hello!');
});