<?php
/* @var $this BookController */
/* @var $model Book */

$this->breadcrumbs=array(
	'Books'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Book', 'url'=>array('index')),
	array('label'=>'Create Book', 'url'=>array('create')),
	array('label'=>'Update Book', 'url'=>array('update', 'id'=>$model->id),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
	array('label'=>'Delete Book', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
	array('label'=>'Manage Book', 'url'=>array('admin'),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
);
?>

<h1>View Book #<?php echo $model->id; ?></h1>

<?php

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(

		'id',
		'name',
		'pages',
        array(
            'name'=>'published',
            'value'=>date('m.d.Y',strtotime($model->published)),
        ),
        array(
            'name'=>'publisher_id',
            'value'=>$model->publisher->name,
        ),
        array(
            'name'=>'category_id',
            'value'=>$model->category->getParentCategoriesLine(),
        ),
        array(
            'name'=>'img_path',
            'type'=>'raw',
            'value'=>$model->showImgFromDatabase(),
        ),
        array(
            'name'=>'authors',
            'value'=>$model->getAuthorsNames(),
        ),

	),
)); ?>
