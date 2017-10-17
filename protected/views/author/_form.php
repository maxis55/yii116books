<?php
/* @var $this AuthorController */
/* @var $model Author */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'author-form',
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
		<?php echo $form->labelEx($model,'born'); ?>
<!--		--><?php //echo $form->textField($model,'born');
        if($model->born!=null)
        $model->born=date('m.d.Y',strtotime($model->born));
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'     => $model,
            'attribute' => 'born',
//            'flat'=>true,
            'options'=>array(
                'showAnim'=>'fold',
                'showOn' => 'both',
                'changeYear'=> true,
                'changeMonth' => true,
                'showButtonPanel'=>true,
                'yearRange'=>'1880:'.date("Y"),
                'dateFormat'=>'dd.mm.yy',
            ),
            'language'=> 'en',
        )); ?>
		<?php echo $form->error($model,'born'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'books'); ?>
        <?php echo $form->dropDownList($model, 'books', Book::getAllNames(), array('prompt' => 'Select', 'multiple' => true, 'selected' => 'selected')); ?>
        <?php echo $form->error($model,'books'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->