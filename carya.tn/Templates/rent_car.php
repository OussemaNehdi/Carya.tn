 
<!-- // This file will include the fitering menu on the left and the fetching (from Controller folder) on the right
// The filter menu will be compatible with this page as well as the user listing page (More on filter_menu.php) -->

<?php 
$title="Rental Car Website";
$class="rent-body"
?>

<?php ob_start(); ?>
<div class="main-container">
    <div class="filter-menu" id="filterMenuContainer">
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Templates/filter_menu.php'; ?>
    </div>
    <div class="cars-list content-container">
        <!-- This is where the fetched cars will be displayed -->
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Mini-PHP-Project/carya.tn/Templates/fetch_cars.php'; ?>
    </div>
</div>
<script>
    window.addEventListener('scroll', function() {
    var filterMenuContainer = document.getElementById('filterMenuContainer');
    var contentContainer = document.querySelector('.content-container');
    var scrollY = window.scrollY || window.pageYOffset;

    if (scrollY > contentContainer.offsetTop) {
        filterMenuContainer.style.top = (scrollY - contentContainer.offsetTop) + 'px';
    } else {
        filterMenuContainer.style.top = '0';
    }
    });
</script>

<?php $content = ob_get_clean();?>

<?php require('layout.php')?>