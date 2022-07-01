<?php
/**
 * Created by PhpStorm.
 * User: 小灰灰
 * Date: 2022-06-21
 * Time: 16:27:43
 * Info:
 */

namespace app\api\controller;

use xianrenqh\Apidoc2Webman\annotation as Apidoc;

/**
 * @Apidoc\Title("基础示例")
 * @Apidoc\Group("base")
 */
class UserController extends ApiController
{

    /**
     * @Apidoc\Title("会员登录接口")
     * @Apidoc\Desc("最基础的接口注释写法")
     * @Apidoc\Url("/api/user_login")
     * @Apidoc\Method("POST")
     * @Apidoc\Author("HG-CODE")
     * @Apidoc\Tag("测试")
     * @Apidoc\Header("xx-token", type="string",require=true, desc="token")
     * @Apidoc\Param("username", type="abc",require=true, desc="用户名")
     * @Apidoc\Param("password", type="string",require=true, desc="密码")
     * @Apidoc\Param("phone", type="string",require=true, desc="手机号")
     * @Apidoc\Param("sex", type="int",default="1",desc="性别" )
     * @Apidoc\Returned("id", type="int", desc="用户id")
     */
    public function user_login()
    {
        /**
         * 你的登录方法
         */
    }

    /**
     * @Apidoc\Title("获取会员积分接口")
     * @Apidoc\Desc("最基础的接口注释写法")
     * @Apidoc\Url("/api/user_point")
     * @Apidoc\Method("POST")
     * @Apidoc\Author("HG-CODE")
     * @Apidoc\Tag("测试")
     * @Apidoc\Header("xx-token", type="string",require=true, desc="token")
     * @Apidoc\Param("username", type="abc",require=true, desc="用户名")
     * @Apidoc\Param("sex", type="int",default="1",desc="性别" )
     * @Apidoc\Returned("id", type="int", desc="用户id")
     */
    public function user_point()
    {
        return $this->userId;
    }

}
