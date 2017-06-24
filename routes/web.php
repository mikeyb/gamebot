<?php

Route::match(['get', 'post'], '/slack/gamebot', 'GameBotController@handle');

Route::get('/', function () {
	return 'Coming Soon';
});