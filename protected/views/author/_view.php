<?php
/* @var $this AuthorController */
/* @var $data Author */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('born')); ?>:</b>
	<?php
    if($data->born!=null)
    echo CHtml::encode(date('m.d.Y',strtotime($data->born))); ?>
	<br />


    <b><?php
        echo CHtml::encode("Books"); ?>:</b>
    <?php echo CHtml::encode($data->getAssignedBooksNames()); ?>
    <br />

</div>