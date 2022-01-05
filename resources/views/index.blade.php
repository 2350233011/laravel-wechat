<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Title</title>
    <link rel="stylesheet" href="home/css/amazeui.min.css"/>
    <link rel="stylesheet" href="home/css/jquery.sinaEmotion.css"/>
    <link rel="stylesheet" href="home/css/main.css"/>

</head>
<body>
<div class="box">
    <div class="wechat">
        <div class="sidestrip">
            <div class="am-dropdown" data-am-dropdown>
                <!--头像插件-->
                <div class="own_head am-dropdown-toggle"><img src="home/images/head/head.png" alt=""></div>
                <div class="am-dropdown-content">
                    <div class="own_head_top">
                        <div class="own_head_top_text">
                            <div class="own_name">
                                <div class="own_name_div">
                                    <p class="myname header_clickmengban" data-name="昵称" data-type="name"></p>
                                </div>
                                <img class="mysex" src="home/images/icon/sex1.png" alt=""/>
                            </div>
                            <p class="own_numb">微信号：<span class="mywechat"></span></p>
                        </div>
                        <div class="myheadimg_bg" id="upimg_log">
                            <img class="myheadimg" src="" alt=""/>
                        </div>
                        <input style="display: none" type="file" id="uploadimg" accept="image/*">
                    </div>
                    <div class="own_head_bottom">
                        <p>
                            <span>地区</span>
                            <span class="mydiqu header_clickmengban" data-name="地区" data-type="diqu"></span>
                        </p>
                        <div class="own_head_bottom_img">
                            <a href="javascript:;"><img src="home/images/icon/head_1.png" alt=""/></a>
                            <a href="javascript:;"><img src="home/images/icon/head_2.png" alt=""/></a>
                        </div>
                    </div>
                </div>
                <div class="header_textinput" style="display: none">
                    <div class="header_textinput_bg"></div>
                    <div class="header_textinput_content">
                        <h2 class="header_textinput_title">标题</h2>
                        <div class="header_textinput_text">
                            <textarea class="header_textinput_textarea" placeholder="请输入..."></textarea>
                            <button class="header_textinput_btn">确认</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--三图标-->
            <div class="sidestrip_icon">
                <a id="si_1" style="background: url(home/images/icon/head_2_1.png) no-repeat;"></a>
                <a id="si_2"></a>
                <a id="si_3"></a>
            </div>
            <!--底部扩展键-->
            <div id="doc-dropdown-justify-js">
                <div class="am-dropdown" id="doc-dropdown-js" style="position: initial;">
                    <div class="sidestrip_bc am-dropdown-toggle"></div>
                    <ul class="am-dropdown-content" style="">
                        <li>
                            <a href="#"
                               data-am-modal="{target: '#doc-modal-1', closeViaDimmer: 0, width: 400, height: 225}">意见反馈</a>
                            <div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
                                <div class="am-modal-dialog">
                                    <div class="am-modal-hd">Modal 标题
                                        <a href="javascript: void(0)" class="am-close am-close-spin"
                                           data-am-modal-close>&times;</a>
                                    </div>
                                    <div class="am-modal-bd">
                                        Modal 内容。本 Modal 无法通过遮罩层关闭。
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li><a href="#">备份与恢复</a></li>
                        <li><a href="#">设置</a></li>
                        <li><a href="javascript:;" class="qcsession">退出登录</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--聊天列表-->
        <div class="middle on">
            <div class="wx_search">
                <input type="text" placeholder="搜索"/>
                <button>+</button>
            </div>
            <div class="office_text">
                <ul class="user_list">

                </ul>
            </div>
        </div>
        <!--好友列表-->
        <div class="middle">
            <div class="wx_search">
                <input type="text" placeholder="搜索"/>
                <button>+</button>
            </div>
            <div class="office_text">
                <ul class="friends_list">
                    <li class="haoyouliebiao">
                        <p>A</p>


                    </li>
                </ul>
            </div>
        </div>
        <!--程序列表-->
        <div class="middle">
            <div class="wx_search">
                <input type="text" placeholder="搜索收藏内容"/>
                <button>+</button>
            </div>
            <div class="office_text">
                <ul class="icon_list">
                    <li class="icon_active">
                        <div class="icon"><img src="home/images/icon/icon.png" alt=""/></div>
                        <span>全部收藏</span>
                    </li>
                    <li>
                        <div class="icon"><img src="home/images/icon/icon1.png" alt=""/></div>
                        <span>链接</span>
                    </li>
                    <li>
                        <div class="icon"><img src="home/images/icon/icon2.png" alt=""/></div>
                        <span>相册</span>
                    </li>
                    <li>
                        <div class="icon"><img src="home/images/icon/icon3.png" alt=""/></div>
                        <span>笔记</span>
                    </li>
                    <li>
                        <div class="icon"><img src="home/images/icon/icon4.png" alt=""/></div>
                        <span>文件</span>
                    </li>
                    <li>
                        <div class="icon"><img src="home/images/icon/icon5.png" alt=""/></div>
                        <span>音乐</span>
                    </li>
                    <li>
                        <div class="icon"><img src="home/images/icon/icon6.png" alt=""/></div>
                        <span>标签</span>
                    </li>
                </ul>
            </div>
        </div>

        <!--聊天窗口-->
        <div class="talk_window_linshi"><img src="home/images/icon/wechat_bg.png" alt=""></div>
        <div class="talk_window" style="display: none">
            <div class="windows_top">
                <div class="windows_top_box">
                    <span class="lthy_name"></span>
                    <ul class="window_icon">
                        <li><a href="javascript:;"><img src="home/images/icon/icon7.png"/></a></li>
                        <li><a href="javascript:;"><img src="home/images/icon/icon8.png"/></a></li>
                        <li><a href="javascript:;"><img src="home/images/icon/icon9.png"/></a></li>
                        <li><a href="javascript:;"><img src="home/images/icon/icon10.png"/></a></li>
                    </ul>
                    <div class="extend am-btn am-btn-success" data-am-offcanvas="{target: '#doc-oc-demo3'}"></div>
                    <!--侧边栏内容-->
                    <div id="doc-oc-demo3" class="am-offcanvas">
                        <div class="am-offcanvas-bar am-offcanvas-bar-flip">
                            <div class="am-offcanvas-content">
                                <p><a href="javascript:;" class="qkliaotianjilu">清空好友聊天记录</a></p>
                                <p><a href="http://music.163.com/#/song?id=385554" target="_blank">网易音乐</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--聊天内容-->
            <div class="windows_body">
                <div class="office_text" style="height: 100%;">
                    <ul class="content" id="chatbox">

                    </ul>
                </div>
            </div>
            <div class="windows_input" id="talkbox">
                <div class="input_icon">
                    <a id="face" href="javascript:;"></a>
                    <a href="javascript:;"></a>
                    <a href="javascript:;"></a>
                    <a href="javascript:;"></a>
                    <a href="javascript:;"></a>
                    <a href="javascript:;"></a>
                </div>

                <div class="input_box">
                    <textarea class="emotion" name="" rows="" cols="" id="input_box"></textarea>
                    <button id="send">发送（S）</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="home/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="home/js/amazeui.min.js"></script>
<script type="text/javascript" src="home/js/zUI.js"></script>
<script type="text/javascript" src="home/js/message.js"></script>
<script type="text/javascript" src="home/js/cookie.js"></script>
<script type="text/javascript" src="home/js/jquery.sinaEmotion.js"></script>
<script type="text/javascript" src="home/js/wechat.js"></script>

<script type="text/javascript">
    let clickname = ""
    let oldtext = ""
    $(".header_clickmengban").click(function () {
        let name = $(this).attr('data-name')
        let text = oldtext = $(this).text()
        clickname = $(this).attr('data-type')
        $(".header_textinput_title").text(name)
        $(".header_textinput_textarea").val(text)
        $(".header_textinput").show()
        $(".header_textinput_textarea").focus()
    })
    $(".header_textinput_btn").click(function () {
        updata()
    })
    $('.header_textinput_textarea').on('keypress', function (e) {
        if (e.keyCode == '13') {  //按下回车
            e.preventDefault();
            updata()
        }
    })

    function updata() {
        let text = $(".header_textinput_textarea").val()
        text = text.replace(/<\/?[^>]*>/g, ''); //去除HTML tag
        text = text.replace(/[ | ]*\n/g, '\n'); //去除行尾空白
        text = text.replace(/\n[\s| | ]*\r/g, '\n'); //去除多余空行
        text = text.replace(/ /ig, '');//去掉
        text = text.replace(/^[\s　]+|[\s　]+$/g, "");//去掉全角半角空格
        text = text.replace(/[\r\n]/g, "");//去掉回车换行
        let data = {
            id: login.id,
            type: clickname,
            data: text
        }
        if (oldtext == text) {
            Message.success("更改成功", 600, function () {
                window.location.reload()
            })
            return
        }
        Ajax("post", "updatedata", data, function (res) {
            login[clickname] = res.data
            $.cookie('login', JSON.stringify(login), {expires: 7});
            Message.success("更改成功", 600, function () {
                window.location.reload()
            })
        })
    }

    $(".header_textinput_bg").click(function () {
        $(".header_textinput_title").text("标题")
        $(".header_textinput_textarea").val("")
        $(".header_textinput").hide()
    })

    $('#face').SinaEmotion($('.emotion'));
    //更换头像
    $("#upimg_log").click(function () {
        $("#uploadimg").click(); //隐藏了input:file样式后，点击头像就可以本地上传
    });
    $('#uploadimg').on("change", function () {
        let imgurl = getObjectURL(this.files[0]);
        let objUrl = upimg($('#uploadimg'));
        if (objUrl) {
            $(".myheadimg").attr("src", imgurl); //将图片路径存入src中，显示出图片
            $(".own_head img").attr("src", imgurl)
            login.img = objUrl
            $.cookie('login', JSON.stringify(login), {expires: 7});
            Message.success("更换成功", 1000, function () {
                window.location.reload()
            })
        }
    });

    //三图标
    window.onload = function () {
        function a() {
            let si1 = document.getElementById('si_1');
            let si2 = document.getElementById('si_2');
            let si3 = document.getElementById('si_3');
            si1.onclick = function () {
                si1.style.background = "url(home/images/icon/head_2_1.png) no-repeat"
                si2.style.background = "";
                si3.style.background = "";
            };
            si2.onclick = function () {
                si2.style.background = "url(home/images/icon/head_3_1.png) no-repeat"
                si1.style.background = "";
                si3.style.background = "";
            };
            si3.onclick = function () {
                si3.style.background = "url(home/images/icon/head_4_1.png) no-repeat"
                si1.style.background = "";
                si2.style.background = "";
            };
        };
        a();
    };
    //底部扩展键
    $(function () {
        $('#doc-dropdown-js').dropdown({justify: '#doc-dropdown-justify-js'});
    });
    $(document).ready(function () {
        $(".sidestrip_icon a").click(function () {
            $(".sidestrip_icon a").eq($(this).index()).addClass("cur").siblings().removeClass('cur');
            $(".middle").hide().eq($(this).index()).show();
        });
    });
    $(document).ready(function () {
        $("#face").click(function () {
            $("#input_box").focus()
        })
        $("#input_box").focus(function () {
            $('.windows_input').css('background', '#FFFFFF');
            $('#input_box').css('background', '#FFFFFF');
        }).blur(function () {
            $('.windows_input').css('background', '');
            $('#input_box').css('background', '');
        });
    });
</script>
</body>
</html>
