<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Manage Category', 'url'=>array('admin'),'visible'=>Yii::app()->user->isGuest?false:Yii::app()->user->isAdmin),
);
?>

<h1>Categories</h1>

<?php
echo "<h1>Full tree of categories:</h1>";
$this->widget('CTreeView', array('data' => Category::getAllCategoryTree(), 'htmlOptions' => array('class' => 'treeview-black')));
echo "<h1>List of categories:</h1>";
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
