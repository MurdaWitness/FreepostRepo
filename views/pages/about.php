<?php /** @var App\Kernel\View\View $view */
?>

<?php $view->component('header') ?>

<!-- Body -->
<div class="container content mt-5">
    <h2 class="text-center mb-4">About FreepostRepo.ru</h2>
    <p>FreepostRepo.ru is an open-source platform designed to facilitate the centralized distribution of software
        extensions for the Freepost client-server application. Freepost is an automated system for publishing content
        across various social networks. Its unique modular architecture allows developers to create modules for
        different social networks in any programming language, provided they adhere to the required interface.</p>

    <h3>Our Mission</h3>
    <p>Our mission is to provide a secure and efficient platform where developers can upload, manage, and distribute
        their Freepost modules. We aim to foster a community of developers who contribute to the continuous improvement
        and expansion of Freepost's capabilities.</p>

    <h3>Features</h3>
    <ul>
        <li><strong>Centralized Repository:</strong> A single platform to find, download, and manage Freepost modules.
        </li>
        <li><strong>Secure Uploads:</strong> Ensure that modules uploaded to the platform are safe and reliable.</li>
        <li><strong>Content moderation:</strong> Our moderators manually check each module to prevent the existence of
            malicious extensions.</li>
    </ul>

    <h3>Getting Started</h3>
    <p>If you are a developer looking to contribute to the Freepost ecosystem, you can start by creating an account and
        uploading your modules. Ensure that your modules follow the interface guidelines provided in our documentation.
    </p>

    <h3>Contact Us</h3>
    <p>If you have any questions, feedback, or need support, feel free to reach out to us at <a
            href="mailto:support@freepostrepo.ru">support@freepostrepo.ru</a>.</p>
</div>

<?php $view->component('footer') ?>