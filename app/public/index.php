<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $twig = new Page();

    echo $twig->render('Connection.html.twig', []);