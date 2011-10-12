<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?><h1>View <?php echo $this->modelClass." #{\$model->{$this->tableSchema->primaryKey}}"; ?></h1>

<?php echo "{"; ?>$this->widget('zii.widgets.CDetailView', [
	'data'=>$model,
	'attributes'=>[
<?php
$count=0;
foreach($this->tableSchema->columns as $column) {
	echo "\t\t'".$column->name."'";
	if ($count++<count($this->tableSchema->columns)-1)
	    echo ",";
	echo "\n";
}
?>
	]
], true)}
