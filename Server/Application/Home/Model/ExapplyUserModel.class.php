<?php
/**
 * Created by PhpStorm.
 * User: Waydrow
 * Date: 2017/2/5
 * Time: 15:17
 */

namespace Home\Model;
use Think\Model\ViewModel;


/*报名视图模型
   模型列: id, userid, exid, isend, exname, exmoney, realname, phone, email
*/
class ExapplyUserModel extends ViewModel {
    public $viewFields = array(
        'exapply'=>array('id', 'userid', 'exid', 'isend'),
        'exchange'=>array('exname', 'exmoney', '_on'=>'exapply.exid=exchange.id'),
        'volunteer'=>array('realname', 'username', 'phone', 'email', '_on'=>'exapply.userid=volunteer.id')
    );
}