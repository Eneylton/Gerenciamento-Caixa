<?php

require __DIR__ . '../../../vendor/autoload.php';

$alertaCadastro = '';

define('TITLE', 'Editar Categoria');
define('BRAND', 'Categoria');

use App\Entidy\Movimentacao;
use  \App\Session\Login;


Login::requireLogin();

if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {

    header('location: index.php?status=error');

    exit;
}

$value = Movimentacao:: getID('*','movimentacoes',$_GET['id'],null,null);


if (!$value instanceof Movimentacao) {
    header('location: index.php?status=error');

    exit;
}


if (isset($_GET['id'])) {
    date_default_timezone_set('America/Sao_Paulo');

    $idcaixa = $_GET['caixa_id'];

    $din1               = $_GET['dinheiro'];
    $din2               = str_replace(".", "", $din1);
    $preco1             = str_replace(",", ".",$din2);

    $cart1              = $_GET['cartao'];
    $cart2              = str_replace(".", "", $cart1);
    $preco2             = str_replace(",", ".",$cart2);

    $deb1               = $_GET['debito'];
    $deb2               = str_replace(".", "", $deb1);
    $preco3             = str_replace(",", ".",$deb2);

    $deb1               = $_GET['pix'];
    $deb2               = str_replace(".", "", $deb1);
    $preco4             = str_replace(",", ".",$deb2);

    $transf1            = $_GET['transferencia'];
    $transf2            = str_replace(".", "", $transf1);
    $preco5             = str_replace(",", ".",$transf2);

    $value->catdespesas_id = $_GET['catdespesas_id'];
    $value->status =         $_GET['status'];
    $value->tipo =           $_GET['tipo'];
    $value->descricao =      $_GET['descricao'];
    $value->dinheiro =       $preco1;
    $value->cartao =         $preco2;
    $value->debito =         $preco3;
    $value->pix =            $preco4;
    $value->transferencia  = $preco5;
    $value->veiculo =        $_GET['veiculo'];
    $value->placa =          $_GET['placa'];
    $value->atualizar();

    header('location: movimentacao-list.php?id='.$idcaixa);

    exit;
}
