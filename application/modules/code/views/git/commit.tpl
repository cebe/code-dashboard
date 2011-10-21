<h1>commit {$commit->shortSha} {$commit->summary}</h1>

{$this->widget('zii.widgets.CDetailView', [
    'data'=>$commit,
    'attributes'=>[
		'sha',
		'author',
		'authorDate:datetime',
		'committer',
		'commitDate:datetime',
		[
			'name'=>'comment',
			'type'=>'raw',
			'value'=>$commit->comment|nl2br
		]
    ]
], true)}

{foreach $commit->diffs as $diff}
	{$highliter=$this->beginWidget('ext.diffFormatter.DiffFormatter', [
		'language'=>'php'
	])}{$diff}{$end=$this->endWidget()}
{/foreach}
