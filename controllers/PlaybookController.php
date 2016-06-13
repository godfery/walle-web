<?php

namespace app\controllers;

use yii;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use app\components\Controller;
use app\models\Playbook;
use app\models\User;
use app\models\Group;
use app\components\GlobalHelper;
use app\components\Command;
// use Qutee\Task;

class PlaybookController extends Controller
{

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action) {
        parent::beforeAction($action);
        if (!GlobalHelper::isValidAdmin()) {
            throw new \Exception(yii::t('conf', 'you are not active'));
        }
        return true;
    }

    /**
     * 配置项目列表
     *
     */
    public function actionIndex() {
        $project = Playbook::find()
            ->where(['user_id' => $this->uid]);
        $kw = \Yii::$app->request->post('kw');
        if ($kw) {
            $project->andWhere(['like', "name", $kw]);
        }
        $project = $project->asArray()->all();
        return $this->render('index', [
            'list' => $project,
        ]);
    }

    

    /**
     * 项目配置检测
     *
     * @param $projectId
     * @return string
     * @throws \Exception
     */
    public function actionDetection($projectId) {
        $this->layout = 'modal';
        $project = $this->findModel($projectId);
        return $this->render('detection', [
            'project' => $project,
        ]);
    }

    
    /**
     * 配置项目
     *
     * @param $projectId
     * @return string
     * @throws \Exception
     */
    public function actionEdit($projectId = null) {
        if ($projectId) {
            $project = $this->findModel($projectId);
        } else {
            $project = new Playbook();
            $project->loadDefaultValues();
        }

        if (\Yii::$app->request->getIsPost() && $project->load(Yii::$app->request->post())) {
            $project->user_id = $this->uid;

            // TODO 似乎Yii应该可以在Model配置 这些字段的属性 rtrim
//             $project->repo_url = rtrim($project->repo_url, '/');
//             $project->deploy_from = rtrim($project->deploy_from, '/');
//             $project->release_to = rtrim($project->release_to, '/');
//             $project->release_library = rtrim($project->release_library, '/');
			   $project->log_time = time();
            if ($project->save()) {
                // 保存ansible需要的hosts文件
              
                $this->redirect('@web/playbook/');
            }
        }

        return $this->render('edit', [
            'conf' => $project,
        ]);
    }

    
    /**
     * 删除配置
     *
     * @return string
     * @throws \Exception
     */
    public function actionDelete($projectId) {
    	$project = $this->findModel($projectId);
    
    	if (!$project->delete()) throw new \Exception(yii::t('w', 'delete failed'));
    
    	
    
    	$this->renderJson([]);
    }
    
	public  function  actionToconf($projectId) {
		
		echo __DIR__;
		
		$project = $this->findModel($projectId);
		
		
		$fp = fopen('/www/walle/walle-web/runtime/update.conf', 'w+');
		
		fwrite($fp, "");
		
		$httpurl_status = 1;
		if(empty($project->running_httpurl)) {
			$httpurl_status = 0;
		}
		
		$content = <<<EOF
svn_update_version={$project->version}

http_url="{$project->running_httpurl}"

mysql_code="{$project->stop_server_mysql}"

running_mysql_code="{$project->running_server_mysql}"
		
custom_order="{$project->custom_order}"

httpurl_status=$httpurl_status

EOF;
		
		fwrite($fp, $content);
		fclose($fp);
		$command = new	Command(array("a"=>1));
		$command ->runLocalCommand("cp -rf /www/walle/walle-web/runtime/update.conf /www/self/交接/joyfort--运维相关文档及操作/autoSprite/trunk/auto_script/");
// 		
		
// 		
		
		
	}
	public  function  actionGenYml($projectId) {
	
		echo __DIR__;
	
		$project = $this->findModel($projectId);
	
	
		$fp = fopen('/www/walle/walle-web/runtime/cod171.yaml', 'w+');
	
		fwrite($fp, "");
	
		$httpurl_status = 1;
		if(empty($project->running_httpurl)) {
			$httpurl_status = 0;
		}
	
		$content = <<<EOF
---
- hosts: cod18-4
  remote_user: root
  become: yes
  become_method: su
   
  vars:
      username: fsdf
      PASSWPRD: 2323 
  tasks:
   
   
   - name: (first)self update
     shell: sh /home/autoSprite/trunk/auto_script/selfupdate.sh  >>/home/1.log 2>&1
     ignore_errors: yes

   - name: stop tomcat
     shell: sh /home/autoSprite/trunk/auto_script/shutdown.sh  >>/home/1.log 2>&1
     ignore_errors: yes
   - name: update the gwar
     shell: sh /home/autoSprite/trunk/auto_script/svn.sh  >>/home/1.log 2>&1
     ignore_errors: yes
   - name: call the mysql code
     shell: sh /home/autoSprite/trunk/auto_script/mysql.sh  >>/home/1.log 2>&1
     
   - name: start tomcat 
     shell: sh /home/autoSprite/trunk/auto_script/start.sh  >>/home/1.log 2>&1
     ignore_errors: yes
     # become: yes
     # become_method: sudo


   - name: call http url
     shell: sh /home/autoSprite/trunk/auto_script/http.sh  >>/home/1.log 2>&1
   - name: stop tomcat
     shell: sh /home/autoSprite/trunk/auto_script/shutdown.sh  >>/home/1.log 2>&1
     ignore_errors: yes

   - name: start tomcat 
     shell: sh /home/autoSprite/trunk/auto_script/start.sh  >>/home/1.log 2>&1
     ignore_errors: yes
	
EOF;
	
	fwrite($fp, $content);
	fclose($fp);
	$command = new	Command(array("a"=>1));
	$command ->runLocalCommand("cp -rf /www/walle/walle-web/runtime/update.conf /www/self/交接/joyfort--运维相关文档及操作/autoSprite/trunk/auto_script/");
//
	
	//
	
	
	}
    /**
     * 简化
     *
     * @param integer $id
     * @return the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Playbook::getOne($id)) !== null) {
            if ($model->user_id != $this->uid) {
                throw new \Exception(yii::t('w', 'you are not master of project'));
            }
            return $model;
        } else {
            throw new NotFoundHttpException(yii::t('conf', 'project not exists'));
        }
    }

    

}
