<?php
/**
 * @var  \app\models\User $model
 */
$this->title = 'Register';
?>

<div class="container mt-5">
  <h2>Registration Form</h2>
  <?php $form = \app\form\Form::begin('', "post"); ?>

  <div class="row">
    <div class="col">
      <?php echo $form->field($model, 'firstname'); ?>
    </div>
    <div class="col">
      <?php echo $form->field($model, 'lastname'); ?>
    </div>
  </div>

  <?php echo $form->field($model, 'email'); ?>
  <?php echo $form->field($model, 'password')->passwordField(); ?>
  <?php echo $form->field($model, 'confirmPassword')->passwordField(); ?>

  <button type="submit" class="btn btn-primary">Submit</button>
  <?php \app\form\Form::end(); ?>
</div>
