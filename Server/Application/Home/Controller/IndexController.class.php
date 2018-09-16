<?php
namespace Home\Controller;

use Think\Controller;
use Think\Exception;

require_once ('./vendor/autoload.php');
use JPush\Client as JPush;

class IndexController extends Controller {

    // 封装推送方法, $title为推送标题, $text为推送内容
    private function pushNotification($title, $text) {
        $app_key = 'c6fbbcf48150db0cce0d46aa';
        $master_secret = '577e6a087b01ac162eb117eb';

        $client = new JPush($app_key, $master_secret);

        if(is_null($title)) {
            $title = '爱心驿站';
        }
        if(is_null($text)) {
            $text = '来自爱心驿站的提醒';
        }

        $push_payload = $client->push()
            ->setPlatform('all')
            ->addAllAudience()
            ->setNotificationAlert('hi jpush')
            ->androidNotification($text, array(
                'title' => $title
            ));
        try {
            $response = $push_payload->send();
        }catch (\JPush\Exceptions\APIConnectionException $e) {
            // try something here
            print $e;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            // try something here
            print $e;
        }
    }

    // 封装推送方法, $title为推送标题, $text为推送内容
    private function pushNotificationForAlias($title, $text, $aliasArray) {
        $app_key = 'c6fbbcf48150db0cce0d46aa';
        $master_secret = '577e6a087b01ac162eb117eb';

        $client = new JPush($app_key, $master_secret);

        if(is_null($title)) {
            $title = '爱心驿站';
        }
        if(is_null($text)) {
            $text = '来自爱心驿站的提醒';
        }

        $push_payload = $client->push()
            ->setPlatform('all')
            ->addAlias($aliasArray)
            ->setNotificationAlert('hi jpush')
            ->androidNotification($text, array(
                'title' => $title
            ));
        try {
            $response = $push_payload->send();
        }catch (\JPush\Exceptions\APIConnectionException $e) {
            // try something here
            print $e;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            // try something here
            print $e;
        }
    }

    // 自动运行方法,判断是否登录
    public function _initialize() {
        //当前为登录页时不执行该操作
        if (ACTION_NAME != "login") {
            //判断session['adminaccount']是否为空，是的话跳转到登陆界面
            if (!isset($_SESSION['account'])) {
                echo "<script>alert('用户未登录或登陆超时');</script>";
                $this->redirect("/Home/Index/login");
            } else {
                //显示登录的管理员帐号
                $adminaccount = $_SESSION['account'];
                $power = $_SESSION['power'];
                if($power == 0) {
                    $admin = M('admin')->where("account='" . $adminaccount . "'")->select();
                } else {
                    $admin = M('agency')->where("username='" . $adminaccount . "'")->select();
                    $ispass = $admin[0]['ispass'];
                    $_SESSION['ispass'] = $ispass;
                    $this->assign("ispass", $ispass);
                }

                $name = $admin[0]['name'];
                $this->assign("name", $name);
                $this->assign("power", $power);
            }
        }
    }

    // 主页
    public function index()
    {
        $vo = M('volunteer')->order('id')->select();
        $this->assign("list", $vo);
        $this->display();
    }

    //登录页
    public function login() {
        //不加载模板页
        C('LAYOUT_ON', FALSE);
        $this->display();
        if (IS_POST) {

            $adminaccount = $_POST['adminaccount'];
            $password = $_POST['password'];
            $flag = $_POST['flag'];
            //这里使用md5加密
            $password = md5($password);
            if ($adminaccount == "" || $password == "") {
                echo "<script>alert('请输入用户名和密码！');history.go(-1);</script>";
            } else {
                if($flag == 0) {
                    $admin = M('admin');
                    $result = $admin->where('account="%s" and password="%s"', $adminaccount, $password)->select();
                } else {
                    $agency = M('agency');
                    $result = $agency->where('username="%s" and password="%s"', $adminaccount, $password)->select();
                }

                if ($result) {
                    //将用户账号及权限存入session
                    $_SESSION['account'] = $adminaccount;
                    if($flag == 0) { // 0表示管理员
                        $_SESSION['power'] = 0;
                    } else { // 1表示组织者
                        $_SESSION['power'] = 1;
                    }
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('登录成功');</script>";
                    $this->redirect("/Home/Index");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('登录失败');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
                }
            }
        }
    }

    public function quitlogin() {
        $_SESSION['account'] = null;
        $_SESSION['power'] = null;
        if($_SESSION['ispass']) {
            $_SESSION['ispass'] = null;
        }
        $this->redirect('/Home/Index/login');
    }


    /*判断当前登录的用户是否为组织者, 若不是, 则没有权限执行该操作, 返回主页*/
    private function isAgencyLogin() {
        $power = $_SESSION['power'];
        if($power == 0) { // 0表示管理员
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('您没有权限执行该操作!');</script>";
            $this->redirect("/Home/Index");
        }
    }

    /*判断当前登录的用户是否为管理者, 若不是, 则没有权限执行该操作, 返回主页*/
    private function isAdminLogin() {
        $power = $_SESSION['power'];
        if($power == 1) { // 1表示组织者
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('您没有权限执行该操作!');</script>";
            $this->redirect("/Home/Index");
        }
    }



    /**************************************************************************************/
    /*管理员管理后台*/
    /**************************************************************************************/


    // 活动种类管理
    public function categorys() {
        $category = M('category');
        $list = $category->select();
        $this->assign("list", $list);
        $this->display();
        if(IS_POST) { // 添加
            if(isset($_POST['add'])) {
                $new_category = M('category');
                $data['name'] = $_POST['category_name'];
                $select_re = $new_category->where('name="%s"', $data['name'])->find();
                if($select_re) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('活动名重复');</script>";
                    $this->redirect("/Home/Index/categorys");
                }
                $result = $new_category->add($data);
//                $result = $new_category->add();
                if($result) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加成功');</script>";
                    $this->redirect("/Home/Index/categorys");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("添加失败")</script>';
                    $this->redirect("/Home/Index/categorys");
                }
            }
        }
    }

    // 删除种类
    public function delcategory() {
        $this->isAdminLogin();
        $id = I('request.id');
        $category = M('category');
        $result = $category->delete($id);
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/categorys");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/categorys");
        }
    }

    // 修改种类信息, ajax接口
    public function change_category() {
        $this->isAdminLogin();
        $id = I('post.id');
        $name = I('post.category_change_name');
        $a_category = M('category');
        $select_re = $a_category->where('name="%s"', $name)->find();
        if($select_re) { // 重复
            $this->ajaxReturn('0');
            return;
        }
        $a_category->name = $name;
        $result1 = $a_category->where('id=%d', $id)->save();
        if($result1) { // 成功
            $this->ajaxReturn("1");
        } else { // 失败
            $this->ajaxReturn("-1");
        }
    }

    // 爱心银行功能, 礼品列表及添加礼品
    public function exchanges() {
        $exchange = M('exchange');
        $list = $exchange->select();
        $this->assign("list", $list);
        $this->display();
        if(IS_POST) { // 添加
            if(isset($_POST['add'])) {
                $new_exchange = M('exchange');
                $data['exname'] = $_POST['exname'];
                $data['exmoney'] = $_POST['exmoney'];
                $result = $new_exchange->add($data);
//                $result = $new_category->add();
                if($result) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加成功');</script>";
                    $this->redirect("/Home/Index/exchanges");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("添加失败")</script>';
                    $this->redirect("/Home/Index/exchanges");
                }
            }
        }
    }

    // 删除礼品
    public function delexchange() {
        $this->isAdminLogin();
        $id = I('request.id');
        $exchange = M('exchange');
        $result = $exchange->delete($id);
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/exchanges");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/exchanges");
        }
    }

    // 修改礼品信息, ajax接口
    public function change_exchange() {
        $this->isAdminLogin();
        $id = I('post.id');
        $name = I('post.exname');
        $money = I('post.exmoney');
        $a_exchange = M('exchange');
        $a_exchange->exname = $name;
        $a_exchange->exmoney = $money;
        $result1 = $a_exchange->where('id=%d', $id)->save();
        if($result1) { // 成功
            $this->ajaxReturn("1");
        } else { // 失败
            $this->ajaxReturn("-1");
        }
    }

    // 礼品兑换申请列表
    public function exapply() {
        $exapplyUser = D('ExapplyUser');
        $list = $exapplyUser->where('isend=0')->select();
        $list_done = $exapplyUser->where('isend<>0')->select();
        $this->assign("list", $list);
        $this->assign("list_done", $list_done);
        $this->display();
    }

    // 通过礼品兑换请求
    public function exapply_success() {
        $this->isAdminLogin();
        $id = I('id');
        $exapply = M('exapply');
        $userid = $exapply->where('id=%d', $id)->getField('userid');
        $result = $exapply->where('id=%d', $id)->setField('isend', 1);
        if($result) {
            $title = '爱心驿站';
            $text = '恭喜, 礼品兑换审核已通过';
            $alias = array();
            $alias[] = $userid;
            $this->pushNotificationForAlias($title, $text, $alias);

            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script type=\"text/javascript\">alert('通过成功');</script>";
            $this->redirect("/Home/Index/exapply");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("通过失败")</script>';
            $this->redirect("/Home/Index/exapply");
        }
    }

    // 拒绝礼品兑换请求
    public function exapply_deny() {
        $this->isAdminLogin();
        $id = I('id');
        $exapplyUser = D('ExapplyUser');
        $userId = $exapplyUser->where('exapply.id=%d', $id)->getField('userid');
        $exmoney = $exapplyUser->where('exapply.id=%d', $id)->getField('exmoney');
        $exapply = M('exapply');
        $exapply->startTrans();
        try {
            // 拒绝
            $exapply->where('id=%d', $id)->setField('isend', -1);
            // 返还 爱心币 到用户帐户
            $volunteer = M('volunteer');
            $nowmoney = $volunteer->where('id=%d', $userId)->getField('money');
            $realmoney = $nowmoney + (int)$exmoney;
            $volunteer->where('id=%d', $userId)->setField('money', $realmoney);

            $exapply->commit();

            $title = '爱心驿站';
            $text = '很遗憾, 礼品兑换审核未通过, 相应爱心币已返还到您的帐户';
            $alias = array();
            $alias[] = $userId;
            $this->pushNotificationForAlias($title, $text, $alias);
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('拒绝成功');</script>";
            $this->redirect("/Home/Index/exapply");

        } catch (Exception $e) {
            $exapply->rollback();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('拒绝失败');</script>";
            $this->redirect("/Home/Index/exapply");
        }
    }

    // 活动列表管理
    public function activities() {
        $this->isAdminLogin();
        $activities = D('ActivityView');
        $list = $activities->where('isend=0')->order('category_name')->select();
        $this->assign('list', $list);
        $this->display();
    }

    // 删除活动
    public function delactivity() {
        $this->isAdminLogin();
        $id = I('id');
        $activity = M('activity');
        $result = $activity->where('id=%d', $id)->delete();
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/activities");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/activities");
        }
    }

    // 查看报名列表
    public function applies() {
        $this->isAdminLogin();
        $applies = D('ApplyView');
        $list = $applies->distinct(true)->field('activity_id,activity_name')->where('isjoin=1')->select();
        foreach ($list as &$item) {
            $activity_id = $item['activity_id'];
            $item['sub'] = $applies->where('activityid=%d and isjoin=1',$activity_id)->field('id,user_id,user_name,time,rate,isjoin,user_realname')->select();
        }
        $this->assign('list', $list);
        $this->display();
    }

    // 志愿者列表_已通过审核
    public function volunteers() {
        $this->isAdminLogin();
        $volunteer = M('volunteer');
        $data = $volunteer->where('ispass=1')->select();
        $this->assign("list", $data);
        $this->display();
    }

    // 删除志愿者
    public function delvolunteer() {
        $this->isAdminLogin();
        $id = I('request.id');
        $volunteer = M('volunteer');
        $result = $volunteer->delete($id);
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/volunteers");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/volunteers");
        }
    }

    // 志愿者列表_待审核
    public function volunteers_auth() {
        $this->isAdminLogin();
        $volunteer = M('volunteer');
        $data = $volunteer->where('ispass=0')->select();
        $this->assign("list", $data);
        $this->display();
    }

    // 通过志愿者实名认证
    public function volunteer_auth_success() {
        $this->isAdminLogin();
        $id = I('request.id');
        $volunteer = M('volunteer');
        $result = $volunteer->where('id=%d', $id)->setField('ispass', 1);
        if ($result) {

            $title = '爱心驿站';
            $text = '恭喜, 实名认证成功!';
            $alias = array();
            $alias[] = $id;
            $this->pushNotificationForAlias($title, $text, $alias);

            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过成功');</script>";
            $this->redirect("/Home/Index/volunteers_auth");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过失败');</script>";
            $this->redirect("/Home/Index/volunteers_auth");
        }
    }

    // 拒绝志愿者实名认证
    public function volunteer_auth_deny() {
        $this->isAdminLogin();
        $id = I("request.id");
        $volunteer = M('volunteer');
        $result = $volunteer->where('id=%d', $id)->setField('ispass', -1);
        if ($result) {

            $title = '爱心驿站';
            $text = '很遗憾, 实名认证失败, 请完善您的资料!';
            $alias = array();
            $alias[] = $id;
            $this->pushNotificationForAlias($title, $text, $alias);
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝成功');</script>";
            $this->redirect("/Home/Index/volunteers_auth");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝失败');</script>";
            $this->redirect("/Home/Index/volunteers_auth");
        }
    }

    // 组织者列表_已通过审核
    public function agencys() {
        $this->isAdminLogin();
        $agency = M('agency');
        $data = $agency->where('ispass=1')->select();
        $this->assign("list", $data);
        $this->display();
    }

    // 删除组织者
    public function delagency() {
        $this->isAdminLogin();
        $id = I('request.id');
        $agency = M('agency');
        $result = $agency->delete($id);
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/agencys");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/agencys");
        }
    }

    // 组织者待实名认证列表
    public function agencys_auth() {
        $this->isAdminLogin();
        $agency = M('agency');
        $data = $agency->where('ispass=0')->select();
        $this->assign('list', $data);
        $this->display();
    }

    // 通过组织者实名认证
    public function agency_auth_success() {
        $this->isAdminLogin();
        $id = I('request.id');
        $agency = M('agency');
        $result = $agency->where('id=%d', $id)->setField('ispass', 1);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过成功');</script>";
            $this->redirect("/Home/Index/agencys_auth");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过失败');</script>";
            $this->redirect("/Home/Index/agencys_auth");
        }
    }

    // 拒绝组织者实名认证
    public function agency_auth_deny() {
        $this->isAdminLogin();
        $id = I("request.id");
        $agency = M('agency');
        $result = $agency->where('id=%d', $id)->setField('ispass', -1);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝成功');</script>";
            $this->redirect("/Home/Index/agencys_auth");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝失败');</script>";
            $this->redirect("/Home/Index/agencys_auth");
        }
    }




    /*****************************************************************************************/
    /*组织者管理后台*/
    /*****************************************************************************************/
    // 上传图片工具函数
    private function uploadPhoto($filekey){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      'Public/Uploads/'; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES[$filekey]);
        if(!$info) {// 上传错误提示错误信息
            return 0; // 上传失败
        }else{// 上传成功 获取上传文件信息
            $dir =  '/LoveInn/Public/Uploads/' . $info['savepath'].$info['savename'];
            return $dir;
        }
    }

    // 修改密码
    public function a_password() {
        $this->isAgencyLogin();
        $this->display();
        if(IS_POST) {
            $agency = M('agency');
            $old_agency = $agency->where('username="%s"', $_SESSION['account'])->find();
            $old_password = md5($_POST['old_password']);
            if($old_password != $old_agency['password']) {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo "<script>alert('原密码输入错误, 请重试');</script>";
                return;
            } else {
                $new_password = md5($_POST['new_password']);
                $renew_password = md5($_POST['renew_password']);
                if($new_password != $renew_password) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('两次输入的密码不一致, 请重试');</script>";
                    return;
                } else {
                    $new_agency = M('agency');
                    $new_agency->password = $new_password;
                    $result = $new_agency->where('id=%d', $old_agency['id'])->save();
                    if($result !== false) {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo "<script>alert('修改成功');</script>";
                        $this->redirect('/Home/Index/a_password');
                    } else {
                        echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                        echo "<script>alert('修改失败');</script>";
                        $this->redirect('/Home/Index/a_password');
                    }
                }
            }
        }
    }

    // 我的资料/实名认证
    public function a_myinfo() {
        $this->isAgencyLogin();
        $agency = M('agency');
        $data = $agency->where('username="%s"', $_SESSION['account'])->find();
        $id = $data['id'];
        if($data['photo'] == null) {
            $data['hasphoto'] = 0;
        } else {
            $data['hasphoto'] = 1;
        }
        if($data['certification'] == null) {
            $data['hascertification'] = 0;
        } else {
            $data['hascertification'] = 1;
        }
        $this->assign('data', $data);
        $this->display();
        if(IS_POST) {
            $new_agency = M('agency');
            $new_agency->name = $_POST['name'];
            $new_agency->address = $_POST['address'];
            $new_agency->contact = $_POST['contact'];
            if(!$_FILES['photo']['name'] == "") { // 若上传的图片为空
                $uploadPhotoResult = $this->uploadPhoto('photo');
                if(!$uploadPhotoResult == 0) {
                    $new_agency->photo = $uploadPhotoResult;
                }
            }
            if(!$_FILES['certification']['name'] == "") {
                $uploadCertificationResult = $this->uploadPhoto('certification');
                if(!$uploadCertificationResult == 0) {
                    $new_agency->certification = $uploadCertificationResult;
                }
            }
            $new_agency->ispass = 0; //改为待审核状态
            $result = $new_agency->where('id=%d', $id)->save();
            if ($result) {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo "<script>alert('修改成功, 请等待审核');</script>";
                $this->redirect("/Home/Index/a_myinfo");
            } else {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo "<script>alert('修改失败');</script>";
//                dump($result);
                $this->redirect("/Home/Index/a_myinfo");
            }
        }
    }

    // 活动列表
    public function a_activities() {
        $this->isAgencyLogin();
        $account = $_SESSION['account'];
        $activities = D('ActivityView');
        $data = $activities->where('username="%s" and isend=0', $account)->order('begintime')->select();
        $data_end = $activities->where('username="%s" and isend=1', $account)->order('endtime desc')->select();
        $this->assign('list', $data);
        $this->assign('list_end', $data_end);
        $this->display();
    }

    // 结束该活动
    public function end_activity() {
        $this->isAgencyLogin();
        $id = I('request.id');
        $activity = M('activity');
        $activity->startTrans();
        try {
            $activity->where('id=%d', $id)->setField('isend', 1);
            $apply = M('apply');
            // 将报名该活动但还未审核的置为拒绝
            $apply->where('activityid=%d and isjoin=0', $id)->setField('isjoin', -1);
            $activity->commit();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('结束成功');</script>";
            $this->redirect('/Home/Index/a_activities');

        } catch(Exception $e) {
            $activity->rollback();
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('结束失败');</script>";
            $this->redirect('/Home/Index/a_activities');
        }
    }

    // 删除活动
    public function a_delactivity() {
        $this->isAgencyLogin();
        $id = I('request.id');
        $agency_id = M('agency')->where('username="%s"', $_SESSION['account'])->getField('id');
        $activity = M('activity');
        $result = $activity->where('id=%d and agencyid=%d and isend=0', $id, $agency_id)->delete();
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/a_activities");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除失败');</script>";
            $this->redirect("/Home/Index/a_activities");
        }
    }

    // 添加/编辑活动
    public function a_activity() {
        $this->isAgencyLogin();
        $ispass = $_SESSION['ispass'];
        if($ispass != 1) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('您还未实名认证, 没有该权限');history.go(-1);</script>";
            return;
        }
        $id = I('request.id');
        $list = M('category')->select();
        if($id) { // 修改活动
            $data = M('activity')->where('id=%d', $id)->find();
            $isend = $data['isend'];
            if($isend == 1) {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo "<script>alert('该活动已结束, 无法编辑');history.go(-1);</script>";
                return;
            }
            foreach ($list as &$item) {
                if($item['id'] == $data['categoryid']) {
                    $item['selected'] = 'selected="true"';
                }
            }
            $data['hasphoto'] = 1;
            $this->assign('list', $list);
            $this->assign('data', $data);
            $this->display();
            if(IS_POST) {
                $activity = M('activity');
                $activity->name = $_POST['name'];
                $activity->begintime = $_POST['begintime'];
                $activity->endtime = $_POST['endtime'];
                $activity->location = $_POST['location'];
                $activity->contact = $_POST['contact'];
                $activity->capacity = $_POST['capacity'];
                $activity->categoryid = $_POST['category'];
                $activity->summary = $_POST['summary'];
                $activity->info = $_POST['info'];
                if(!$_FILES['photo']['name'] == "") {
                    $uploadPhotoResult = $this->uploadPhoto('photo');
                    if (!$uploadPhotoResult == 0) {
                        $activity->photo = $uploadPhotoResult;
                    }
                }
                $agency_id = M('agency')->where('username="%s"', $_SESSION['account'])->getField('id');
                $activity->agencyid = $agency_id;
                $result = $activity->where('id=%d', $id)->save();
                if($result) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('修改成功');</script>";
                    $this->redirect("/Home/Index/a_activities");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('修改失败');</script>";
                    $this->redirect("/Home/Index/a_activities");
                }
            }

        } else { // 新增活动
            $data['hasphoto'] = 0;
            $this->assign('list', $list);
            $this->assign('data', $data);
            $this->display();

            if(IS_POST) {
                $activity = M('activity');
                $name = $_POST['name'];
                $categoryId = $_POST['category'];
                $beginTime = $_POST['begintime'];
                $endTime = $_POST['endtime'];
                $activity->name = $name;
                $activity->begintime = $beginTime;
                $activity->endtime = $endTime;
                $activity->location = $_POST['location'];
                $activity->contact = $_POST['contact'];
                $activity->capacity = $_POST['capacity'];
                $activity->categoryid = $categoryId;
                $activity->summary = $_POST['summary'];
                $activity->info = $_POST['info'];
                $uploadPhotoResult = $this->uploadPhoto('photo');
                if(!$uploadPhotoResult == 0) {
                    $activity->photo = $uploadPhotoResult;
                }
                $agency_id = M('agency')->where('username="%s"', $_SESSION['account'])->getField('id');
                $activity->agencyid = $agency_id;
                $result = $activity->add();
                if($result) {

                    // 定向发出推送
                    // 根据种类 id 查找该各种类的活动曾参与过的用户
                    $subscribe = M('subscribe');
                    $users = $subscribe->where('categoryid=%d', $categoryId)->getField("userid", true);
                    /*
                    $applyCategory = D('ApplyCategory');
                    $users = $applyCategory->where('categoryid=%d', $categoryId)->getField('userid', true);
                    */
                    $title = '又有新的公益活动发布啦';
                    if ($users) {
                        $this->pushNotificationForAlias($title, $name, $users);
                    } else {
                        $this->pushNotification($title, $name);
                    }

                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加成功');</script>";
                    $this->redirect("/Home/Index/a_activities");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加失败');</script>";
                    $this->redirect("/Home/Index/a_activities");
                }
            }

        }
    }

    // 每个活动的报名情况
    public function a_apply() {
        $this->isAgencyLogin();
        $activity_id = I('request.id');
        if(!$activity_id) {
            return;
        }
        $isend = M('activity')->where('id=%d', $activity_id)->getField('isend');
        if($isend == 1) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('活动已结束'); history.go(-1);</script>";
            return;
        }
        $activity_name = M('activity')->where('id=%d', $activity_id)->getField('name');
        $this->assign('activity_name', $activity_name);
        $applies = D('ApplyView');
        $list = $applies->where('activityid=%d and isjoin=0', $activity_id)->select();
        $list_join = $applies->where('activityid=%d and isjoin=1', $activity_id)->select();
        $this->assign('list', $list);
        $this->assign('list_join', $list_join);
        $this->display();
    }

    // 批量报名通过
    public function a_apply_success_many() {
        $this->isAgencyLogin();
        $ids = I('post.ids');
        $apply = M('apply');
        $apply->startTrans();
        try {
            $aliasArray = array();
            foreach ($ids as $id) {
                $userId = $apply->where("id=%d", $id)->getField('userid');
                $aliasArray[] = $userId;
                $apply->where('id=%d', $id)->setField('isjoin', 1);
            }
            $apply->commit();
            // 推送报名成功的提醒
            $title = "爱心驿站";
            $text = "您报名参加的活动审核通过了!";
            $this->pushNotificationForAlias($title, $text, $aliasArray);
            echo '1';
        } catch(Exception $e) {
            $apply->rollback();
            echo '0';
        }
    }

    // 批量报名拒绝
    public function a_apply_deny_many() {
        $this->isAgencyLogin();
        $ids = I('post.ids');
        $apply = M('apply');
        $apply->startTrans();
        try {
            $alias = array();
            foreach ($ids as $id) {
                $userid = $apply->where('id=%d', $id)->getField('userid');
                $alias[] = $userid;
                $apply->where('id=%d', $id)->setField('isjoin', -1);
            }
            $apply->commit();
            // 推送报名失败的提醒
            $title = "爱心驿站";
            $text = "很遗憾, 您报名参加的活动审核未通过";
            $this->pushNotificationForAlias($title, $text, $alias);
            echo '1';
        } catch(Exception $e) {
            $apply->rollback();
            echo '0';
        }
    }

    // 通过某个报名____暂时无用
    public function a_apply_success() {
        $this->isAgencyLogin();
        $id = I('request.id');
        if($id) {
            $apply = M('apply');
            $result = $apply->where('id=%d', $id)->setField('isjoin', 1);
            if($result) {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo "<script>alert('通过成功');history.go(-1);</script>";
            } else {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo "<script>alert('通过失败');history.go(-1);</script>";
            }
        }
    }

    public function a_rate() {
        $this->isAgencyLogin();
        $activity_id = I('request.id');
        if(!$activity_id) {
            return;
        }
        $isend = M('activity')->where('id=%d', $activity_id)->getField('isend');
        if($isend == 0) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('活动还未结束'); history.go(-1);</script>";
            return;
        }
        $israte = M('activity')->where('id=%d', $activity_id)->getField('israte');
        $this->assign('israte', $israte);
        $activity_name = M('activity')->where('id=%d', $activity_id)->getField('name');
        $this->assign('activity_name', $activity_name);
        $applies = D('ApplyView');
        $list = $applies->where('activityid=%d and isjoin=1', $activity_id)->select();
        $this->assign('list', $list);
        $this->display();
    }

    // 首次进行评分
    public function a_rate_submit() {
        $this->isAgencyLogin();
        $rates = I('rates');
        $apply = M('apply');
        $apply->startTrans();
        try {
            // 获取该活动id
            $activity_id = M('apply')->where('id=%d', $rates[0]['id'])->getField('activityid');
            $activity = M('activity');
            $beg = $activity->where('id=%d', $activity_id)->getField('begintime');
            $end = $activity->where('id=%d', $activity_id)->getField('endtime');
            $time = (int)(strtotime($end) - strtotime($beg));
            $len = $time / 3600;
            foreach ($rates as $rate) {
                // 给每位志愿者评分
                $apply->where('id=%d', $rate['id'])->setField('rate', $rate['rate']);
                // 按照积分规则
                // 1个小时工时 -> 10个爱心币
                // 设 x 个小时
                // 评分范围 0-10 分 -> 设为 y 个评分
                // 爱心币 = x * y * 0.1
                $x = $rate['rate'] * 2;
                $money = $len * 10 * $x * 0.1;
                $volunteer = M('volunteer');
                // 获取志愿者id
                $volunteer_id = $apply->where('id=%d', $rate['id'])->getField('userid');
                // 积累爱心币
                $volunteer->where('id=%d', $volunteer_id)->setInc('money', $money);
            }

            // 将该活动israte是否已评分标志位置为1
            $activity->where('id=%d', $activity_id)->setField('israte', 1);
            $apply->commit();
            echo '1';
        } catch(Exception $e) {
            $apply->rollback();
            echo '0';
        }
    }

    // 修改评分
    public function a_rate_change() {
        $this->isAgencyLogin();
        $rates = I('rates');
        $apply = M('apply');
        $apply->startTrans();
        try {
            // 给每位志愿者评分
            foreach ($rates as $rate) {
                // 先获取原来的评分
                $old_rate = $apply->where('id=%d', $rate['id'])->getField('rate');
                // 原来加上的爱心币
                $old_money = $old_rate * 2;
                $volunteer = M('volunteer');
                // 获取志愿者id
                $volunteer_id = $apply->where('id=%d', $rate['id'])->getField('userid');
                // 先减少原来的爱心币
                $volunteer->where('id=%d', $volunteer_id)->setDec('money', $old_money);
                // 给每位志愿者评分
                $apply->where('id=%d', $rate['id'])->setField('rate', $rate['rate']);
                // 按照积分规则, 爱心币每次累加评分*2
                $money = $rate['rate'] * 2;
                // 积累爱心币
                $volunteer->where('id=%d', $volunteer_id)->setInc('money', $money);
            }
            $apply->commit();
            echo '1';
        } catch(Exception $e) {
            $apply->rollback();
            echo '0';
        }
    }
}