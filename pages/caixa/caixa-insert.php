<?php 

require __DIR__.'../../../vendor/autoload.php';

use App\Entidy\Caixa;
use App\Session\Login;

define('TITLE','Abrir Caixa');
define('BRAND','Caixa');

$alertaLogin  = '';
$alertaCadastro = '';

$usuariologado = Login:: getUsuarioLogado();

$usuario = $usuariologado['id'];

Login::requireLogin();


if(isset($_POST['valor'])){

        $item = new Caixa;
        $item->valor = $_POST['valor'];
        $item->forma_pagamento_id = $_POST['forma_pagamento_id'];
        $item->cadastar();

        header('location: caixa-list.php?status=success');
        exit;
    }
  
   