<?php
session_start();

spl_autoload_register(function ($class_name){
    $file = __DIR__.'/'.str_replace('\\','/',$class_name).'.php';

    if(!file_exists($file)){
        throw new Exception("Class [{$class_name}] dose not exist in [{$file}] path");
    }
    require_once $file;
});

use Classes\Users;
$user = new Users();

switch ($_POST['do']){
    case 'create':
        $user->createTable();
        break;
    case 'registerUser':
        $id = $user->registerUser($_POST);
        echo $user->addUserActivity($id,'register');
        break;
    case 'loginUser':
        $id = $user->login($_POST);
        echo $user->addUserActivity($id,'login');
    break;
    case 'logoutUser':
        $user->logout();
        $id = $_SESSION['uid'];
        echo $user->addUserActivity($id,'logout');
    break;
    case 'addCountPageA':
        $id = $_SESSION['uid'];
        $user->reportsActivity($id,'view page A');
        echo $user->addUserActivity($id,'view page A');
    break;
    case 'addCountPageB':
        $id = $_SESSION['uid'];
        $user->reportsActivity($id,'view page B');
        echo $user->addUserActivity($id,'view page B');
    break;
    case 'addCountCowClick':
        $id = $_SESSION['uid'];
        $user->reportsActivity($id,'button click');
        echo $user->addUserActivity($id,'button click');
    break;
    case 'addCountDownloadClick':
        $id = $_SESSION['uid'];
        $user->reportsActivity($id,'download file');
        echo $user->addUserActivity($id,'download file');
    break;
    case 'getStat':
        if(!empty($_SESSION['uid'])) {
            echo($user->sortActivity($_SESSION['uid']));
        }
    break;
    case 'getTable':
        echo $user->createTable();
    break;
    case 'getActivity':
        echo $user->getUsersActivity('');
    break;
    case 'userSort':
        echo $user->getUsersActivity('userSort');
    break;
    case 'dateSort':
        echo $user->getUsersActivity('dateSort');
    break;

    default:
        echo 'some ajax to my functions';
    break;
}