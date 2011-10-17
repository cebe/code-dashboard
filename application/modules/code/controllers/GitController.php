<?php

/**
 *
 * @property CodeModule $module
 */
class GitController extends Controller
{
    public $defaultAction = 'commits';

	public function actionCommits()
	{
        $this->breadcrumbs=array(
        	'Git'=>array('/code/git'),
        	'Commits',
        );

        foreach($this->module->repositories as $repoConfig) {
            $repo = new GitRepository();
            $repo->attributes = $repoConfig;
            $dataProvider = new CArrayDataProvider(
                array_values($repo->getCommits(1000)),
                array(
                    'keyField' => 'sha',
                    'pagination' => array(
                        'pageSize' => 50,
                    )
                )
            );
        }

		$this->render('commits', array(
            'dataProvider' => $dataProvider,
        ));
	}

    public function actionCommit($sha)
   	{
        foreach($this->module->repositories as $repoConfig) {
            $repo = new GitRepository();
            $repo->attributes = $repoConfig;
            $commit = $repo->getCommit($sha);
        }

        $this->breadcrumbs=array(
        'Git'=>array('/code/git'),
        'Commits'=>array('/code/git/commits'),
        $commit->shortSha
        );

        $this->render('commit', array(
            'commit' => $commit,
           //'dataProvider' => $dataProvider,
        ));
   	}

	public function actionPeople()
	{
        $this->breadcrumbs=array(
        	'Git'=>array('/code/git'),
        	'People',
        );
        
		$this->render('people');
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}