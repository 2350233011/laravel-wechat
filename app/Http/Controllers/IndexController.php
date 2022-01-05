<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * 登录
     */
    public function login(Request $request)
    {
        $post = $request->input();
        $username = $post['username'];
        $pass = $post['pass'];

        $user1 = DB::table("user")->where('username', $username)->first();
        if ($user1) {
            $user2 = DB::table("user")->where('username', $username)->where('pass', $pass)->first();
            if ($user2) {
                $res = array('code' => 1, 'msg' => '成功', 'data' => $user2);
            } else {
                $res = array('code' => 0, 'msg' => '密码错误', 'data' => "");
            }
        } else {
            $res = array('code' => 0, 'msg' => '用户不存在', 'data' => "");
        }
        echo json_encode($res);
    }

    /**
     * 注册
     */
    public function register(Request $request)
    {
        $post = $request->input();

        $username = $post['username'];
        $pass = $post['pass'];
        $name = $post['name'];
        $num = mt_rand(1, 3);
        $img = "head(" . $num . ").png";
        $wechat = $post['wechat'];
        $diqu = $post['diqu'];
        $sex = $post['sex'];

        $user1 = DB::table("user")->where('username', $username)->first();
        if (!$user1) {
            $user2 = DB::table('user')->insert([
                'username' => $username,
                'pass' => $pass,
                'name' => $name,
                'img' => $img,
                'wechat' => $wechat,
                'diqu' => $diqu,
                'sex' => $sex
            ]);
            if ($user2) {
                $res = array('code' => 1, 'msg' => '注册成功', 'data' => $user2);
            } else {
                $res = array('code' => 0, 'msg' => '注册失败请稍后重试', 'data' => "");
            }
        } else {
            $res = array('code' => 401, 'msg' => '用户已注册请登录', 'data' => "");
        }
        echo json_encode($res);
    }

    /**
     * 获取好友列表
     */
    public function querydata(Request $request)
    {
        $post = $request->input();

        $byid = $post["id"];
        $data = json_decode(json_encode(DB::table("user")->where('id', '!=', $byid)->get()), true);
        $chatdata = json_decode(json_encode(DB::select('select * from chatrecord where byid in(select byid from chatrecord where byid = 1 or toid = 1 group by byid)and date in (select max(date) from chatrecord where byid = 1 or toid = 1 group by byid)order by date')), true);

        if ($data) {
            foreach ($data as $k => $v) {
                $toid = $v['id'];
                $data1 = foreachindex($chatdata, $byid, $toid);
                if ($data1) {
                    $v['chatrecord'] = $data1 ? $data1 : '';
                    $v['newtime'] = $data1['date'] ? $data1['date'] : '';
                } else {
                    $v['chatrecord'] = '';
                    $v['newtime'] = '';
                }
                $tmp[$k] = $v['newtime'];
                $data[$k] = $v;
            }
            array_multisort($tmp, SORT_DESC, $data); //此处对数组进行降序排列；SORT_DESC按降序排列
            $res = array('code' => 1, 'msg' => '成功', 'data' => $data);
        } else {
            $res = array('code' => 0, 'msg' => '没有好友', 'data' => "");
        }
        echo json_encode($res);
    }

    /**
     * 查找聊天记录
     */
    public function querychatrecord(Request $request)
    {
        $post = $request->input();

        $byid = $post["byid"];
        $toid = $post["toid"];

        $data = DB::table("chatrecord as c")
            ->join('user as u', 'u.id', '=', 'c.byid')
            ->where([
                ['byid', '=', $byid],
                ['toid', '=', $toid],
                ['byisdel', '=', 0],])
            ->orWhere([
                ['byid', '=', $toid],
                ['toid', '=', $byid],
                ['toisdel', '=', 0],])
            ->select('c.*', 'u.img')
            ->orderBy('date', 'asc')
            ->get();
        if ($data) {
            $res = array('code' => 1, 'msg' => '成功', 'data' => $data);
        } else {
            $res = array('code' => 0, 'msg' => '错误', 'data' => "");
        }
        echo json_encode($res);
    }

    /**
     * 插入聊天记录
     */
    public function insertdata(Request $request)
    {
        $post = $request->input();

        $byid = $post["byid"];
        $toid = $post["toid"];
        $text = $post["data"];

        $data = DB::table("chatrecord")->insert([
            'byid' => $byid,
            'toid' => $toid,
            'text' => $text,
        ]);

        if ($data) {
            $res = array('code' => 1, 'msg' => '成功', 'data' => $data);
        } else {
            $res = array('code' => 0, 'msg' => '错误', 'data' => "");
        }
        echo json_encode($res);
    }

    /**
     * 删除聊天记录
     */
    public function delchatrecord(Request $request)
    {
        $post = $request->input();

        $byid = $post["byid"];
        $toid = $post["toid"];

        $data1 = DB::table("chatrecord")
            ->where([
                ['byid', '=', $byid],
                ['toid', '=', $toid],])
            ->update(['byisdel' => '1']);
        $data2 = DB::table("chatrecord")
            ->where([
                ['byid', '=', $toid],
                ['toid', '=', $byid],])
            ->update(['toisdel' => '1']);

        $res = array('code' => 1, 'msg' => '成功', 'data' => $data2);
        echo json_encode($res);
    }

    /**
     * 上传头像
     */
    public function upimg(Request $request)
    {
        $post = $request->input();

        $id = $post["id"];
        $tmp = $_FILES['file']['tmp_name'];
        $filepath = 'home/images/head/';
        $name = "head" . $id . ".png";

        if (move_uploaded_file($tmp, $filepath . $name)) {
            $res = ['code' => 1, 'msg' => '图片上传成功', 'data' => $name];
        } else {
            $res = ['code' => 0, 'msg' => '失败'];
        }
        echo json_encode($res);
    }

    /**
     * 更新数据库
     */
    public function updatedata(Request $request)
    {
        $post = $request->input();

        $id = $post["id"];
        $type = $post["type"];
        $text = $post["data"];

        $data = DB::table("user")->where(['id' => $id])->update([$type => $text]);

        if ($data) {
            $res = ['code' => 1, 'msg' => '成功', 'data' => $text];
        } else {
            $res = ['code' => 0, 'msg' => '失败'];
        }
        echo json_encode($res);
    }

}

/**
 * 查找第一条聊天记录
 */
function foreachindex($arr, $byid, $toid)
{
    foreach ($arr as $k => $v) {
        if ($v['byid'] == $byid || $v['byid'] == $toid) {
            return $v;
        }
    }
    return false;
}
