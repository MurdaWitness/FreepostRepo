<?php /** 
  * @var App\Kernel\View\View $view 
  * @var App\Kernel\Auth\Auth $auth 
  * @var App\Models\Module $module 
  */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container content" style="padding-top: 30px; padding-bottom: 30px;">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="display-4"><?= htmlspecialchars($module->name() ?? '') ?></h1>
            <p class="lead"><?= htmlspecialchars($module->description() ?? '') ?></p>

            <h5>Status</h5>
            <p>
                <?php if ($module->status() == 'not depends') { ?>
                    <span class="status-green">Does not depend on third-party libraries</span>
                <?php } elseif ($module->status() == 'depends') { ?>
                    <span class="status-yellow">Depends on third-party libraries</span>
                <?php } elseif ($module->status() == 'unchecked') { ?>
                    <span class="status-grey">Not checked</span>
                <?php } ?>
            </p>

            <h5>Creation Date</h5>
            <p><?= $module->createdAt() ?? '' ?></p>

            <h5>Last Update</h5>
            <p><?= $module->updatedAt() ?? '' ?></p>
        </div>
        <div class="col-lg-1">
            <div class="vr"></div>
        </div>
        <div class="col-lg-3">
            <div class="py-3">
                <h5>Author</h5>
                <div class="media">
                    <img src="/assets/icons/user.png" class="user-picture mr-3" alt="User Photo">
                    <div class="media-body user-name">
                        <?= htmlspecialchars($auth->findUser($module->userId())->username() ?? '') ?>
                    </div>
                </div>
            </div>

            <div class="py-3">
                <h5>Number of Downloads</h5>
                <p><?= $module->downloadsCount() ?? '' ?> downloads</p>
            </div>

            <div class="py-3">
                <h5>Download</h5>
                <a href="/module/download?id=<?= $module->id() ?? '' ?>">
                    <div class="btn btn-primary">Download Module</div>
                </a>
            </div>

        </div>
    </div>
</div>

<?php $view->component('footer') ?>