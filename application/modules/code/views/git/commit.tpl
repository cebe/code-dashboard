<h1>{$this->id|cat:'/'|cat:$this->action->id} {$commit->shortSha}</h1>

{$commit->author}<br/>
{$commit->date|date_format}<br/>
{$commit->comment}
{*$this->widget('zii.widgets.grid.CListView', [
    'id' => 'commit-grid',
    'dataProvider' => $dataProvider,
    'columns' => [
        'shortSha',
        'date:datetime',
        'author',
        'summary'
    ]
], true)*}