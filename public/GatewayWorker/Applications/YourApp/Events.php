<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */

//declare(ticks=1);

use \GatewayWorker\Lib\Gateway;
use \GatewayWorker\Lib\Db;


/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     *
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        $db = Db::instance('db');
        //数据库插入语句
        $data = $db->query("SELECT * FROM user");

        // 向当前client_id发送数据
        Gateway::sendToClient($client_id, json_encode($data));
    }

    /**
     * 当客户端发来消息时触发
     * @param int $client_id 连接id
     * @param mixed $message 具体消息
     * @throws Exception
     */
    public static function onMessage($client_id, $message)
    {
        $message = json_decode($message, true);
        if (!$message) {
            return;
        };
        $id = $message['userdata']['id'];
        $type = $message['type'];
        switch ($type) {
            case "login":
                Gateway::bindUid($client_id, $id);
                //Gateway::setSession($client_id, array('userdata' => $message['userdata']));
                $data = array(
                    'id' => $id,
                    'type' => 'login',
                    'data' => '上线了'
                );
                Gateway::sendToAll(json_encode($data));
                break;
            case "toid":
                $text = $message['data'];
                $toid = $message['toid'];
                $time = $message['time'];
                $texttype = $message['texttype'];
                $userdata = $message['userdata'];
                $data = array(
                    'byid' => $id,
                    'type' => $type,
                    'time' => $time,
                    'texttype' => $texttype,
                    'data' => $text,
                    'userdata' => $userdata
                );
                // 向id发送
                // 如果不在线就先存起来
                if (!Gateway::isUidOnline($id)) {
                    // 假设有个your_store_fun函数用来保存未读消息(这个函数要自己实现)
                    your_store_fun(json_encode($data));
                } else {
                    Gateway::sendToUid($toid, json_encode($data));
                }
                break;
            case "alluid":
                $uidarr = Gateway::getAllUidList();
                $arr = array();
                foreach ($uidarr as $k) {
                    if ($k != $id) {
                        $arr[] = $k;
                    }
                }
                $data = array(
                    'type' => $type,
                    'alluid' => $arr
                );
                Gateway::sendToClient($client_id, json_encode($data));
                break;
            case "logout":
                $data = array(
                    'id' => $id,
                    'type' => 'logout',
                    'data' => '下线了'
                );
                Gateway::sendToAll(json_encode($data));
                break;
            case "toall":
                $text = $message['data'];
                $data = array(
                    'byid' => $id,
                    'type' => $type,
                    'data' => $text
                );
                // 向所有人发送
                Gateway::sendToAll(json_encode($data));
                break;
        };
    }

    /**
     * 当用户断开连接时触发
     * @param int $client_id 连接id
     */
    // public static function onClose($client_id)
    // {}
}
