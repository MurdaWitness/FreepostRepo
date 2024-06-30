<?php
/** @var App\Kernel\View\View $view 
 * @var App\Kernel\Auth\Auth $auth 
 */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $view->title ?></title>
    <link rel="icon" href="/assets/icons/favicon.png">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/styles.css" rel="stylesheet">
</head>

<body>

    <div class="container-flex">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="/">FreepostRepo.com</a>
            <div class="collapse navbar-collapse">
                <?php if ($auth->check()) { ?>
                    <ul class="navbar-nav ml-auto">
                        <?php if ($auth->user()->role() == 'admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin">
                                    <img src="/assets/icons/admin.png" alt="Admin Section" class="header-icon">
                                    Admin section
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/profile">
                                <img src="/assets/icons/user.png" alt="User Icon" class="header-icon">
                                <?= htmlspecialchars($auth->user()->username() ?? '') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">
                                <img src="/assets/icons/logout.png" alt="Log out" class="header-icon">
                                Log out
                            </a>
                        </li>
                    </ul>
                <?php } else { ?>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/register">
                                <img src="/assets/icons/register.png" alt="Create Account Icon" class="header-icon">
                                Create account
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">
                                <img src="/assets/icons/login.png" alt="Sign In Icon" class="header-icon">
                                Sign in
                            </a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </nav>