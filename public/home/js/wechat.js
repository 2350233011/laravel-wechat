// 创建对象
let ws
let login
let nowId = "" // 当前id
let friendarr = [] // 好友列表
let friendonline = [] // 好友在线列表
$(function () {
    // 判断是否登录
    if ($.cookie('login')) {
        login = JSON.parse($.cookie('login'))
        // 建立WebSocket链接
        ws = new WebSocket('ws://localhost:8282')
        let data = {
            type: "login", userdata: login,
        }
        let data3 = {
            type: "alluid", userdata: login,
        }
        // WebSocket链接建立成功时发送登录
        ws.onopen = function () {
            wssend(ws, data)
            wssend(ws, data3);
        }
        // 填充页面数据
        $(".myheadimg").attr("src", "home/images/head/" + login.img)
        $(".own_head img").attr("src", "home/images/head/" + login.img)
        $(".mysex").attr("src", "home/images/icon/sex" + login.sex + ".png")
        $(".myname").text(login.name)
        $(".myname_span").text(login.name)
        $(".mywechat").text(login.wechat)
        $(".mydiqu").text(login.diqu)
    } else {
        Message.info("请先登录")
        setTimeout(function () {
            window.location.href = "login"
        }, 1000)
    }

    // WebSocket接收消息
    ws.onmessage = function (res) {
        let data = JSON.parse(res.data)
        switch (data.type) {
            // 个人
            case "toid":
                console.log(data);
                if (data.byid == nowId) {
                    if (data.texttype == "text") {
                        answers(data, true)
                    } else {
                        // answers2(data, true)
                    }
                } else {
                    //消息红点
                    if (data.texttype == "text") {
                        let usershow = ".usershowid_" + data.byid;
                        $(usershow).addClass("user_list_show")
                        answers(data, false);
                    } else {
                        // answers2(data, false)
                    }
                }
                break;
            // 有人上线
            case "login":
                // 判断不是自己并且在线列表中没有
                if (friendonline.indexOf(data['id']) == -1 && data["id"] != login.id) {
                    friendonline.push(data["id"])
                    showfriendlist(friendarr, friendonline)
                    console.log(friendonline)
                }
                // 打开了当前好友的窗口
                if (nowId == data["id"]) {
                    $(".lthy_name").removeClass("isonline")
                }
                // 好友列表没有这个人(新注册的)
                if (findindexOf(friendarr, "id", data["id"]) == -1 && data["id"] != login.id) {
                    let data2 = {
                        id: login.id
                    }
                    Ajax("post", "querydata", data2, function (res) {
                        friendarr = res.data
                        showfriendlist(friendarr, friendonline)
                        let html2 = ""
                        for (let i = 0; i < friendarr.length; i++) {
                            html2 += `<div class="friends_box"><div class="user_head"><img src="home/images/head/${friendarr[i]['img']}"/></div>
                                <div class="friends_text"><p class="user_name">${friendarr[i]['name']}</p></div></div>`
                        }
                        $(".haoyouliebiao").append(html2)
                    })
                }
                break;
            // 有人下线
            case "logout":
                // 当前在在线好友列表中
                if (friendonline.indexOf(data['id']) !== -1) {
                    friendonline.splice(friendonline.indexOf(data['id']), 1)
                    showfriendlist(friendarr, friendonline)
                    console.log(friendonline)
                }
                if (nowId == data["id"]) $(".lthy_name").addClass("isonline")
                break;
            // 获取在线好友
            case "alluid":
                friendonline = data.alluid.map(Number)
                if ($.cookie('userlist')) {
                    friendarr = JSON.parse($.cookie('userlist'));
                    showfriendlist(friendarr, friendonline)
                }
                setTimeout(function () {
                    console.log('网络');
                    let data2 = {
                        id: login.id
                    }
                    Ajax("post", "querydata", data2, function (res) {
                        $.cookie('userlist', JSON.stringify(res.data), {expires: 7});
                        friendarr = res.data
                        showfriendlist(friendarr, friendonline)
                        let html2 = ""
                        for (let i = 0; i < friendarr.length; i++) {
                            html2 += `<div class="friends_box"><div class="user_head"><img src="home/images/head/${friendarr[i]['img']}"/></div>
                        <div class="friends_text"><p class="user_name">${friendarr[i]['name']}</p></div></div>`
                        }
                        $(".haoyouliebiao").append(html2)
                    })
                }, 500)

                break;
            // 所有
            case "toall":
                console.log(data)
                break;
        }
    }

    //WebSocket连接关闭时的消息
    ws.onclose = function () {
        console.log("WebSocket连接关闭");
    }

})
//发送消息
$("#send").click(function () {
    send()
})
$('#input_box').on('keypress', function (e) {
    if (e.keyCode == '13') {  //按下回车
        e.preventDefault();
        send()
    }
})
//退出登录
$('.qcsession').click(function () {
    let data = {
        type: "logout", userdata: login,
    }
    wssend(ws, data)
    $.removeCookie("login")
    Message.success("退出成功", 600, function () {
        wsclose(ws)
        window.location.href = "login"
    })
})
//清空聊天记录
$('.qkliaotianjilu').click(function () {
    let data = {
        byid: login.id, toid: nowId,
    }
    Ajax("post", "delchatrecord", data, function () {
        Message.success("清空成功", 1000, function () {
            window.location.reload()
        })
    })
})
//点击切换聊天好友
$('body').on("click", ".user_list li", function () {
    nowId = $(this).attr("data-id")
    let isline = $(this).attr("data-isline")
    let text_name = ""
    if (isline == 0) {
        $(".lthy_name").addClass("isonline")
    } else {
        $(".lthy_name").removeClass("isonline")
    }
    $(".lthy_name").html($(this).find(".user_name").text() + "<span class='isline_name'>( 不在线 )</span>")
    let html = ``
    let data = {
        byid: login.id,
        toid: nowId
    }
    Ajax("post", "querychatrecord", data, function (res) {
        let data = res.data
        for (let i = 0; i < data.length; i++) {
            if (data[i].byid == login.id) {
                html += `<li class="me"><span>${AnalyticEmotion(data[i].text)}</span><img src="home/images/head/${login.img}"></li>`;
            } else {
                html += `<li class="other"><img src="home/images/head/${data[i].img}"><span>${AnalyticEmotion(data[i].text)}</span></li>`;
            }
        }
    }, "", false)
    $("#chatbox").html(html)
    $(this).addClass("user_active").siblings().removeClass("user_active")
    $(this).removeClass("user_list_show")
    $(".talk_window_linshi").hide()
    $(".talk_window").show()
    //将滚动条始终保持在底部
    $('.office_text').scrollTop($('.office_text')[0].scrollHeight);
})

// 显示好友列表
function showfriendlist(arr, alluid, nowtopid) {
    let html = ""
    let zaixian = []
    let buzaixian = []
    for (let i = 0; i < arr.length; i++) {
        if (alluid.indexOf(arr[i]['id']) == -1) {
            //不在线
            buzaixian.push(arr[i])
        } else {
            zaixian.push(arr[i])
        }
    }
    arr = zaixian.concat(buzaixian)
    if (nowtopid) {
        let index = findindexOf(arr, 'id', nowtopid)
        let linshiarr = arr[index]
        arr.splice(index, 1);
        arr.unshift(linshiarr);
    }
    for (let i = 0; i < arr.length; i++) {
        html += `<li class="usershowid_${arr[i]['id']} ${alluid.indexOf(arr[i]['id']) == -1 ? 'isonline' : ''} ${arr[i]['id'] == nowId ? 'user_active' : ''}"
      data-id="${arr[i]['id']}" data-isline="${alluid.indexOf(arr[i]['id']) == -1 ? '0' : '1'}">
      <div class="user_head"><img class="gray" src="home/images/head/${arr[i]['img']}" alt=""/></div>
      <div class="user_text"><p class="user_name">${arr[i]['name']}</p>
      <p class="user_message">${arr[i]['chatrecord'] ? arr[i]['chatrecord']['text'] : ''}</p></div>
      <div class="user_time">${gettime(arr[i]['chatrecord'] ? arr[i]['chatrecord']['date'] : '')}</div>
      <div class="hongdian"></div></li>`;
    }
    $(".user_list").html("")
    $(".user_list").append(html)
}

// 发送消息
function send() {
    let text = document.getElementById('input_box');
    let chat = document.getElementById('chatbox');
    let talk = document.getElementById('talkbox');

    if (text.value == '') {
        Message.info("不能发送空消息");
    } else {
        let data = {
            type: "toid",
            texttype: "text",
            toid: nowId,
            time: new Date().getTime(),
            data: text.value,
            byid: login.id
        }
        wssend(ws, data);
        Ajax("post", "insertdata", data, function (res) {
            console.log(res)
        })
        chat.innerHTML += `<li class="me"><span>${AnalyticEmotion(text.value)}</span><img src="home/images/head/${login.img}"></li>`;
        text.value = '';
        text.innerHTML = '';
        chat.scrollTop = chat.scrollHeight;
        talk.style.background = "#FFFFFF";
        text.style.background = "#FFFFFF";
        let message = ".usershowid_" + nowId + " .user_message"
        let user_time = ".usershowid_" + nowId + " .user_time"
        $(message).text(data.data)
        $(user_time).text(gettime())
        for (let i = 0; i < friendarr.length; i++) {
            if (friendarr[i]['id'] == nowId) {
                friendarr[i]['chatrecord']['text'] = data.data
            }
        }
        showfriendlist(friendarr, friendonline, nowId)
        //将滚动条始终保持在底部
        $('.office_text').scrollTop($('.office_text')[0].scrollHeight);
    }
}

//回复
function answers(res, isnow) {
    let message = ".usershowid_" + res.byid + " .user_message"
    let user_time = ".usershowid_" + res.byid + " .user_time"
    $(message).text(res.data)
    $(user_time).text(gettime(res.time))
    if (isnow) {
        let answer = '';
        answer += `<li class="other"><img src="home/images/head/${res.userdata.img}"><span>${AnalyticEmotion(res.data)}</span></li>`;
        $('#chatbox').append(answer);
        //将滚动条始终保持在底部
        $('.office_text').scrollTop($('.office_text')[0].scrollHeight);
    }
}

function gettime(time) {
    if (!time) {
        return ""
    }
    let date = new Date(time)
    let curDate = new Date()
    let year = date.getFullYear(), month = date.getMonth() + 1,
        day = date.getDate(), hour = date.getHours(), minute = date.getMinutes(), curYear = curDate.getFullYear(),
        curHour = curDate.getHours(), timeStr;
    if (year < curYear) {
        timeStr = year + '年' + month + '月' + day + '日 ' + hour + ':' + minute;
    } else {
        let pastTime = curDate - date, pastH = pastTime / 3600000;

        if (pastH > curHour) {
            timeStr = month + '月' + day + '日 ' + hour + ':' + minute;
        } else if (pastH >= 1) {
            timeStr = '今天 ' + hour + ':' + minute + '分';
        } else {
            let pastM = curDate.getMinutes() - minute;
            if (pastM > 1) {
                timeStr = pastM + '分钟前';
            } else {
                timeStr = '刚刚';
            }
        }
    }
    return timeStr;
}

//上传头像到服务器
function upimg(upimg) {
    let pic = upimg[0].files[0];
    let file = new FormData();
    file.append('id', login.id);
    file.append('img', login.img);
    file.append('file', pic);
    let data_url = null
    $.ajax({
        url: "index/upimg",
        type: "post",
        data: file,
        cache: false,
        async: false,
        contentType: false,
        processData: false,
        success: function (res) {
            let data = JSON.parse(res)
            if (data.code == 1) {
                data_url = data.data
            }
        }
    });
    return data_url
}

//建立一可存取到file的url
function getObjectURL(file) {
    let url = null;
    if (window.createObjectURL != undefined) { // basic
        url = window.createObjectURL(file);
    } else if (window.URL != undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file);
    } else if (window.webkitURL != undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file);
    }
    return url;
}

// 封装ajax
function Ajax(method, url, data, callback, errFun, async = true) {
    $.ajax({
        url: "index/" + url,
        method: method,
        header: {'content-type': 'application/x-www-form-urlencoded'},
        data: data,
        timeout: 30000,
        async: async,
        success: function (res) {
            let data = JSON.parse(res)
            if (data.code == "1") {
                callback(data);
            } else if (data.code == 0) {
                console.log(data.msg)
            }
        },
        fail: function (err) {
            errFun(err)
            console.log(err);
        }
    })
}

// 查找数组
function findindexOf(arr, key, val) {
    for (let i = 0; i < arr.length; i++) {
        if (arr[i][key] == val) {
            return i
        }
    }
    return -1
}

function wssend(ws, data) {
    ws.send(JSON.stringify(data))
}

function wsclose(ws) {
    ws.close();
}
