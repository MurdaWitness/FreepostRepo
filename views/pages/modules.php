<?php /** 
  * @var App\Kernel\View\View $view 
  * @var App\Models\Module[] $modules 
  * @var string $query 
  */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container content" style="padding-top: 30px; padding-bottom: 30px;">
    <h2 class="text-center py-1">Query Results</h2>
    <form class="form-inline justify-content-center mt-3 mb-5" action="/modules" method="">
        <div class="form-group mb-2">
            <input type="text" class="form-control" name="query" id="query" placeholder="Search for modules..."
                value="<?= htmlspecialchars($query) ?? '' ?>">
        </div>
        <button type="submit" class="btn btn-primary mb-2 ml-2">Search</button>
    </form>
    <div class="row">
        <?php foreach ($modules as $module) { ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="/module?id=<?= $module->id() ?? '' ?>">
                            <h5 class="card-title"><?= htmlspecialchars($module->name()) ?? '' ?></h5>
                        </a>

                        <p class="card-text"><?= htmlspecialchars($module->briefDescription()) ?? '' ?></p>

                        <p class="mt-3"><img src="/assets/icons/user.png" alt="Downloads" class="icon">Author:
                            <?= htmlspecialchars($auth->findUser($module->userId())->username() ?? '') ?>
                        </p>

                        <p class="mt-3"><img src="/assets/icons/download.png" alt="Downloads" class="icon">Downloads:
                            <?= $module->downloadsCount() ?? '' ?>
                        </p>

                        <p><img src="/assets/icons/status.png" alt="Status" class="icon">Status:
                            <?php if ($module->status() == 'not depends') { ?>
                                <span class="status-green">Safe (no third-party libraries)</span>
                            <?php } elseif ($module->status() == 'depends') { ?>
                                <span class="status-yellow">Safe (depends on third-party libraries)</span>
                            <?php } elseif ($module->status() == 'unchecked') { ?>
                                <span class="status-grey">Not tested yet</span>
                            <?php } ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php $view->component('footer') ?>