<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="wide form">

<?php echo "{\$form=\$this->beginWidget('CActiveForm', [
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get'
])}\n"; ?>

<?php foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<div class="row">
		<?php echo "{\$form->label(\$model,'{$column->name}')}\n"; ?>
		<?php echo "{".$this->generateActiveField($this->modelClass,$column)."}\n"; ?>
	</div>

<?php endforeach; ?>
	<div class="row buttons">
		<?php echo "{CHtml::submitButton('Search')}\n"; ?>
	</div>

<?php echo "{\$end=\$this->endWidget()}\n"; ?>

</div><!-- search-form -->