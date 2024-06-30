<?php
/** @var App\Kernel\View\ViewInterface $view
 * @var App\Models\Module $module
 * @var App\Kernel\Session\Session $session
 * */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container content" style="padding-top: 30px; padding-bottom: 30px;">
    <h1 class="my-4">Edit Module</h1>
    <form action="/admin/modules/edit" method="post" enctype='multipart/form-data'>
        <div class="form-row">
            <input type="hidden" name="moduleId" id="moduleId" value="<?= htmlspecialchars($module->id() ?? '') ?>">
            <div class="form-group col-md-4">
                <label for="moduleName">Module Name</label>
                <input type="text" class="form-control" name="moduleName" id="moduleName"
                    placeholder="Enter module name" value="<?= htmlspecialchars($module->name() ?? '') ?>" required>

                <?php if ($session->has('moduleName')) { ?>
                    <ul>
                        <?php foreach ($session->getFlash('moduleName') as $error) { ?>
                            <li>
                                <div class="text-danger"><?= $error ?>
                            </li>
                        <?php } ?>
                    </ul>
                <? } ?>

            </div>
            <div class="form-group col-md-4">
                <label for="moduleDownloads">Downloads Count</label>
                <input type="number" class="form-control" name="moduleDownloads" id="moduleDownloads"
                    placeholder="Enter number of downloads" step="1" min="0"
                    value="<?= htmlspecialchars($module->downloadsCount() ?? '') ?>" required>

                <?php if ($session->has('moduleDownloads')) { ?>
                    <ul>
                        <?php foreach ($session->getFlash('moduleDownloads') as $error) { ?>
                            <li>
                                <div class="text-danger"><?= $error ?>
                            </li>
                        <?php } ?>
                    </ul>
                <? } ?>

            </div>
            <div class="form-group col-md-4">
                <label for="userId">User ID</label>
                <input type="number" class="form-control" name="userId" id="userId" placeholder="Enter creator ID"
                    step="1" min="0" value="<?= htmlspecialchars($module->userId() ?? '') ?>" required>

                <?php if ($session->has('userId')) { ?>
                    <ul>
                        <?php foreach ($session->getFlash('userId') as $error) { ?>
                            <li>
                                <div class="text-danger"><?= $error ?>
                            </li>
                        <?php } ?>
                    </ul>
                <? } ?>

            </div>
        </div>
        <div class="form-group">
            <label for="moduleBriefDescription">Brief Description</label>
            <input type="text" class="form-control" name="moduleBriefDescription" id="moduleBriefDescription"
                placeholder="Enter brief description" value="<?= htmlspecialchars($module->briefDescription() ?? '') ?>"
                required>

            <?php if ($session->has('moduleBriefDescription')) { ?>
                <ul>
                    <?php foreach ($session->getFlash('moduleBriefDescription') as $error) { ?>
                        <li>
                            <div class="text-danger"><?= $error ?>
                        </li>
                    <?php } ?>
                </ul>
            <? } ?>

        </div>
        <div class="form-group">
            <label for="moduleDescription">Description</label>
            <textarea class="form-control" name="moduleDescription" id="moduleDescription" rows="4"
                placeholder="Enter detailed description"
                required><?= htmlspecialchars($module->description() ?? '') ?></textarea>

            <?php if ($session->has('moduleDescription')) { ?>
                <ul>
                    <?php foreach ($session->getFlash('moduleDescription') as $error) { ?>
                        <li>
                            <div class="text-danger"><?= $error ?>
                        </li>
                    <?php } ?>
                </ul>
            <? } ?>

        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-file">
                    <label for="moduleFiles">Module Files</label>
                    <input type="file" class="form-file-input" name="moduleFiles[]" id="moduleFiles" multiple>

                    <?php if ($session->has('moduleFiles')) { ?>
                        <ul>
                            <?php foreach ($session->getFlash('moduleFiles') as $error) { ?>
                                <li>
                                    <div class="text-danger"><?= $error ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <? } ?>

                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="moduleStatus" id="status1" value="depends"
                        <?= $module->status() == 'depends' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="status1">
                        Depends on third-party libraries
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="moduleStatus" id="status2" value="not depends"
                        <?= $module->status() == 'not depends' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="status2">
                        Does not depend on third-party libraries
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="moduleStatus" id="status3" value="unchecked"
                        <?= $module->status() == 'unchecked' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="status3">
                        Not checked
                    </label>
                </div>

                <?php if ($session->has('moduleStatus')) { ?>
                    <ul>
                        <?php foreach ($session->getFlash('moduleStatus') as $error) { ?>
                            <li>
                                <div class="text-danger"><?= $error ?>
                            </li>
                        <?php } ?>
                    </ul>
                <? } ?>

            </div>
        </div>
        <button type="submit" class="btn btn-success">Edit Module</button>
    </form>
</div>


<?php $view->component('footer') ?>