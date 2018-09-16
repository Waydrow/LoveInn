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
   模型列: id, user_id,
*/
class ApplyHistoryModel extends ViewModel {
    public $viewFields = array(
        'apply'=>array('id', 'userid'=>'user_id', 'activityid'=>'activity_id', 'time', 'rate', 'isjoin'),
        'activity'=>array('name', '_on'=>'apply.activityid=activity.id')
    );
}