<?php 

require __DIR__.'../../../vendor/autoload.php';



$alertaCadastro = '';

define('TITLE','Editar');
define('BRAND','Editar ');

use App\Entidy\Caixa;
use App\Session\Login;


Login::requireLogin();



if(!isset($_GET['id']) or !is_numeric($_GET['id'])){
 
    header('location: index.php?status=error');

    exit;
}

$value = Caixa:: getID('*','caixa',$_GET['id'],null,null);


if(!$value instanceof Caixa){
    header('location: index.php?status=error');

    exit;
}



if(isset($_GET['valor'])){
    
    $value->valor = $GET['valor'];
    $value->forma_pagamento_id = $GET['forma_pagamento_id'];
    $value-> atualizar();

    header('location: caixa-list.php?status=edit');

    exit;
}


