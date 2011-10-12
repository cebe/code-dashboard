<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model = $this->loadModel($id);

        <?php
        $nameColumn=$this->guessNameColumn($this->tableSchema->columns);
        $label=$this->pluralize($this->class2name($this->modelClass));
        echo "\$this->breadcrumbs=array(
            '$label'=>array('index'),
            \$model->{$nameColumn},
        );\n";
        ?>

        $this->menu=array(
            array('label'=>'List <?php echo $this->modelClass; ?>', 'url'=>array('index')),
            array('label'=>'Create <?php echo $this->modelClass; ?>', 'url'=>array('create')),
            array('label'=>'Update <?php echo $this->modelClass; ?>', 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
            array('label'=>'Delete <?php echo $this->modelClass; ?>', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>'Are you sure you want to delete this item?')),
            array('label'=>'Manage <?php echo $this->modelClass; ?>', 'url'=>array('admin')),
        );

		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new <?php echo $this->modelClass; ?>;

        <?php
        $label=$this->pluralize($this->class2name($this->modelClass));
        echo "\$this->breadcrumbs=array(
            '$label'=>array('index'),
            'Create',
        );\n";
        ?>

        $this->menu=array(
            array('label'=>'List <?php echo $this->modelClass; ?>', 'url'=>array('index')),
            array('label'=>'Manage <?php echo $this->modelClass; ?>', 'url'=>array('admin')),
        );

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        <?php
        $nameColumn=$this->guessNameColumn($this->tableSchema->columns);
        $label=$this->pluralize($this->class2name($this->modelClass));
        echo "\$this->breadcrumbs=array(
            '$label'=>array('index'),
            \$model->{$nameColumn}=>array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
            'Update',
        );\n";
        ?>

        $this->menu=array(
            array('label'=>'List <?php echo $this->modelClass; ?>', 'url'=>array('index')),
            array('label'=>'Create <?php echo $this->modelClass; ?>', 'url'=>array('create')),
            array('label'=>'View <?php echo $this->modelClass; ?>', 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
            array('label'=>'Manage <?php echo $this->modelClass; ?>', 'url'=>array('admin')),
        );

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        <?php
        $label=$this->pluralize($this->class2name($this->modelClass));
        echo "\$this->breadcrumbs=array(
            '$label',
        );\n";
        ?>

        $this->menu=array(
            array('label'=>'Create <?php echo $this->modelClass; ?>', 'url'=>array('create')),
            array('label'=>'Manage <?php echo $this->modelClass; ?>', 'url'=>array('admin')),
        );

		$dataProvider=new CActiveDataProvider('<?php echo $this->modelClass; ?>');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        <?php
        $label=$this->pluralize($this->class2name($this->modelClass));
        echo "\$this->breadcrumbs=array(
            '$label'=>array('index'),
            'Manage',
        );\n";
        ?>

        $this->menu=array(
            array('label'=>'List <?php echo $this->modelClass; ?>', 'url'=>array('index')),
            array('label'=>'Create <?php echo $this->modelClass; ?>', 'url'=>array('create')),
        );

		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=<?php echo $this->modelClass; ?>::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
