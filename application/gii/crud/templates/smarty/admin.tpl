<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
$label=$this->pluralize($this->class2name($this->modelClass));
?>
{$cs=Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
")}

<h1>Manage <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo "{CHtml::link('Advanced Search','#', ['class'=>'search-button'])}"; ?>

<div class="search-form" style="display:none">
<?php echo "{\$this->renderPartial('_search', [
	'model'=>\$model
])}\n"; ?>
</div><!-- search-form -->

<?php echo "{"; ?>$this->widget('zii.widgets.grid.CGridView', [
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>[
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
//	if(++$count==7)
//		echo "\t\t{*\n";
	echo "\t\t'".$column->name."',\n";
}
//if($count>=7)
//	echo "\t\t*}\n";
?>
		[
			'class'=>'CButtonColumn'
		]
	]
], true)}
