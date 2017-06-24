<?php

Route::match(['get', 'post'], '/slack/gamebot', 'GameBotController@handle');