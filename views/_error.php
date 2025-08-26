<!-- views/_error.php -->
<h1><?php echo $exception->getCode() ?> - <?php echo $exception->getMessage() ?></h1>
<pre>
<?php echo $exception->getTraceAsString() ?>
</pre> 
