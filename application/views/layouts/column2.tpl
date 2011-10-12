{$this->beginContent('//layouts/main')}
<div class="container">
	<div class="span-19">
		<div id="content">
			{$content}
		</div><!-- content -->
	</div>
	<div class="span-5 last">
		<div id="sidebar">
			{$portlet=$this->beginWidget('zii.widgets.CPortlet', [
				'title'=>'Operations'
			])}
			{$this->widget('zii.widgets.CMenu', [
				'items'=>$this->menu,
				'htmlOptions'=>['class'=>'operations']
			], true)}
			{$end=$this->endWidget()}
		</div><!-- sidebar -->
	</div>
</div>
{$this->endContent()}
