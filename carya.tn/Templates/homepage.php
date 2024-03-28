<?php 
$title="Carya.tn";
$class=""
?>

<?php ob_start(); ?>
<h1>Welcome to carya.tn</h1>
<p>A website where you can rent or list your car up for renting</p>
<p>Use the navigation bar to explore the website</p>
<?php $content = ob_get_clean();?>

<?php require('layout.php')?>