<div style="margin: 0 auto; max-width: 1500px;">
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
			'name'=>'commitDate',
			'type'=>'datetime',
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

{if !empty($commit->diffs)}
<h1>files</h1>
<ul>
{foreach $commit->diffs as $diffId => $diff}
	<li>{$diff.fileName} {CHtml::link('view diff', '#diff-'|cat:$diffId)}</li>
{/foreach}
</ul>
{/if}

<h1>comments</h1>

{$this->widget('zii.widgets.CListView', [
	'dataProvider'=>$comments,
	'itemView'=>'//comment/_view'
], true)}

{$this->renderPartial('//comment/_form', [
	'model'=>$comment,
	'relation'=> ['type'=>'commit', 'key'=>$commit->sha]
])}

{if !empty($commit->diffs)}
<h1>file diffs</h1>
{foreach $commit->diffs as $diffId => $diff}
	<div id="diff-{$diffId}">
		{CHtml::link('top', '#', ['style'=>'float: right;'])}
		{$highliter=$this->beginWidget('ext.diffFormatter.DiffFormatter', [
			'language'=>'php'
		])}{$diff.diff}{$end=$this->endWidget()}
	</div>
{/foreach}
{/if}
</div>
