<?php
/**
 * Created by PhpStorm.
 * User: Waydrow
 * Date: 2016/02/03
 * Time: 21:20
 */
namespace Home\Model;
use Think\Model\ViewModel;

/*活动模型
    模型列: id, name, summary, info, photo, begintime, endtime, location, contact, capacity, isend, category_name, agency_name, agency_username
*/
class ActivityViewModel extends ViewModel {
    public $viewFields = array(
        'activity'=>array('id', 'name', 'summary', 'info', 'photo', 'begintime', 'endtime',
            'location', 'contact', 'capacity', 'isend'),
        'category'=>array('name'=>'category_name', '_on'=>'activity.categoryid=category.id'),
        'agency'=>array('name'=>'agency_name', 'username'=>'agency_username', '_on'=>'activity.agencyid=agency.id')
    );

}