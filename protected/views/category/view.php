<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Update Category', 'url'=>array('update', 'id'=>$model->id),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
	array('label'=>'Delete Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
	array('label'=>'Manage Category', 'url'=>array('admin'),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
);
?>

<h1>View Category #<?php echo $model->id; ?></h1>

<?php

$my_data=$model->getCategoryTree();
$this->widget('CTreeView', array('data' => array($my_data), 'htmlOptions' => array('class' => 'treeview-red')));

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
        array(
            'name'=>'parent',
            'value'=>$model->parent0==null?"No parent":$model->parent0->name,
        ),
	),
)); ?>
