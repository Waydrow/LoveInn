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

        
        <h2 class="header-dividing">活动种类列表</h2>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_add_category" style="margin-bottom: 20px;">添加新种类</button>
<div class="modal fade" id="myModal_add_category">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">添加新活动种类</h4>
            </div>
            <form method="post" onsubmit="return checkInput();">
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-addon">活动种类名</span>
                        <input type="text" class="form-control" name="category_name" id="add_category_input" placeholder="活动种类名">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add" class="btn btn-default">添加</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                </div>
            </form>
        </div>
    </div>
</div>
<table class="table" style="width: 800px;">
    <thead>
    <tr>
        <th>#</th>
        <th>活动种类名</th>
        <th style="width: 3.5em;"></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($i); ?></td>
            <td id="td-name-<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></td>
            <td>
                <button type="button" class="btn btn-primary modal-info-btn" name="<?php echo ($vo["id"]); ?>" data-toggle="modal" data-target="#myModal_change_cagegory">编辑</button>
            </td>
            <td>
                <a type="button" href="<?php echo U("Home/Index/delcategory?id=$vo[id]");?>" class="btn btn-primary" onclick="del();">删除</a>
            </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <div class="modal fade" id="myModal_change_cagegory">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                    <h4 class="modal-title">修改活动种类名</h4>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon">活动种类名</span>
                            <input type="text" class="form-control" name="category_change_name" id="category_name_input" placeholder="活动种类名">
                        </div>
                        <div class="alert alert-success alert-info">修改成功</div>
                        <div class="alert alert-danger alert-info">活动种类名重复</div>
                        <div class="alert alert-warning alert-info">修改失败</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="change" class="btn btn-default">修改</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
       var infoBtn = $(".modal-info-btn");
        var id;
        var tdid;
        $('.alert-info').hide();

        // 遍历编辑按钮
        $(infoBtn).each(function(index, el) {
            $(this).on('click', function() {
                $('.alert-info').hide();
                // 获取该行信息的id
                id = $(this).attr('name');
                // 显示name的td的id
                tdid = "#td-name-" + id;
                var name = $(tdid).text();
                console.log(name);
                $("#category_name_input").val(name);

            })
        });

        $('#change').on('click', function () {
            $('.alert-info').hide();
            var new_name = $('#category_name_input').val().trim();
            if(new_name == "") {
                alert('不可以为空哦');
                return;
            }
            console.log(new_name);
            var data = {
                id: id,
                category_change_name: new_name
            };
            $.ajax({
                url: '<?php echo U("/Home/Index/change_category");?>',
                method: 'POST',
                data: data
            }).done(function(dataget) {
                if(dataget == 1) { // 成功修改
                    $("#category_name_input").val(new_name);
                    $(tdid).text(new_name);
                    $(".alert-success").show();
                } else if(dataget == 0) { // 名字重复
                    $(".alert-danger").show();
                } else { // 修改失败
                    $(".alert-warning").show();
                }
//                console.log('change succeed');
            }).fail(function() { // 未响应
                console.log('change error');
            });
        });
    });

</script>
<script type="text/javascript">
    function del() {
        if (!confirm("确认要删除？")) {
            window.event.returnValue = false;
        }
    }

    // 添加种类时不可以为空
    function checkInput() {
        var a_name = $('#add_category_input').val().trim();
        if(a_name == "") {
            alert('不可以为空');
            return false;
        } else {
            return true;
        }
    }

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