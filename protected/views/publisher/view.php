<?php
/* @var $this PublisherController */
/* @var $model Publisher */

$this->breadcrumbs=array(
	'Publishers'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Publisher', 'url'=>array('index')),
	array('label'=>'Create Publisher', 'url'=>array('create')),
	array('label'=>'Update Publisher', 'url'=>array('update', 'id'=>$model->id),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
	array('label'=>'Delete Publisher', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
	array('label'=>'Manage Publisher', 'url'=>array('admin'),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
);
?>

<h1>View Publisher #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
        array(
            'name'=>'created',
            'value'=>date('m.d.Y',strtotime($model->created)),
        ),
		'location',
		'phone',
	),
)); ?>
