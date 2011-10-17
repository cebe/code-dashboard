<h1>{$this->id|cat:'/'|cat:$this->action->id}</h1>

{$this->widget('zii.widgets.grid.CGridView', [
    'id' => 'commit-grid',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'header'=>'Graph',
            'type'=>'raw',
            'value'=>'"<pre style=\"margin: 0; padding: 0;\">" . $data->treeGraph . "</pre>"'
        ],
        [
            'class'=>'CLinkColumn',
            'header'=>'Sha',
            'labelExpression'=>'$data->shortSha',
            'urlExpression'=>'Yii::app()->controller->createUrl("/code/git/commit", array("sha"=>$data->sha))'
        ],
        'date:datetime',
        'author',
        'summary'
    ]
], true)}