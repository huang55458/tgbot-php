<?php

/**
 * 发消息
 * User: dray
 * Date: 15/7/10
 * Time: 下午5:22
 */

require_once LIB_PATH . 'common.php';

class telegram
{

    private static $instance = array();
    private $token;

    /**
     * @param null $user_id
     */
    private function __construct($token)
    {
        if (null === $token) {
            throw new Exception('error token');
        }

        $this->token = $token;
    }

    /**
     * @param null $token
     * @return Telegram
     */
    public static function singleton($token = null)
    {
        if (null === $token) {
            $token = Common::get_config('token');
            if (empty($token)) {
                throw new Exception('error token');
            }
        }

        if (!isset(self::$instance[$token])) {
            self::$instance[$token] = new self($token);
        }

        return self::$instance[$token];
    }

    /**
     * 得到机器人的信息
     * @return array
     */
    public function get_me()
    {
        $url = "https://api.telegram.org/bot{$this->token}/getMe";
        $res = Common::curl($url, array());

        if ($res['ok'] == true) {
            $bot_info = $res['result'];
        } else {
            return null;
        }

        if (isset($bot_info['first_name'])) {
            $bot_info['show_name'] = $bot_info['first_name'];
            if (isset($bot_info['last_name'])) {
                $bot_info['show_name'] .= ('_' . $bot_info['last_name']);
            }
        } else {
            $bot_info['show_name'] = $bot_info['username'];
        }

        return $bot_info;
    }

    /**
     * 请求最新消息
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function get_updates($data)
    {
        $url = "https://api.telegram.org/bot{$this->token}/getUpdates";
        $res = Common::curl($url, $data);

        if ($res['ok'] == true) {
            return $res['result'];
        }

        return null;
    }

    /**
     * 发送消息
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function send_message($data)
    {
        $url = "https://api.telegram.org/bot{$this->token}/sendMessage";
        $res = Common::curl($url, $data);

        if ($res['ok'] == true) {
            return $res['result'];
        }

        return null;
    }
}
