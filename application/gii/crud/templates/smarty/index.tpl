<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
$label=$this->pluralize($this->class2name($this->modelClass));
?>
<h1><?php echo $label; ?></h1>

<?php echo "{"; ?>$this->widget('zii.widgets.CListView', [
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view'
], true)}