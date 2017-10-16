<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'book-form',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pages'); ?>
		<?php echo $form->textField($model,'pages'); ?>
		<?php echo $form->error($model,'pages'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'published'); ?>
<!--		--><?php //echo $form->textField($model,'published'); ?>
		<?php
        if($model->published!=null)
        $model->published=date('m.d.yy',strtotime($model->published));
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'     => $model,
            'attribute' => 'published',
//            'flat'=>true,
            'options'=>array(
                'showAnim'=>'fold',
                'showOn' => 'both',
                'changeYear'=> true,
                'changeMonth' => true,
                'yearRange'=>'1880:'.date("Y"),
//                'showButtonPanel'=>true,
                'dateFormat'=>'dd.mm.yy',
            ),
            'language'=> 'en',
        ));  ?>
		<?php echo $form->error($model,'published'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'publisher_id'); ?>
<!--        		--><?php //echo $form->textField($model,'publisher_id'); ?>
        <?php echo $form->dropdownlist($model,'publisher_id', Publisher::getAllPublishers()); ?>
        <?php echo $form->error($model,'publisher_id'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
<!--		--><?php //echo $form->textField($model,'category_id'); ?>
<!--        --><?php //echo $form->dropdownlist($model,'category_id', Category::getAllCategories()); ?>
        <?php echo $form->dropdownlist($model,'category_id', Category::getAllCategoriesTreeView()); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>



    <div class="row">
        <?php echo $form->labelEx($model,'authors'); ?>
        <!--		--><?php //echo $form->textField($model,'category_id'); ?>
        <!--        --><?php //echo $form->dropdownlist($model,'category_id', Category::getAllCategories());?>

        <?php echo $form->dropDownList($model, 'authors', Author::getAllNames(), array('prompt' => 'Select', 'multiple' => true, 'selected' => 'selected')); ?>
        <?php echo $form->error($model,'authors'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'img_path'); ?>
        <?php echo $form->fileField($model,'img_path'); ?>
<!--		--><?php //echo $form->textField($model,'img_path',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'img_path'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->