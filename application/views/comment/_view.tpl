<div class="view">

	<b>{CHtml::encode($data->getAttributeLabel('id'))}:</b>
	{CHtml::link(CHtml::encode($data->id), ['view', 'id'=>$data->id])}
	<br />

	<b>{CHtml::encode($data->getAttributeLabel('message'))}:</b>
	{CHtml::encode($data->message)}
	<br />

	<b>{CHtml::encode($data->getAttributeLabel('userId'))}:</b>
	{CHtml::encode($data->userId)}
	<br />


</div>