@extends('czf.base',['header'=>' 用户设置',
'css' => [
       'http://at.alicdn.com/t/font_1300674_bwcd8riknaj.css',
        'css/weui.min.css',
        'css/jquery-weui.min.css',
        'css/demos.css',
    ],
'js' => [
        'js/fastclick.js',
        'js/jquery-weui.min.js',
        'js/swiper.min.js',
        'js/city-picker.min.js'
    ]
])
@section('content')
    <style>
        .weui-btn_primary {
            background: #07C160;
        }
        .weui-label{
            font-size: 14px;
            color: #666;
            font-weight: bold;
        }
        .weui-cells{
            font-size: 14px;
            color: #666;
            font-weight: bold;
        }
        #set_value input {
            color: #666;
        }

        .weui-btn {
            width: 90% !important;
        }
    </style>
    <body>
    <!--头部-->
    <div class="weui-flex" id="header_top">
        <a href="{{route('member_index')}}"><img src="{{route('home')}}/img/fh.png" alt=""></a>
        <div class="weui-flex__item">用户设置</div>
    </div>

    <!--设置-->
    <div class="weui-cells weui-cells_form" id="set_value">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">头像</label></div>
            <div class="weui-cell__bd">
                <img style="width: 40px;float: right;border-radius: 50%" src="{{route('home')}}/img/logo.png" alt="">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">真实姓名</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" name="name" id="name" @if(!empty($member['name'])) value="{{$member['name']}}" @endif placeholder="请输入真实姓名">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">我的手机号</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="phone" id="phone" @if(!empty($member['phone'])) value="{{$member['phone']}}" @endif type="tel" placeholder="请输入手机号">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">联系微信</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="wechat" id="wechat" @if(!empty($member['wechat'])) value="{{$member['wechat']}}" @endif type="text" placeholder="请输入微信号">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">联系手机</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="phone2" id="phone2" @if(!empty($member['phone2'])) value="{{$member['phone2']}}" @endif type="tel" placeholder="请输入手机号">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">修改密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="password1" id="password1"  type="password" placeholder="不填默认原始密码">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" name="password2" id="password2" type="password" placeholder="请输入密码(字母+数字  9-18位)">
            </div>
        </div>

    </div>
    <div class="weui-flex" style="margin-top: 20px;">
        <div class="weui-flex__item"><a href="javascript:;" id="sub_but" style="    font-size: 16px; height: 45px; line-height: 45px;" class="weui-btn weui-btn_primary">提交</a></div>
    </div>

    <form action="{{route('logout')}}" method="POST" >
        @csrf
    <div class="weui-flex" style="margin-top: 20px;">
        <div class="weui-flex__item"><input type="submit" value="注销登陆" style="    font-size: 16px;width: 90%;  height: 45px;  text-align: center;  margin: 0 auto; display: block; border: none;background: red; color: #fff; border-radius: 5px;"></div>
    </div>
    </form>
    <script>
        $(function () {
            @if($errors->has('member'))
                $.toast("{{$errors->get('member')[0]}}", 'text');
            @endif
            $('#sub_but').click(function () {
                // 验证姓名
                var name = $('#name').val();
                var phone = $('#phone').val();
                var phone2 = $('#phone2').val();
                var wechat = $('#wechat').val();
                var pw1 = $('#password1').val();
                var pw2 = $('#password2').val();
                var reg = new RegExp(/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/);
                if (name == '') {
                    $.toast("真实姓名不能为空", "text");
                    return false;
                } else if (!(/^1[3456789]\d{9}$/.test(phone))) {// 验证手机号
                    $.toast("我的手机号有误", "text");
                    return false;
                } else if (!(/^1[3456789]\d{9}$/.test(phone2))) {
                    $.toast("联系手机有误", "text");
                    return false;
                } else if (wechat == '') { // 验证联系微信
                    $.toast("联系微信不能为空", "text");
                    return false;
                } else if (pw1.length < 8 && pw1 != '') {
                    $.toast("密码必须8位以上", "text");
                    return false;
                } else if (!reg.test(pw1) && pw1 != '') {
                    $.toast("密码必须包含数字和字母", "text");
                    return false;
                } else if (pw1 != pw2) {
                    $.toast("输入密码不一致", "text");
                    return false;
                }
                // 递交数据
                $.ajax({
                    url: "{{route('setUser')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        name: name,
                        phone: phone,
                        phone2: phone2,
                        wechat: wechat,
                        pw1: pw1,
                        _method: 'post',
                        _token: "{{csrf_token()}}"
                    },
                    error: function (data) {
                        $.toast("服务器繁忙, 请联系管理员！", 'text');
                        return;
                    },
                    success: function (result) {
                        if(result.code == 200) {
                            $.toast('设置成功！', 'text');
                            window.location.href = "{{request()->input('url')?? route('home')}}";
                        }
                         else
                            $.toast(result.message, 'text');
                    },
                })


            });
        })
    </script>
    </body>
@endsection
