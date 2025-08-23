<?php
/**
 * @var  \app\models\User $model
 */

?>

<div class="container mt-5">
  <h2>Login Form</h2>
  <?php $form = \app\form\Form::begin('', "post"); ?>

  <?php echo $form->field($model, 'email'); ?>
  <?php echo $form->field($model, 'password')->passwordField(); ?>


  <button type="submit" class="btn btn-primary">Submit</button>
  <?php \app\form\Form::end(); ?>
</div>
