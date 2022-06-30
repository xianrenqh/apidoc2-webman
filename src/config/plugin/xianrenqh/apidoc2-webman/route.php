<?php

use Webman\Route;
use support\Request;

Route::any('/apidoc/config', [xianrenqh\Apidoc2Webman\BaseController::class, 'getConfig']);
Route::any('/apidoc/apiData', [xianrenqh\Apidoc2Webman\BaseController::class, 'getApidoc']);
Route::any('/apidoc/verifyAuth', [xianrenqh\Apidoc2Webman\BaseController::class, 'verifyAuth']);
Route::any('/apidoc/mdMenus', [xianrenqh\Apidoc2Webman\BaseController::class, 'getMdMenus']);
Route::any('/apidoc/mdDetail', [xianrenqh\Apidoc2Webman\BaseController::class, 'getMdDetail']);

Route::any('/apidoc/[{path:.+}]', function (Request $request, $path = '') {
    // 静态文件目录
    $static_base_path = base_path().'/vendor/xianrenqh/apidoc2-webman/src/public';
    if (strpos($path, '..') !== false) {
        return response('<h1>400 Bad Request</h1>', 400);
    }
    // 文件
    $file = "$static_base_path/$path";
    if ( ! is_file($file)) {
        return response('<h1>404 Not Found</h1>', 404);
    }

    return response('')->withFile($file);
});
