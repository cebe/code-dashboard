<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?><h1>Update <?php echo $this->modelClass." {\$model->{$this->tableSchema->primaryKey}}"; ?></h1>

<?php echo "{\$this->renderPartial('_form', ['model'=>\$model])}"; ?>