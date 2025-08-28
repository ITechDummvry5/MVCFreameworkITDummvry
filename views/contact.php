<?php

use app\form\TextAreaField;
use app\form\Form;

$this->title = 'Contact';
/**
 * @var  \app\models\ContactForm $model
 */

?>

<?php $form = Form::begin('', "post"); ?>
<?php echo $form->field($model, 'name') ?>
<?php echo $form->field($model, 'email') ?>
<?php echo new TextAreaField($model, 'subject') ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end(); ?>


