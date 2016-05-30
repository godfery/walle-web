<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $user_id
 */
class Playbook extends \yii\db\ActiveRecord
{
	

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'playbook';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['name', ], 'required'],
				[[ 'user_id','status','log_time'], 'integer'],
				[['custom_order','stop_server_mysql','running_server_mysql','running_httpurl','version'],'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'                 		=> 'ID',
            'user_id'            		=> 'User ID',
            'name'               		=> '剧本名字',
            'custom_order'              => '自定义命令',
            'stop_server_mysql'         => '停服执行的脚本',
            'runnint_server_mysql'      => '运行时候的脚本',
            'running_httpurl'         	=> '要执行的URL',
            'version'        			=> '版本号',
				
		];
	}
	public static $CONF;
	
	public static function getOne($id = null) {
		if (empty(static::$CONF)) {
			static::$CONF = static::findOne($id);
		}
		return static::$CONF;
	}
	
	/**
	 * width('user')
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser() {
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	

}
