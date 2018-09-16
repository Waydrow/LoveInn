<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>LoveInn Admin</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- ZUI 标准版压缩后的 CSS 文件 -->
    <link rel="stylesheet" href="//cdn.bootcss.com/zui/1.5.0/css/zui.min.css">

    <link rel="stylesheet" type="text/css" href="/Loveinn/Public/lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Loveinn/Public/lib/font-awesome/css/font-awesome.min.css">

    <script src="/Loveinn/Public/lib/jquery-1.11.1.min.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="/Loveinn/Public/stylesheets/theme.css">
    <link rel="stylesheet" type="text/css" href="/Loveinn/Public/stylesheets/premium.css">

</head>
<body class=" theme-blue">

<!-- Demo page code -->

<script type="text/javascript">
    $(function () {
        var match = document.cookie.match(new RegExp('color=([^;]+)'));
        if (match) var color = match[1];
        if (color) {
            $('body').removeClass(function (index, css) {
                return (css.match(/\btheme-\S+/g) || []).join(' ')
            })
            $('body').addClass('theme-' + color);
        }

        $('[data-popover="true"]').popover({html: true});

    });
</script>
<style type="text/css">
    #line-chart {
        height: 300px;
        width: 800px;
        margin: 0px auto;
        margin-top: 1em;
    }

    .navbar-default .navbar-brand, .navbar-default .navbar-brand:hover {
        color: #fff;
    }
</style>

<script type="text/javascript">
    $(function () {
        var uls = $('.sidebar-nav > ul > *').clone();
        uls.addClass('visible-xs');
        $('#main-menu').append(uls.clone());
    });
</script>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="../assets/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">


<!--[if lt IE 7 ]>
<body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>
<body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]>
<body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]>
<body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->

<!--<![endif]-->

<div class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="" href="index.html"><span class="navbar-brand"><span
                class="fa fa-paper-plane"></span> LoveInn后台管理</span></a>
    </div>

    <div class="navbar-collapse collapse" style="height: 1px;">
        <ul id="main-menu" class="nav navbar-nav navbar-right">
            <li class="btn-group">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="glyphicon glyphicon-user padding-right-small"
                          style="position:relative;top: 3px;"></span> <?php echo ($name); ?>
                    <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <?php if($power == 0 ): ?><li><a href="<?php echo U('/Home/Index/order');?>"></a></li>
                        <?php else: ?>
                        <li><a href="<?php echo U('/Home/Index/a_myinfo');?>">我的资料</a></li><?php endif; ?>
                    <li class="divider"></li>
                    <li><a tabindex="-1" href="<?php echo U('/Home/Index/quitlogin');?>">退出</a></li>
                </ul>
            </li>
        </ul>

    </div>
</div>
<div class="copyrights">Collect from <a href="http://www.cssmoban.com/" title="WEBSHOP">WEBSHOP</a></div>

<div class="sidebar-nav">
    <ul>
        <li><a href="#" data-target=".dashboard-menu" class="nav-header" data-toggle="collapse"><i
                class="fa fa-fw fa-dashboard"></i>LoveInn后台<i class="fa fa-collapse"></i></a>
        </li>
        <li>
            <ul class="dashboard-menu nav nav-list collapse in">
                <li><a href="<?php echo U('/Home/Index/index');?>"><span class="fa fa-caret-right"></span>后台首页</a></li>
            </ul>
        </li>
        <!--判断用户权限 0为管理员, 1为组织者-->
        <?php if($power == 0): ?><li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".room-menu"
                                                                            class="nav-header"
                                                                            data-toggle="collapse"><i
                    class="fa fa-fw fa-fighter-jet"></i>活动管理<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="room-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/categorys');?>"><span class="fa fa-caret-right"></span>活动分类</a></li>
                    <li><a href="<?php echo U('/Home/Index/activities');?>"><span class="fa fa-caret-right"></span>活动列表</a></li>
                    <li><a href="<?php echo U('/Home/Index/applies');?>"><span class="fa fa-caret-right"></span>报名管理</a></li>
                </ul>
            </li>
            <li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".bank-menu"
                                                                            class="nav-header"
                                                                            data-toggle="collapse"><i
                    class="fa fa-fw fa-fighter-jet"></i>爱心银行<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="bank-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/exchanges');?>"><span class="fa fa-caret-right"></span>礼品管理</a></li>
                    <li><a href="<?php echo U('/Home/Index/exapply');?>"><span class="fa fa-caret-right"></span>申请列表</a></li>
                </ul>
            </li>
            <li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".premium-menu"
                                                                            class="nav-header"
                                                                            data-toggle="collapse"><i
                    class="fa fa-fw fa-fighter-jet"></i>志愿者管理<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="premium-menu nav nav-list collapse in">
                    <li class="visible-xs visible-sm"><a href="#">- Premium features require a license -</a>
                    <li><a href="<?php echo U('/Home/Index/volunteers');?>"><span class="fa fa-caret-right"></span>志愿者列表</a></li>
                    <li><a href="<?php echo U('/Home/Index/volunteers_auth');?>"><span class="fa fa-caret-right"></span>待审核列表</a></li>
                </ul>
            </li>

            <li><a href="#" data-target=".accounts-menu" class="nav-header" data-toggle="collapse"><i
                    class="fa fa-fw fa-briefcase"></i>组织者管理<span class="label label-info">+3</span></a></li>
            <li>
                <ul class="accounts-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/agencys');?>"><span class="fa fa-caret-right"></span>组织者列表</a></li>
                    <li><a href="<?php echo U('/Home/Index/agencys_auth');?>"><span class="fa fa-caret-right"></span>待审核列表</a></li>
                </ul>
            </li>

            <li><a href="#" data-target=".legal-menu" class="nav-header" data-toggle="collapse"><i
                    class="fa fa-fw fa-legal"></i>管理员管理<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="legal-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/admins');?>"><span class="fa fa-caret-right"></span>管理员列表</a></li>
                    <li><a href="<?php echo U('/Home/Index/addadmin');?>"><span class="fa fa-caret-right"></span>新增管理员</a></li>
                </ul>
            </li>
            <!--为组织者登录-->
            <?php else: ?>
            <li data-popover="true" rel="popover" data-placement="right"><a href="#" data-target=".room-menu"
                                                                            class="nav-header"
                                                                            data-toggle="collapse"><i
                    class="fa fa-fw fa-fighter-jet"></i>活动管理<i class="fa fa-collapse"></i></a></li>
            <li>
                <ul class="room-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/a_activities');?>"><span class="fa fa-caret-right"></span>活动列表</a></li>
                </ul>
            </li>

            <li><a href="#" data-target=".accounts-menu" class="nav-header" data-toggle="collapse"><i
                    class="fa fa-fw fa-briefcase"></i>个人管理<span class="label label-info">+3</span></a></li>
            <li>
                <ul class="accounts-menu nav nav-list collapse in">
                    <li><a href="<?php echo U('/Home/Index/a_password');?>"><span class="fa fa-caret-right"></span>修改密码</a></li>
                    <li><a href="<?php echo U('/Home/Index/a_myinfo');?>"><span class="fa fa-caret-right"></span>我的资料</a></li>
                </ul>
            </li><?php endif; ?>

        <li><a href="#" class="nav-header"><i class="fa fa-fw fa-question-circle"></i>帮助</a></li>
    </ul>
</div>


<div class="content">
    <div class="main-content">

        
        <link rel="stylesheet" href="/Loveinn/Public/datepicker/datetimepicker.min.css">
<style>
    .form-datetime {
        cursor: pointer !important;
    }
</style>
<h2 class="header-dividing">我的活动</h2>
<div class="row">
    <div class="col-md-4">
        <br>
        <div id="myTabContent" class="tab-content">
            <form method="post" enctype="multipart/form-data" onsubmit="return checkUser();">
                <div class="input-group">
                    <span class="input-group-addon">活动名称</span>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo ($data["name"]); ?>">
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">开始时间</span>
                    <input type="text" class="form-control form-datetime" value="<?php echo ($data["begintime"]); ?>" name="begintime" id="begintime" placeholder="请点击选择一个时间" readonly>
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">结束时间</span>
                    <input type="text" class="form-control form-datetime" value="<?php echo ($data["endtime"]); ?>" name="endtime" id="endtime" placeholder="请点击选择一个时间" readonly>
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">活动地址</span>
                    <input type="text" name="location" id="location" class="form-control" value="<?php echo ($data["location"]); ?>">
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">联系方式</span>
                    <input type="text" name="contact" id="contact" class="form-control" value="<?php echo ($data["contact"]); ?>">
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">招募人数</span>
                    <input type="number" name="capacity" id="capacity" class="form-control" value="<?php echo ($data["capacity"]); ?>" placeholder="请输入大于等于0的数字"  >
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">活动种类</span>
                    <select class="form-control" name="category">
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php echo ($vo["selected"]); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">活动简介</span>
                    <input type="text" name="summary" id="summary" class="form-control" value="<?php echo ($data["summary"]); ?>">
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">活动详情</span>
                    <textarea class="form-control" rows="4" name="info" id="info" placeholder="可以输入多行文本"><?php echo ($data["info"]); ?></textarea>
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <br>
                <div class="input-group">
                    <span class="input-group-addon">活动图片</span>
                    <input type="file" class="form-control" name="photo" id="photo">
                    <span class="input-group-addon"><i class="icon icon-star"></i></span>
                </div>
                <div>
                    <?php if($data["hasphoto"] == 0): ?><p>暂未上传活动图片</p>
                        <?php else: ?>
                        <button type="button" class="btn" data-toggle="modal" data-target="#myModal">查看活动图片</button>
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                                        <h4 class="modal-title">活动图片</h4>
                                    </div>
                                    <div class="modal-body">
                                        <img src="<?php echo ($data["photo"]); ?>" alt="活动图片" style="width: 220px;">
                                    </div>
                                </div>
                            </div>
                        </div><?php endif; ?>
                </div>
                <br>
                <input type="text" hidden value="<?php echo ($data["hasphoto"]); ?>" id="hasphoto">
                <button type="submit" class="btn btn-block btn-primary">提交</button>
            </form>
        </div>
    </div>
</div>

<script src="/Loveinn/Public/datepicker/datetimepicker.min.js"></script>
<script>
    function checkUser() {
        var name = $("#name").val();
        var begintime = $("#begintime").val();
        var endtime = $("#endtime").val();
        var location = $('#location').val();
        var contact = $('#contact').val();
        var capacity = $('#capacity').val();
        var summary = $('#summary').val();
        var info = $('#info').val();
        var photo = $("#photo").val();
        var hasphoto = $('#hasphoto').val();
        if(name == "" || begintime == "" || endtime == "" || location == "" || contact == "" ||
            capacity == "" || summary == "" || info == "") {
            alert('请填写完整');
            return false;
        }
        if(hasphoto == 0 && photo == "") {
            alert('请上传活动图片');
            return false;
        }
        if(begintime > endtime) {
            alert('结束时间要在开始时间之后哦');
            return false;
        }
        var reg = /^\d+$/;
        if(!reg.test(capacity)) {
            alert('招募人数请输入大于等于0的数字');
            return false;
        }
        // 防止输入000, 001这种情况
        $('#capacity').val(parseInt(capacity));
        return true;
    }
    // 选择时间和日期
    $(".form-datetime").datetimepicker({
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 1,
        forceParse: 0,
        showMeridian: 1,
        format: "yyyy-mm-dd hh:00"
    });
</script>
        


    </div>
</div>

<!-- ZUI 标准版压缩后的 JavaScript 文件 -->
<script src="//cdn.bootcss.com/zui/1.5.0/js/zui.min.js"></script>

<!--<script src="/Loveinn/Public/lib/bootstrap/js/bootstrap.min.js"></script>-->
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    $(function () {
        $('.demo-cancel-click').click(function () {
            return false;
        });
    });
</script>


</body>
</html>