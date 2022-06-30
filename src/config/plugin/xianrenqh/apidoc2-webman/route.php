<?php

use Webman\Route;
use support\Request;

Route::any('/apidoc2/config', [xianrenqh\Apidoc2Webman\BaseController::class, 'get_config']);
