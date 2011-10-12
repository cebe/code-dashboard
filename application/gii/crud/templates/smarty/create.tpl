<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?><h1>Create <?php echo $this->modelClass; ?></h1>

<?php echo "{\$this->renderPartial('_form', ['model'=>\$model])}"; ?>
