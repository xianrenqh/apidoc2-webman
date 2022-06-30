<?php

/**
 * Created by PhpStorm.
 * User: 小灰灰
 * Date: 2022-06-30
 * Time: 14:49:20
 * Info:
 */

namespace xianrenqh\Apidoc2Webman\exception;

class AuthException extends \RuntimeException
{

    protected $exceptions = [
        'password error'     => ['code' => 4001, 'msg' => '密码不正确，请重新输入'],
        'password not found' => ['code' => 4002, 'msg' => '密码不可为空'],
        'token error'        => ['code' => 4003, 'msg' => '不合法的Token'],
        'token not found'    => ['code' => 4004, 'msg' => '不存在Token'],
    ];

    public function __construct(string $exceptionCode)
    {
        $exception = $this->getException($exceptionCode);
        parent::__construct($exception['msg'], $exception['code'], null);
    }

    public function getException($exceptionCode)
    {
        if (isset($this->exceptions[$exceptionCode])) {
            return $this->exceptions[$exceptionCode];
        }
        throw new \Exception('exceptionCode "'.$exceptionCode.'" Not Found');
    }
}
