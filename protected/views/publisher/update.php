<?php
/* @var $this PublisherController */
/* @var $model Publisher */

$this->breadcrumbs=array(
	'Publishers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Publisher', 'url'=>array('index')),
	array('label'=>'Create Publisher', 'url'=>array('create')),
	array('label'=>'View Publisher', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Publisher', 'url'=>array('admin'),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
);
?>

<h1>Update Publisher <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>