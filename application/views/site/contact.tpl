{$this->pageTitle=Yii::app()->name|cat:' - Contact Us'}
{$this->breadcrumbs=['Contact']}

<h1>Contact Us</h1>

{if Yii::app()->user->hasFlash('contact')}
<div class="flash-success">
	{Yii::app()->user->getFlash('contact')}
</div>
{else}
<p>
If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>

<div class="form">

{$form=$this->beginWidget('CActiveForm')}

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	{$form->errorSummary($model)}

	<div class="row">
		{$form->labelEx($model,'name')}
		{$form->textField($model,'name')}
	</div>

	<div class="row">
		{$form->labelEx($model,'email')}
		{$form->textField($model,'email')}
	</div>

	<div class="row">
		{$form->labelEx($model,'subject')}
		{$form->textField($model,'subject',['size'=>60,'maxlength'=>128])}
	</div>

	<div class="row">
		{$form->labelEx($model,'body')}
		{$form->textArea($model,'body',['rows'=>6, 'cols'=>50])}
	</div>

	{if CCaptcha::checkRequirements()}
	<div class="row">
		{$form->labelEx($model,'verifyCode')}
		<div>
			{$this->widget('CCaptcha')}
			{$form->textField($model,'verifyCode')}
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
	</div>
	{/if}

	<div class="row buttons">
		{CHtml::submitButton('Submit')}
	</div>

{$this->endWidget()}

</div><!-- form -->

{/if}
