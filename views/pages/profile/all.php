<?php
/** @var App\Kernel\View\ViewInterface $view
 * @var App\Models\Module $modules 
 * */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container mt-5" style="padding-bottom: 50px;">
    <h2 class="text-center mb-4">My Modules</h2>

    <!-- Modules Table -->
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brief Description</th>
                <th>Description</th>
                <th>Downloads</th>
                <th>Status</th>
                <th>User ID</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($modules) {
                foreach ($modules as $module) { ?>
                    <tr>
                        <td><?= $module->id() ?? '' ?></td>
                        <td><?= htmlspecialchars($module->name()) ?? '' ?></td>
                        <td><?= htmlspecialchars($module->briefDescription()) ?? '' ?></td>
                        <td><?= htmlspecialchars($module->description()) ?? '' ?></td>
                        <td><?= $module->downloadsCount() ?? '' ?></td>
                        <td><?= $module->status() ?? '' ?></td>
                        <td><?= $module->userId() ?? '' ?></td>
                        <td><?= $module->createdAt() ?? '' ?></td>
                        <td><?= $module->updatedAt() ?? '' ?></td>
                        <td>
                            <a href="/profile/edit?id=<?= $module->id() ?>">
                                <div class="btn btn-sm btn-primary">Edit</div>
                            </a>
                            <a href="/profile/delete?id=<?= $module->id() ?>">
                                <div class="btn btn-sm btn-danger">Delete</div>
                            </a>
                        </td>
                    </tr>
                <?php }
            } ?>
        </tbody>
    </table>
    <a href="/profile/add">
        <div class="btn btn-success">Add entry</div>
    </a>
</div>

<?php $view->component('footer') ?>