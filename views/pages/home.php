<?php /** @var App\Kernel\View\View $view */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container text-center content" style="padding-top: 90px; padding-bottom: 50px;">
    <h1 class="display-3">FreepostRepo.com</h1>
    <p class="lead">Official Freepost modules repository</p>
    <form class="form-inline justify-content-center mt-5" action="/modules" method="">
        <div class="form-group mb-2">
            <input type="text" class="form-control" name="query" id="query"
                placeholder="Search for modules...">
        </div>
        <button type="submit" class="btn btn-primary mb-2 ml-2">Search</button>
    </form>
</div>

<?php $view->component('footer') ?>