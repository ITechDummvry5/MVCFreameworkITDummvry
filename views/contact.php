<?php
$this->title = 'Contact';
/**
 * @var  \app\models\ContactForm $model
 */

?>

<?php $form = \app\form\Form::begin('', "post"); ?>
<?php echo $form->field($model, 'name') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo $form->field($model, 'subject') ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php \app\form\Form::end(); ?>


