<?php
namespace Home\Controller;
use Think\Controller;
use Think\Exception;
use Think\Upload;

class AppController extends Controller {

    /*
     * 登录
     * */
    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);

        $user = M("volunteer");
        $data = $user->where("username='%s' AND password='%s'", $username, $password)->find();
        if($data) {
            echo $data['id'];
        } else {
            echo "0";
        }
    }

    // app用户注册
    public function register() {
        $username = I('username');
        $password = I('password');
        $password = md5($password);

        $user = M('volunteer');
        $result = $user->where("username='%s'", $username)->find();
        if($result) {
            echo "0";
            return; // 已存在该用户
        } else {
            $user->username = $username;
            $user->password = $password;
            $result = $user->add();
            // 返回用户id
            echo $result;
        }
    }

    // 获取活动列表
    public function getActivityList() {
        $activity = M('activity');
        $list = $activity->where('isend=0')->field('id, name, summary, photo, begintime')->order('id desc')->select();
        $this->ajaxReturn($list, 'json');
    }

    // 获取组织机构列表
    public function getAgencyList() {
        $activity = M('agency');
        $list = $activity->where('ispass=1')->field('id, name, photo, address, contact, certification')->order('id desc')->select();
        $this->ajaxReturn($list, 'json');
    }

    // Android 讲课使用
    public function getInfoList() {
        $activity = M('activity');
        $list = $activity->where('isend=0')->field('id, name, summary, photo')->order('id desc')->select();
        $this->ajaxReturn($list, 'json');
    }

    // 按活动id获取活动详情
    public function getActivityInfoById() {
        $id = I('id');
        $activity = M('activity');
        $data = $activity->where('id=%d', $id)->find();
        $this->ajaxReturn($data, 'json');
    }

    // 上传图片工具函数
    private function uploadPhoto($filekey){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     1113145728 ;// 设置附件上传大小
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

    // 获取个人信息
    public function getVolunteerInfo() {
        $id = I('id');
        $volunteer = M('volunteer');
        $data = $volunteer->where('id=%d', $id)->find();
        $this->ajaxReturn($data, 'json');
    }

    // 上传个人头像
    public function uploadAvatar() {
        $id = $_POST['id'];
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     113145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      'Public/Uploads/'; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['avatar']);
        if ($info) {
            $dir =  '/LoveInn/Public/Uploads/' . $info['savepath'].$info['savename'];
            $volunteer = M('volunteer');
            $volunteer->avatar = $dir;
            $result = $volunteer->where('id=%d', $id)->save();
            if($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '2';
        }
    }

    // 上传学生证
    public function uploadStucard() {
        $id = $_POST['id'];
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     113145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      'Public/Uploads/'; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['stucard']);
        if ($info) {
            $dir =  '/LoveInn/Public/Uploads/' . $info['savepath'].$info['savename'];
            $volunteer = M('volunteer');
            $volunteer->stucard = $dir;
            $result = $volunteer->where('id=%d', $id)->save();
            if($result) {
                echo '1';
            } else {
                echo '0';
            }
        } else {
            echo '2';
        }
    }

    // 获取个人头像地址
    public function getAvatar() {
        $id = I("id");
        $volunteer = M('volunteer');
        $data = $volunteer->where('id=%d', $id)->getField('avatar');
        echo $data;
    }

    // 获取学生证地址
    public function getStucard() {
        $id = I("id");
        $volunteer = M('volunteer');
        $data = $volunteer->where('id=%d', $id)->getField('stucard');
        echo $data;
    }

    // 修改姓名
    public function updateRealName() {
        $realName = I('realname');
        $id = I('id');
        $volunteer = M('volunteer');
        $volunteer->realname = $realName;
        $result = $volunteer->where("id=%d", $id)->save();
        if($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改年龄
    public function updateAge() {
        $age = I('age');
        $id = I('id');
        $volunteer = M('volunteer');
        $volunteer->age = $age;
        $result = $volunteer->where("id=%d", $id)->save();
        if($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改性别
    public function updateSex() {
        $sex = I('sex');
        $id = I('id');
        $volunteer = M('volunteer');
        $volunteer->sex = $sex;
        $result = $volunteer->where("id=%d", $id)->save();
        if($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改身份证号
    public function updateIdcard() {
        $idcard = I('idcard');
        $id = I('id');
        $volunteer = M('volunteer');
        $volunteer->idcard = $idcard;
        $result = $volunteer->where("id=%d", $id)->save();
        if($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改电话
    public function updatePhone() {
        $phone = I('phone');
        $id = I('id');
        $volunteer = M('volunteer');
        $volunteer->phone = $phone;
        $result = $volunteer->where("id=%d", $id)->save();
        if($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改email
    public function updateEmail() {
        $email = I('email');
        $id = I('id');
        $volunteer = M('volunteer');
        $volunteer->email = $email;
        $result = $volunteer->where("id=%d", $id)->save();
        if($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改info
    public function updateInfo() {
        $info = I('info');
        $id = I('id');
        $volunteer = M('volunteer');
        $volunteer->info = $info;
        $result = $volunteer->where("id=%d", $id)->save();
        if($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 修改个人信息
    public function changeVolunteerInfo() {
        $id = I('id');
        $realname = I('realname');
        $age = I('age');
        $sex = I('sex');
        $idcard = I('idcard');
        $phone = I('phone');
        $email = I('email');
        $info = I('info');
        $uploadStuCardResult = $this->uploadPhoto('stucard');
        if($uploadStuCardResult == 0) {
            echo '0';
        } else {
            $new_volunteer = M('volunteer');
            $new_volunteer->realname = $realname;
            $new_volunteer->age = $age;
            $new_volunteer->sex = $sex;
            $new_volunteer->idcard = $idcard;
            $new_volunteer->phone = $phone;
            $new_volunteer->address = $email;
            $new_volunteer->info = $info;
            $new_volunteer->stucard = $uploadStuCardResult;
            $new_volunteer->ispass = 0; // 调整为等待审核状态
            $result = $new_volunteer->where('id=%d', $id)->save();
            if($result) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    // 获取实名认证状态
    public function getAuthState() {
        $id = I('id');
        $volunteer = M('volunteer');
        $ispass = $volunteer->where('id=%d', $id)->getField('ispass');
        echo $ispass;
    }

    // 实名认证
    public function auth() {
        $id = I('id');
        $volunteer = M('volunteer');
        $ispass = $volunteer->where('id=%d', $id)->getField("ispass");
        if ($ispass == 0) {
            echo '0'; // 已申请, 请等待
        } else if ($ispass == -1) {
            $result = $volunteer->where('id=%d', $id)->setField('ispass', 0);
            if ($result) {
                echo '1'; // 成功, 等待审核
            } else {
                echo '-1'; // 失败
            }
        }
    }

    // 报名参加公益活动
    public function apply() {
        $user_id = I('user_id');
        $activity_id = I('activity_id');
        $apply = M('apply');
        $result = $apply->where('userid=%d and activityid=%d and isjoin<>-1', $user_id, $activity_id)->find();
        if($result) {
            echo '-1'; // 已报名
        } else {
            $new_apply = M('apply');
            $new_apply->userid = $user_id;
            $new_apply->activityid = $activity_id;
            $apply_result = $new_apply->add();
            if($apply_result) {
                echo '1'; // 报名成功
            } else {
                echo '0'; // 报名失败
            }
        }
    }

    // 查看历史活动
    public function historyInfo() {
        $user_id = I('user_id');
        $history = D('ApplyHistory');
        $data = $history->where('userid=%d', $user_id)->order('time desc')->field('id,name,time,rate,isjoin')->select();
        $this->ajaxReturn($data, 'json');
    }

    // 爱心银行 获取兑换礼品信息
    public function exchangeInfo() {
        $exchange = M("exchange");
        $data = $exchange->select();
        $this->ajaxReturn($data, 'json');
    }

    // 申请礼品兑换
    public function exchangeApply() {
        $user_id = I('user_id');
        $ex_id = I("ex_id");
        $set_money = I("set_money");

        $exapply = M('exapply');

        $exapply->startTrans();
        try {
            $exapply->userid = $user_id;
            $exapply->exid = $ex_id;
            $result = $exapply->add();
            $aresult = M("volunteer")->where("id=%d", $user_id)->setField("money", $set_money);
            $exapply->commit();
            echo "1";
        } catch (Exception $e) {
            $exapply->rollback();
            echo '0';
        }
    }

    // 获取爱心币
    public function getMoney() {
        $user_id = I('user_id');
        $money = M("volunteer")->where("id=%d",$user_id)->getField("money");
        echo $money;
    }

    // 获取工时
    public function getHours() {
        $user_id = I('user_id');
        $applyHours = D('ApplyHours');
        $list = $applyHours->where('userid=%d AND isjoin=1 AND israte=1', $user_id)->select();
        $sum = 0;
        foreach ($list as $item) {
            $beg = $item['begintime'];
            $end = $item['endtime'];
            $begintime = strtotime($beg);
            $endtime = strtotime($end);
            $len = (int)($endtime - $begintime) / 3600;
            $sum = $sum + $len;
        }
        echo $sum;
    }

    // 用户订阅
    // 获取种类列表
    public function getCategoryList() {
        $user_id = I('userid');
        $category = M("category");
        $data = $category->select();
        $subscribe = M('subscribe');
        foreach ($data as &$item) {
            $result = $subscribe->where('userid=%d and categoryid=%d', $user_id, $item['id'])->find();
            if ($result) {
                $item['isSub'] = 1;
            } else {
                $item['isSub'] = 0;
            }
        }
        $this->ajaxReturn($data, 'json');
    }

    // 用户订阅某个种类
    public function userSubscribe() {
        $user_id = I('userid');
        $category_id = I('category_id');
        $subscribe = M('subscribe');
        $subscribe->userid = $user_id;
        $subscribe->categoryid = $category_id;
        $result = $subscribe->add();
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    // 用户取消订阅某个种类
    public function userCancelSubscribe() {
        $user_id = I('userid');
        $category_id = I('category_id');
        $subscribe = M('subscribe');
        $result = $subscribe->where('userid=%d and categoryid=%d', $user_id, $category_id)->delete();
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }
}