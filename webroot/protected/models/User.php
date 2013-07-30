<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-7-14
 * Time: 下午7:26
 * To change this template use File | Settings | File Templates.
 */

class User extends BaseUser{
    public static $nameHash;
    const TYPE_ID = 1;
    const TYPE_NICKNAME = 2;
    const TYPE_EMAIL = 3;
    public static function model($className = __CLASS__){
        return parent::model($className);
    }

    /**
     * 获取用户基本信息缓存,已用Yii实现
     * @param   mixed       $id 用户ID (int|string)
     * @param   string    $type 查询类型(id,nick_name,email)
     * @return  array     用户基本信息
     */
    public function getUserInfoCache($id, $type = 'id') {
        //如果为空，则直接退出
        $defaultValue = $id;
        if(empty($id)) {
            return false;
        }

        if(!in_array($type, array('id','nick_name','email'))) {
            return false;
        }
        //exit($id);
        //获取用户的ID
        if($type != 'id') {
            if(isset(self::$nameHash[$type][$defaultValue])){
                $id = self::$nameHash[$type][$defaultValue];
            } else {
                $map[$type] = $id;
                $command = Yii::app()->db->createCommand();
                $id = $command->select('id')
                    ->from("{$this->tableName()}")
                    ->where("$type=:id", array(':id'=>$id))
                    ->queryScalar();
                self::$nameHash[$type][$defaultValue] = $id;
            }
            if(empty($id)) {
                return false;
            }
        }

        $userInfo = Yii::app()->cache->get('User.getUserInfoCache.'.$id);
        //获取用户基本信息缓存
        if(empty($userInfo)) {
            //姓名
            $command = Yii::app()->db->createCommand();
            $userInfo = $command->from($this->tableName())->where('id='.$id)->queryRow();

            //todo 获取用户的其他信息

            Yii::app()->cache->set('User.getUserInfoCache.'.$id, $userInfo);
        }
        return $userInfo;
    }

    /**
     * 更新用户基本信息缓存,已用Yii实现
     * @param   mixed       $userIds 用户ID (int|array)
     */
    public function  deleteUserInfoCache($userIds){
        $userIds = is_string($userIds) ? array($userIds) : $userIds;
        foreach($userIds as $id){
            Yii::app()->cache->delete('User.getUserInfoCache.'.$id);
        }
    }

    public static function hashPassword($password, $salt){
        return sha1(sha1($salt.$password));
    }
}