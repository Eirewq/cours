<?php

    require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    if(isset($_POST['send'])){
        var_dump($_POST);
        $page->insert('user', [
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),  
        ]);

        header('Location: index.php');
    }

    echo $page->render('register.html.twig', []);