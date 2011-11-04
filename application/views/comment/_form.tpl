<div id="comment-form-ajax" class="form">

{$form=$this->beginWidget('CActiveForm', [
	'id'=>'comment-form',
	'enableAjaxValidation'=>false
])}

	{$form->error($model,'userId')}

	<div class="row">
		{$form->labelEx($model,'message')}
		{$form->textArea($model,'message',['rows'=>6, 'cols'=>50])}
		{$form->error($model,'message')}
	</div>

	{CHtml::hiddenField('CommentRelation[type]', $relation.type)}
	{CHtml::hiddenField('CommentRelation[key]',  $relation.key)}

	<div class="row buttons">
	    {if $model->isNewRecord}
		    {CHtml::ajaxSubmitButton('Submit', ['/comment/create'], ['replace'=>'#comment-form-ajax'], ['id'=>'submit-comment'|cat:($ajaxId|default:"")])}
		{else}
		    {CHtml::submitButton('Save')}
		{/if}
	</div>

{$end=$this->endWidget()}

</div><!-- form -->
