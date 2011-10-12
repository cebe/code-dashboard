<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<div class="form">

<?php echo "{\$form=\$this->beginWidget('CActiveForm', [
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false
])}\n"; ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo "{\$form->errorSummary(\$model)}\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->isPrimaryKey)
		continue;
?>
	<div class="row">
		<?php echo "{".$this->generateActiveLabel($this->modelClass,$column)."}\n"; ?>
		<?php echo "{".$this->generateActiveField($this->modelClass,$column)."}\n"; ?>
		<?php echo "{\$form->error(\$model,'{$column->name}')}\n"; ?>
	</div>

<?php
}
?>
	<div class="row buttons">
	    {if $model->isNewRecord}
		    {CHtml::submitButton('Create')}
		{else}
		    {CHtml::submitButton('Save')}
		{/if}
	</div>

<?php echo "{\$end=\$this->endWidget()}\n"; ?>

</div><!-- form -->