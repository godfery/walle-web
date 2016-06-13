<?php

namespace app\controllers;

use yii;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use app\components\Controller;
use app\models\Hosts;
use app\models\User;
use app\models\Group;
use app\components\GlobalHelper;
use app\components\Command;
use Symfony\Component\Yaml\Yaml;

class HostsController extends Controller {
	/**
	 *
	 * @param \yii\base\Action $action        	
	 * @return bool
	 */
	public function beforeAction($action) {
		parent::beforeAction ( $action );
		if (! GlobalHelper::isValidAdmin ()) {
			throw new \Exception ( yii::t ( 'conf', 'you are not active' ) );
		}
		return true;
	}
	/**
	 * 配置项目列表
	 */
	public function actionIndex() {
		$project = Hosts::find ();
		// ->where(['user_id' => $this->uid]);
		// $kw = \Yii::$app->request->post('kw');
		// if ($kw) {
		// $project->andWhere(['like', "name", $kw]);
		// }
		$project = $project->asArray ()->all ();
		return $this->render ( 'index', [ 
				'list' => $project 
		] );
	}
	
	/**
	 * 配置项目
	 *
	 * @param
	 *        	$projectId
	 * @return string
	 * @throws \Exception
	 */
	public function actionEdit($projectId = null) {
		if ($projectId) {
			$project = $this->findModel ( $projectId );
		} else {
			$project = new Hosts ();
			$project->loadDefaultValues ();
		}
		
		if (\Yii::$app->request->getIsPost () && $project->load ( Yii::$app->request->post () )) {
			// $project->user_id = $this->uid;
			
			// TODO 似乎Yii应该可以在Model配置 这些字段的属性 rtrim
			// $project->repo_url = rtrim($project->repo_url, '/');
			// $project->deploy_from = rtrim($project->deploy_from, '/');
			// $project->release_to = rtrim($project->release_to, '/');
			// $project->release_library = rtrim($project->release_library, '/');
			$project->log_time = time ();
			if ($project->save ()) {
				// 保存ansible需要的hosts文件
				
				$this->redirect ( '@web/hosts/' );
			}
		}
		
		return $this->render ( 'edit', [ 
				'conf' => $project 
		] );
	}
	public function actionToconf($projectId) {
		echo __DIR__;
		
		$project = $this->findModel ( $projectId );
		
		$value = Yaml::parse(file_get_contents(yii::$app->params['playbook.yaml.template.dir'].yii::$app->params['playbook.yaml.template.filename']));
		
		echo __DIR__;
		
		$value['0']['hosts'] ="fffffffffff";
		var_dump($value);
		$yaml = Yaml::dump($value);
		
		file_put_contents(yii::$app->params['playbook.yaml.template.dir'].'2.yml', $yaml);
		
	}
	
	/**
	 * 删除配置
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function actionDelete($projectId) {
		$project = $this->findModel ( $projectId );
		
		if (! $project->delete ())
			throw new \Exception ( yii::t ( 'w', 'delete failed' ) );
		
		$this->renderJson ( [ ] );
	}
	/**
	 * 简化
	 *
	 * @param integer $id        	
	 * @return the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = Hosts::getOne ( $id )) !== null) {
			// if ($model->user_id != $this->uid) {
			// throw new \Exception(yii::t('w', 'you are not master of project'));
			// }
			return $model;
		} else {
			throw new NotFoundHttpException ( yii::t ( 'conf', 'project not exists' ) );
		}
	}
}