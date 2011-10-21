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
			'name'=>'merge',
			'visible'=>!is_null($commit->merge)
		],
		[
			'name'=>'parent',
			'type'=>'raw',
			'value'=>CHtml::link($commit->parent, ['/code/git/commit', 'sha'=>$commit->parent]),
			'visible'=>!is_null($commit->parent)
		],
		[
			'name'=>'tree',
			'visible'=>!is_null($commit->tree)
		],
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
