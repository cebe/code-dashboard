<h1>commit {$commit->shortSha} {$commit->summary}</h1>

{$parents = []}
{foreach $commit->parents as $parent}
    {$parents[] = CHtml::link($parent, ['/code/git/commit', 'sha'=>$parent])}
{/foreach}
{$this->widget('zii.widgets.CDetailView', [
    'data'=>$commit,
    'attributes'=>[
		'sha',
		'author',
		'authorDate:datetime',
		[
			'name'=>'committer',
			'visible'=>($commit->committer!=$commit->author)
		],
		[
			'name'=>'commitDate:datetime',
			'visible'=>($commit->commitDate!=$commit->authorDate)
		],
		[
			'name'=>'merge',
			'visible'=>!is_null($commit->merge)
		],
		[
			'name'=>'parents',
			'type'=>'raw',
			'value'=>implode(', ', $parents),
			'visible'=>!empty($commit->parents)
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
