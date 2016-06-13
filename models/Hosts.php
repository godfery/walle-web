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
class Hosts extends \yii\db\ActiveRecord
{
	

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'hosts';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['host', ], 'required'],
				[[ 'log_time'], 'integer'],
				[['description'],'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'host'                 		=> '主机名称',
            'description'            		=> '主机描述',
            'log_time'               		=> '插入时间',
            
				
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
