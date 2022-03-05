<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>可立刻合同系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="可立刻合同系统">
    <meta name="description" content="可立刻合同系统">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="/css/okadmin.css">
</head>
<body class="layui-layout-body">
    <!-- 更换主体 Eg:orange_theme|blue_theme -->
    <div class="layui-layout layui-layout-admin okadmin blue_theme">
        <!--头部导航-->
        <div class="layui-header okadmin-header">
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item">
                    <a class="ok-menu ok-show-menu" href="javascript:" title="菜单切换">
                        <i class="layui-icon layui-icon-shrink-right"></i>
                    </a>
                </li>
                <!--天气信息-->
                <!--
                <li class="ok-nav-item ok-hide-md">
                    <div class="weather-ok">
                        <iframe frameborder="0" scrolling="no" class="iframe-style" src="pages/weather.html" frameborder="0"></iframe>
                    </div>
                </li>
                 -->
            </ul>
            <ul class="layui-nav layui-layout-right">
                <!-- <li class="layui-nav-item ok-input-search">
                    <input type="text" placeholder="搜索..." class="layui-input layui-input-search"/>
                </li> -->
                <li class="layui-nav-item">
                    <a class="ok-refresh" href="javascript:" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
                <li class="no-line layui-nav-item layui-hide-xs">
                    <a id="notice" class="flex-vc pr10 pl10" href="javascript:">
                        <i class="ok-icon ok-icon-notice icon-head-i" title="系统公告"></i>
                        <span class="layui-badge-dot"></span>
                        <cite></cite>
                    </a>
                </li>

                <li class="no-line layui-nav-item layui-hide-xs">
                    <a id="lock" class="flex-vc pr10 pl10" href="javascript:">
                        <i class="ok-icon ok-icon-lock icon-head-i" title="锁屏"></i><cite></cite>
                    </a>
                </li>

	              <!-- 全屏 -->
                <li class="layui-nav-item layui-hide-xs">
                    <a id="fullScreen" class=" pr10 pl10" href="javascript:">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>

                <li class="no-line layui-nav-item">
                    <a href="javascript:">
                        <img src="/images/avatar.png" class="layui-nav-img">
                        bobi
                    </a>
                    <dl id="userInfo" class="layui-nav-child">
                        <!-- <dd><a lay-id="u-1" href="javascript:" data-url="pages/member/user.html">个人中心<span class="layui-badge-dot"></span></a></dd> -->
                        <dd><a lay-id="u-2" href="javascript:" data-url="pages/member/user-info.html">基本资料</a></dd>
                        <dd><a lay-id="u-3" href="javascript:" data-url="pages/member/user-pwd.html">安全设置</a></dd>
                        <!-- <dd><a lay-id="u-4" href="javascript:" id="alertSkin">皮肤动画</a></dd> -->
                        <dd>
                            <hr/>
                        </dd>
                        <dd><a href="javascript:void(0)" id="logout">退出登录</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
        <!--遮罩层-->
        <div class="ok-make"></div>
        <!--左侧导航区域-->
        <div class="layui-side layui-side-menu okadmin-bg-20222A ok-left">
            <div class="layui-side-scroll okadmin-side">
                <div class="okadmin-logo">可立刻合同系统</div>
                <div class="user-photo">
                    <a class="img" title="我的头像">
                        <img src="/images/avatar.png" class="userAvatar">
                    </a>
                    <p>你好！<span class="userName">bobi</span>, 欢迎登录</p>
                </div>
                <!--左侧导航菜单-->
                <ul id="navBar" class="layui-nav okadmin-nav okadmin-bg-20222A layui-nav-tree">
                    <li class="layui-nav-item layui-this">
                        <a href="javascript:" lay-id="1" data-url="pages/console.html">
                            <i is-close=false class="ok-icon">&#xe654;</i>
                            控制台
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 内容主体区域 -->
        <div class="content-body">
            <div class="layui-tab ok-tab" lay-filter="ok-tab" lay-allowClose="true" lay-unauto>
                <div data-id="left" id="okLeftMove"
                     class="ok-icon ok-icon-back okadmin-tabs-control move-left okNavMove"></div>
                <div data-id="right" id="okRightMove"
                     class="ok-icon ok-icon-right okadmin-tabs-control move-right okNavMove"></div>
                <div class="layui-icon okadmin-tabs-control ok-right-nav-menu" style="right: 0;">
                    <ul class="okadmin-tab">
                        <li class="no-line okadmin-tab-item">
                            <div class="okadmin-link layui-icon-down" href="javascript:;"></div>
                            <dl id="tabAction" class="okadmin-tab-child layui-anim-upbit layui-anim">
                                <dd><a data-num="1" href="javascript:">关闭当前标签页</a></dd>
                                <dd><a data-num="2" href="javascript:">关闭其他标签页</a></dd>
                                <dd><a data-num="3" href="javascript:">关闭所有标签页</a></dd>
                            </dl>
                        </li>
                    </ul>
                </div>

                <ul id="tabTitle" class="layui-tab-title ok-tab-title not-scroll">
                    <li class="layui-this" lay-id="1" tab="index">
                        <i class="ok-icon">&#xe654;</i>
                        <cite is-close=false>控制台</cite>
                    </li>
                </ul>

                <div id="tabContent" class="layui-tab-content ok-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe src='/pages/console.html' frameborder="0" scrolling="yes" width="100%" height="100%"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!--底部信息-->
        <div class="layui-footer okadmin-text-center">
           技术支持：圣诺科技有限公司
            <!-- <button class="layui-btn layui-btn-danger layui-btn-xs donate">捐赠作者</button>
            <button class="layui-btn layui-btn-danger layui-btn-xs communication">QQ群交流</button> -->
        </div>
    </div>
    <div class="yy"></div>
    <!--js逻辑-->
    <script src="/lib/layui/layui.js"></script>
    <script src="/js/okadmin.js"></script>
</body>
</html>
