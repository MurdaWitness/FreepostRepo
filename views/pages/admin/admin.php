<?php /** @var App\Kernel\View\View $view */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container content mt-5">
    <h2 class="text-center mb-4">Admin Section</h2>
    <div class="list-group">
        <a href="/admin/modules" class="list-group-item list-group-item-action">Manage Modules</a>
    </div>
</div>

<?php $view->component('footer') ?>