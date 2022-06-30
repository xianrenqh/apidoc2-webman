<?php

/**
 * Created by PhpStorm.
 * User: 小灰灰
 * Date: 2022-06-30
 * Time: 14:04:09
 * Info:
 */

namespace xianrenqh\Apidoc2Webman;

use xianrenqh\Apidoc2Webman\Utils;
use xianrenqh\Apidoc2Webman\Auth;
use xianrenqh\Apidoc2Webman\exception\AuthException;
use xianrenqh\Apidoc2Webman\parseApi\ParseAnnotation;
use xianrenqh\Apidoc2Webman\parseApi\ParseMarkdown;

class BaseController
{

    protected $config;

    public function __construct()
    {
        $config = config('plugin.xianrenqh.apidoc2-webman.apidoc');
        // 过滤关闭的生成器
        if ( ! empty($config['generator']) && count($config['generator'])) {
            $generatorList = [];
            foreach ($config['generator'] as $item) {
                if ( ! isset($item['enable']) || (isset($item['enable']) && $item['enable'] === true)) {
                    $generatorList[] = $item;
                }
            }
            $config['generator'] = $generatorList;
        }
        $this->config = $config;
    }

    /**
     * 获取配置
     * @return \think\response\Json
     */
    public function getConfig()
    {
        $config = $this->config;
        if ( ! empty($config['auth'])) {
            unset($config['auth']['password']);
            unset($config['auth']['key']);
        }
        $params               = request()->all();
        $config['title']      = Utils::getLang($config['title']);
        $config['desc']       = Utils::getLang($config['desc']);
        $config['headers']    = Utils::getArrayLang($config['headers'], "desc");
        $config['parameters'] = Utils::getArrayLang($config['parameters'], "desc");
        $config['responses']  = Utils::getArrayLang($config['responses'], "desc");
        // 清除apps配置中的password
        $config['apps'] = (new Utils())->handleAppsConfig($config['apps'], true);

        return Utils::showJson(0, "", $config);
    }

    /**
     * 验证密码
     * @return false|\think\response\Json
     * @throws \think\Exception
     */
    public function verifyAuth()
    {
        $config = $this->config;

        $request  = request();
        $params   = $request->all('');
        $password = $params['password'];
        if (empty($password)) {
            throw new AuthException("password not found");
        }
        $appKey = ! empty($params['appKey']) ? $params['appKey'] : "";

        if ( ! $appKey && ! ( ! empty($config['auth']) && $config['auth']['enable'])) {
            return false;
        }
        try {
            $hasAuth = (new Auth())->verifyAuth($password, $appKey);
            $res     = [
                "token" => $hasAuth
            ];

            return Utils::showJson(0, "", $res);
        } catch (AuthException $e) {
            return Utils::showJson($e->getCode(), $e->getMessage());
        }
    }

    /**
     * 获取文档数据
     * @return \think\response\Json
     */
    public function getApidoc()
    {
        $config = $this->config;
        $params = request()->all();
        if ( ! empty($params['appKey'])) {
            // 获取指定应用
            $appKey = $params['appKey'];
        } else {
            // 获取默认控制器
            $default_app = $config = 'api';
            $appKey      = $default_app;
        }
        $currentApps = (new Utils())->getCurrentApps($appKey);
        $currentApp  = $currentApps[count($currentApps) - 1];

        (new Auth())->checkAuth($appKey);

        $cacheData = null;
        // 生成数据
        $apiData = (new ParseAnnotation())->renderApiData($appKey);

        // 接口分组
        if ( ! empty($currentApp['groups'])) {
            $data = (new ParseAnnotation())->mergeApiGroup($apiData['data'], $currentApp['groups']);
        } else {
            $data = $apiData['data'];
        }
        $groups = ! empty($currentApp['groups']) ? $currentApp['groups'] : [];
        $json   = [
            'data'   => $data,
            'app'    => $currentApp,
            'groups' => $groups,
            'tags'   => $apiData['tags'],
        ];

        return Utils::showJson(0, "", $json);

    }

    public function getMdMenus()
    {
        // 获取md
        $request = request();
        $params  = $request->all('');
        $lang    = "";

        if ( ! empty($params['appKey'])) {
            // 获取指定应用
            $appKey = $params['appKey'];
        } else {
            // 获取默认控制器
            $default_app = 'api';
            $appKey      = $default_app;
        }
        (new Auth())->checkAuth($appKey);

        $docs = (new ParseMarkdown())->getDocsMenu($lang);

        return Utils::showJson(0, "", $docs);

    }

    /**
     * 获取md文档内容
     * @return \think\response\Json
     */
    public function getMdDetail()
    {
        $request = request();
        $params  = $request->all('');

        try {
            if (empty($params['path'])) {
                throw new ErrorException("mdPath not found");
            }
            if (empty($params['appKey'])) {
                throw new ErrorException("appkey not found");
            }
            $lang = "";
            if ( ! empty($params['lang'])) {
                $lang = $params['lang'];
            }
            (new Auth())->checkAuth($params['appKey']);
            $content = (new ParseMarkdown())->getContent($params['appKey'], $params['path'], $lang);
            $res     = [
                'content' => $content,
            ];

            return Utils::showJson(0, "", $res);

        } catch (ErrorException $e) {
            return Utils::showJson($e->getCode(), $e->getMessage());
        }
    }

}
