<h1>{$this->id|cat:'/'|cat:$this->action->id}</h1>

{foreach $persons as $person}
	{$this->widget('zii.widgets.CDetailView', [
	    'data'=>$person,
	    'attributes'=>[
			'name',
			'email'
	    ]
	], true)}
	<br/>
{/foreach}
