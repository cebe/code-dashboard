<?php

/**
 *
 * @property CodeModule $module
 */
class GitController extends Controller
{
    public $defaultAction = 'commits';

	public function actionCommits($branch='__ALL__')
	{
        $this->breadcrumbs=array(
        	'Git'=>array('/code/git'),
        	'Commits',
        );

        foreach($this->module->repositories as $repoConfig) {
            $repo = new GitRepository($repoConfig);
            $dataProvider = new CArrayDataProvider(
                array_values(
	                $repo->getCommits(
		                ($branch=='__ALL__') ? null : $branch, 10000
	                )
                ),
                array(
                    'keyField' => 'sha',
                    'pagination' => array(
                        'pageSize' => 50,
                    )
                )
            );
        }

		$this->render('commits', array(
            'repo' => $repo,
			'branch' => $branch,
            'dataProvider' => $dataProvider,
        ));
	}

    public function actionCommit($sha)
   	{
        foreach($this->module->repositories as $repoConfig) {
            $repo = new GitRepository($repoConfig);
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

		foreach($this->module->repositories as $repoConfig) {
			$repo = new GitRepository($repoConfig);
		}

		$this->render('people', array(
			'persons' => $repo->getPersons(),
		));
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
