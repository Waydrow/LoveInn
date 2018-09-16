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
   模型列: id, user_id, user_name, user_realname, user_money, activity_id, activity_name, time, rate, isjoin
*/
class ApplyHoursModel extends ViewModel {
    public $viewFields = array(
        'apply'=>array('id', 'userid', 'activityid', 'rate', 'isjoin'),
        'activity'=>array('begintime', 'endtime', 'israte', '_on'=>'apply.activityid=activity.id')
    );
}