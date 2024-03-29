<?php
require __DIR__ . '../../../vendor/autoload.php';

use App\Db\Pagination;
use App\Entidy\Caixa;
use App\Entidy\FormaPagamento;
use App\Session\Login;

define('TITLE','Abrir Caixa');
define('BRAND','Caixa');


Login::requireLogin();


$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);

$condicoes = [
    strlen($buscar) ? 'id LIKE "%'.str_replace(' ','%',$buscar).'%" or 
                       data LIKE "%'.str_replace(' ','%',$buscar).'%"' : null
];

$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

$qtd = Caixa:: getQtd($where);

$pagination = new Pagination($qtd, $_GET['pagina'] ?? 1, 5);

$listar = Caixa::getList('c.id as id,
c.data as data,
c.forma_pagamento_id as forma_pagamento_id,
c.valor as valor,
f.nome as pagamento',' caixa AS c
INNER JOIN
forma_pagamento AS f ON (c.forma_pagamento_id = f.id)',$where, 'c.id desc',$pagination->getLimit());

$pagamentos = FormaPagamento :: getList('*','forma_pagamento',null,'nome ASC');


include __DIR__ . '../../../includes/layout/header.php';
include __DIR__ . '../../../includes/layout/top.php';
include __DIR__ . '../../../includes/layout/menu.php';
include __DIR__ . '../../../includes/layout/content.php';
include __DIR__ . '../../../includes/caixa/caixa-form-list.php';
include __DIR__ . '../../../includes/layout/footer.php';

?>

<script>
$(document).ready(function(){
    $('.editbtn').on('click', function(){
        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        $('#id').val(data[0]);
        $('#data').val(data[1]);
        $('#valor').val(data[2]);
        $('#forma_pagamento_id').val(data[3]);
       
    });
});
</script>
