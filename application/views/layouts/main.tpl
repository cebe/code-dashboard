<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="{Yii::app()->request->baseUrl}/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="{Yii::app()->request->baseUrl}/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="{Yii::app()->request->baseUrl}/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="{Yii::app()->request->baseUrl}/css/main.css" />
	<link rel="stylesheet" type="text/css" href="{Yii::app()->request->baseUrl}/css/form.css" />

	<title>{CHtml::encode($this->pageTitle)}</title>
</head>

<body>

<div class="container" id="page">

	<div id="mainmenu">
        
        <div id="header">
            <div id="logo">{CHtml::encode(Yii::app()->name)}</div>
        </div><!-- header -->

		{$this->widget('zii.widgets.CMenu', [
			'items'=>[
				['label'=>'Code', 'url'=>['/code/default/index']],
				['label'=>'About', 'url'=>['/site/page', 'view'=>'about']],
				['label'=>'Contact', 'url'=>['/site/contact']],
				['label'=>'Login', 'url'=>['/site/login'], 'visible'=>Yii::app()->user->isGuest],
				['label'=>'Logout ('|cat:Yii::app()->user->name|cat:')', 'url'=>['/site/logout'], 'visible'=>!Yii::app()->user->isGuest]
			]
		], true)}
            
	</div><!-- mainmenu -->

	{$this->widget('zii.widgets.CBreadcrumbs', [
		'links'=>$this->breadcrumbs
	], true)}<!-- breadcrumbs -->

	{$content}

	<div id="footer">
		Copyright &copy; {date('Y')} by My Company.<br/>
		All Rights Reserved.<br/>
		{Yii::powered()}
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
