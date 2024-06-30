<?php
/** @var App\Kernel\View\ViewInterface $view
 * @var App\Kernel\Session\SessionInterface $session 
 * */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container content" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h2 class="text-center">Create Account</h2>
            <form action="/register" method="post">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">

                    <?php if ($session->has('email')) { ?>
                        <?php foreach ($session->getFlash('email') as $error) { ?>
                            <div class="text-danger"><?= $error ?>
                            </div>
                        <?php } ?>
                    <? } ?>

                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">

                    <?php if ($session->has('username')) { ?>
                        <?php foreach ($session->getFlash('username') as $error) { ?>
                            <div class="text-danger"><?= $error ?>
                            </div>
                        <?php } ?>
                    <? } ?>

                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">

                    <?php if ($session->has('password')) { ?>
                        <?php foreach ($session->getFlash('password') as $error) { ?>
                            <div class="text-danger"><?= $error ?>
                            </div>
                        <?php } ?>
                    <? } ?>

                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>
</div>

<?php $view->component('footer') ?>