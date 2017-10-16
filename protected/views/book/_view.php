<?php
/* @var $this BookController */
/* @var $data Book */
?>

<div class="view">

<!--	<b>--><?php //echo CHtml::encode($data->getAttributeLabel('id')); ?><!--:</b>-->
<!--	--><?php //echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?>
<!--	<br />-->

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
<!--	--><?php //echo CHtml::encode($data->title); ?>
    <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pages')); ?>:</b>
	<?php echo CHtml::encode($data->pages); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php echo CHtml::encode(date('m.d.Y',strtotime($data->published))); ?>
	<br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('publisher_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->publisher->name), array('./publisher/view', 'id'=>$data->publisher->id)); ?>
    <br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
<!--	--><?php //echo CHtml::encode($data->category_id); ?>
    <?php echo CHtml::link(CHtml::encode($data->category->getParentCategoriesLine()), array('./category/view', 'id'=>$data->category->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('img_path')); ?>:</b>
	<?php

    if (file_exists('images/' .$data->img_path)&&$data->img_path!=null)
        echo CHtml::image(Yii::app()->baseUrl . '/images/' .$data->img_path,$data->name,array('width'=>'100px','height'=>'100px','title'=>$data->name));
    else
        echo CHtml::encode('No Image');
        ?>
    <!--
	--><?php //echo CHtml::encode($data->img_path); ?>
	<br />

    <b><?php
        echo CHtml::encode("Authors"); ?>:</b>
    <?php
    echo $data->getAuthorsLinks();
//    echo CHtml::encode($data->getAuthorsNames()); ?>
    <br />

</div>