<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="home/js/jquery-1.12.4.min.js"></script>
    <script src="home/js/message.js"></script>
    <script src="home/js/cookie.js"></script>
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        a, a:active, a:focus, a:hover, a:visited {
            text-decoration: none;
            color: #000000;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
        .login {
            margin: 100px auto;
            width: 400px;
            padding: 20px;
            border: 1px solid gainsboro;
            border-radius: 10px;
            background: #FFFFFF
        }
        input {
            width: 100%;
            height: 50px;
            margin-bottom: 10px;
            padding: 0 20px;
            border-radius: 5px;
            border: 1px solid gainsboro;
        }
        .login_btn {
            margin: 20px auto;
            width: 50%;
            display: block;
            height: 40px;
            border-radius: 5px;
            border: 1px solid gainsboro;
            cursor: pointer;
        }
        .login_title {
            margin: 0 auto 30px;
            font-size: 28px;
            text-align: center;
            font-weight: 500
        }
        .login_text {
            display: flex;
            justify-content: space-between;
            margin: 10px 0
        }
        .login_text a {
            font-size: 18px;
        }
        body {
            background-size: 100% 100%;
            margin: 0;
            padding: 0;
            height: 100vh;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        ::-webkit-scrollbar {
            width: 5px;
        }
        /* 这是针对缺省样式 (必须的) */
        ::-webkit-scrollbar-track {
            background-color: rgba(0, 0, 0, 0);
            border-radius: 10px;
        }
        /* 滚动条的滑轨背景颜色 */
        ::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        /* 滑块颜色 */
        ::-webkit-scrollbar-button {
            background-color: rgba(0, 0, 0, 0);
            height: 0;
        }
        /* 滑轨两头的监听按钮颜色 */
        ::-webkit-scrollbar-corner {
            background-color: black;
        }
        /* 横向滚动条和纵向滚动条相交处尖角的颜色 */
        .box {
            background-image: url(home/images/bg.jpg);
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
            background-position: center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="box">
    <div class="login">
        <h3 class="login_title">登录</h3>
        <input name="username" class="username" type="text" value="" placeholder="账号" autocomplete="off">
        <input name="pass" class="pass" type="password" value="123456" placeholder="密码">
        <div class="login_text"><a href="{{url('register')}}">注册</a></div>
        <button class="login_btn">登录</button>
    </div>
</div>
<script>
    $(function () {
        $(".login_btn").click(function (e) {
            login_fun()
        })
        $('input').on('keypress', function (e) {
            if (e.keyCode == '13') {  //按下回车
                e.preventDefault();
                login_fun()
            }
        })
    })

    function login_fun() {
        let username = $(".username").val()
        let pass = $(".pass").val()
        $.ajax({
            url: "{{url('login/dologin')}}",
            method: "post",
            data: {
                username: username,
                pass: pass
            },
            success: function (res) {
                let data = JSON.parse(res)
                if (data.code == 1) {
                    $.cookie('login', JSON.stringify(data.data), {expires: 7});
                    Message.success("登录成功", 600, function () {
                        window.location.href = "{{url('index')}}"
                    })
                } else if (data.code == 0) {
                    alert(data.msg)
                }
            }
        });
    }
</script>

</body>

</html>
