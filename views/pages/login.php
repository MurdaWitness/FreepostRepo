<?php /** 
 * @var App\Kernel\View\View $view 
 * @var App\Kernel\Session\Session $session 
 * */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container content" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h2 class="text-center">Sign In</h2>
            <form action="/login" method="post">

                <?php if ($session->has('error')) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $session->getFlash('error') ?>
                    </div>
                <? } ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                <!-- <div class="text-center mt-3">
                    <p>or sign in with</p>
                    <button type="button" class="btn btn-outline-danger">
                        <img src="/assets/icons/google.png" alt="Google"
                            style="width:20px; height:20px; margin-right:5px;">
                        Google
                    </button>
                    <button type="button" class="btn btn-outline-dark">
                        <img src="/assets/icons/github.png" alt="GitHub"
                            style="width:20px; height:20px; margin-right:5px;">
                        GitHub
                    </button>
                </div> -->
            </form>
        </div>
    </div>
</div>

<?php $view->component('footer') ?>