<?php

$total_dinheiro = 0;
$total_credito = 0;
$total_debito = 0;
$total_pix = 0;
$total_transferencia = 0;
$total_geral = 0;
$saida = 0;
$caixa = 0;
$saldo = 0;


$id = '';

$list = '';

$resultados = '';

foreach ($listar as $item) {
   $id_caixa = $item->caixa_id;
   $total_credito += $item->cartao;
   $total_debito += $item->debito;
   $total_pix+= $item->pix;
   $total_transferencia += $item->transferencia;

   switch ($item->tipo) {
      case '1':
         $total_dinheiro += $item->dinheiro;
         break;
      
      default:
         $saida += $item->dinheiro;
         break;
   }


   $resultados .= '<tr>
                      <td style="display:none">' . $item->id . '</td>
                      <td style="display:none">' . $item->catdespesas_id . '</td>
                      <td style="display:none">' . $item->data . '</td>
                      <td style="display:none">' . $item->descricao . '</td>
                      <td style="display:none">' . $item->tipo . '</td>
                      <td style="display:none">' . $item->status . '</td>
                      <td style="display:none">' . $item->dinheiro . '</td>
                      <td style="display:none">' . $item->cartao . '</td>
                      <td style="display:none">' . $item->debito . '</td>
                      <td style="display:none">' . $item->pix . '</td>
                      <td style="display:none">' . $item->transferencia . '</td>
                      <td style="display:none">' . $item->categoria . '</td>
                      

                     <td>

                     <span style="color:' . ($item->status <= 0 ? '#ff2121' : '#00ff00') . '"> 
                     <i class="fa fa-circle" aria-hidden="true"></i> 
                     </span>

                     </td>
                     <td style="width:150px">
                      
                      <span style="color:' . ($item->status <= 0 ? '#ff2121' : '#00ff00') . '">
                      ' . ($item->status <= 0 ? 'EM ABERTO' : 'PAGO') . '
                      </span>
                      
                      </td>

                      <td style="width:150px">
                      
                      <span style="color:' . ($item->tipo <= 0 ? '#ff2121 ' : '#48da59 ') . '">
                      ' . ($item->tipo <= 0 ? 'SAIDA' : 'ENTRADA') . '
                      </span>
                      
                      </td>
                    
                      <td>' . date('d/m/Y à\s H:i:s ', strtotime($item->data)) . '</td>

                      <td style="text-transform: uppercase; font-weight: 600; width:500px">' . $item->categoria . '</td>

                      <td style="text-transform: uppercase;font-weight: 600; ">
                      <span style="color:' . ($item->tipo <= 0 ? '#ff2121 ' : '#fff ') . '">
                      R$ ' . number_format($item->dinheiro,"2",",",".") . '
                      </span>
                      
                      </td>

                      <td style="font-weight: 600; width:50px"> R$ ' . number_format($item->cartao, "2", ",", ".") . '</td>
                      <td style="font-weight: 600; width:50px"> R$ ' . number_format($item->debito, "2", ",", ".") . '</td>
                      <td style="font-weight: 600; width:50px"> R$ ' . number_format($item->pix, "2", ",", ".") . '</td>
                      <td style="font-weight: 600; width:50px"> R$ ' . number_format($item->transferencia, "2", ",", ".") . '</td>
                    
                      <td style="text-align: center;">
                        
                      
                      <button type="submit" class="btn btn-warning editbtn"> <i class="fa fa-credit-card" aria-hidden="true"></i> </button>
                      &nbsp;

                      </td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="11" class="text-center" > Nenhum movimentação encontrada !!!!! </td>
                                                     </tr>';


$total_geral += ($total_dinheiro + $total_credito + $total_debito + $total_pix + $total_transferencia);

$caixa = ($total_geral - $saida); 

$saldo = ($total_dinheiro - $saida);

//PAGINAÇÂO

$paginacao = '';
$paginas = $pagination->getPages();

foreach ($paginas as $key => $pagina) {
   $class = $pagina['atual'] ? 'btn-primary' : 'btn-secondary';
   $paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '">

                  <button type="button" class="btn ' . $class . '">' . $pagina['pagina'] . '</button>
                  </a>';
}

?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card card-purple">
               <div class="card-header">

                  <form method="get">
                     <div class="row ">
                        <div class="col-4">

                           <label>Pesquisar</label>
                           <input type="text" class="form-control" name="buscar" value="<?= $buscar ?>">

                        </div>


                        <div class="col d-flex align-items-end">
                           <button type="submit" class="btn btn-warning" name="">
                              <i class="fas fa-search"></i>

                              Pesquisar

                           </button>

                        </div>


                     </div>

                  </form>
               </div>

               <div class="table-responsive">

                  <table class="table table-bordered table-dark table-bordered table-hover table-striped">
                     <thead>
                        <tr>
                           <td colspan="11">
                              <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"> <i class="fas fa-plus"></i> &nbsp; Adicionar</button>
                              <a href="movimentacao-detalhe.php?id=<?= $id_caixa ?>" >
                                 <button style="margin-right:50px; font-weight:600; font-size:x-large" type="submit" class="<?= $total_diaria <= 0 ? 'btn btn-secondary' : 'btn btn-default' ?> float-right btn-lg"> <i class="fa fa-print" aria-hidden="true"></i>
                                    MOVIMENTAÇÕES </button>
                              </a>
                              <button type="submit" style="margin-right:50px; font-weight:600; font-size:x-large" class="btn btn-default float-right" data-toggle="modal" data-target="#modal-data"> <i class="fa fa-print"></i> &nbsp; RELATÓRIOS</button>
                              

                              <a href="gerar-pdf.php" target="_blank">
                                 <button style="margin-right:50px; font-weight:600; font-size:x-large" type="submit" class="<?= $total_diaria <= 0 ? 'btn btn-danger' : 'btn btn-default' ?> float-right btn-lg"> <i class="fa fa-print" aria-hidden="true"></i>
                                    FECHAMENTO </button>
                              </a>
                              <button style="margin-right:50px; font-weight:600; font-size:x-large" type="submit" class="<?= $caixa <= 0 ? 'btn btn-danger' : 'btn btn-success' ?> float-right btn-lg"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                                SALDO R$ &nbsp;<?= number_format($saldo, "2", ",", ".")  ?></button>


                           </td>
                        </tr>
                        <tr>
                           <th style="text-align: center; width:50px"> <i class="fa fa-align-justify" aria-hidden="true"></i> </th>

                           <th style="text-align: center;"> STATUS </th>
                           <th style="text-align: center"> TIPO </th>
                           <th style="text-align: left;width:280px"> DATA </th>
                           <th style="text-align: left;"> CATEGORIA </th>
                           <th style="text-align: left;width:130px"> DINHEIRO </th>
                           <th style="text-align: left;width:130px"> CRÉDITO </th>
                           <th style="text-align: left;width:130px"> DÉBITO </th>
                           <th style="text-align: left;width:130px"> PIX </th>
                           <th style="text-align: left;width:130px"> TRANSFERÊNCIA </th>
                           <th style="text-align: center;width:200px"> AÇÃO </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?= $resultados ?>
                     </tbody>
                     <tr>
                        <td colspan="5" style="text-align: right;">
                           <span style="font-size: 20px; font-weight:600"> TOTAL</span>
                        </td>
                        <td colspan="1">
                           <span style="font-size: 20px; font-weight:600">R$ <?= number_format($saldo,"2",",",".") ?> </span>
                        </td>
                        <td colspan="1">
                           <span style="font-size: 20px; font-weight:600;color:#79d7ad">R$ <?= number_format($total_credito,"2",",",".") ?> </span>
                        </td>
                        <td colspan="1" style="text-align: left">
                           <span style="font-size: 20px; font-weight:600; color:#79d7ad">R$ <?= number_format($total_debito,"2",",",".") ?></span>
                        </td>
                        <td colspan="1" style="text-align:left">
                           <span style="font-size: 20px; font-weight:600; color:#79d7ad">R$ <?= number_format($total_pix,"2",",",".") ?></span>
                        </td>
                        <td colspan="1" style="text-align: left">
                           <span style="font-size: 20px; font-weight:600; color:#79d7ad">R$ <?= number_format($total_transferencia,"2",",",".") ?></span>
                        </td>
                        <td colspan="1" style="text-align: center">
                           <?php
                             if($caixa <= 0){
                                echo '<span style="font-size: 20px; font-weight:600; color:#ff0000">R$ &nbsp;'. number_format($caixa,"2",",","."). '</span>';
                             }else{
                              echo '<span style="font-size: 20px; font-weight:600; color:#94dd04">R$  &nbsp;'. number_format($caixa,"2",",","."). '</span>';
                             }
                           ?>
                        </td>
                     </tr>

                  </table>

               </div>


            </div>

         </div>

      </div>

   </div>

</section>

<?= $paginacao ?>


<div class="modal fade" id="modal-default">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <form action="./movimentacao-insert.php" method="post">

            <input type="hidden" name="idcaixa" value="<?= $idcaixa ?>">

            <div class="modal-header">
               <h4 class="modal-title">MOVIMENTAR
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="card-body">

               <div class="form-group">
                  <div class="row">
                     <div class="col-6">
                        <div class="form-group">
                           <label>Veículo</label>
                           <input style="text-transform: uppercase;" type="text" class="form-control" name="veiculo">

                        </div>

                     </div>
                     <div class="col-6">

                        <label>Placa</label>
                        <input style="text-transform: uppercase;" class="form-control" name="placa">

                     </div>



                     <div class="col-12">
                        <div class="form-group">
                           <label>Categorias</label>
                           <select class="form-control select2bs4" style="width: 100%;" name="catdespesas_id" required>

                              <option value=""> Selecione uma categoria </option>
                              <?php

                              foreach ($categorias as $item) {
                                 echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                              }
                              ?>

                           </select>
                        </div>
                     </div>
                     <div class="col-2">
                        <div class="form-group">
                           <label>Dinheiro</label>
                           <input placeholder="R$ 0,00" type="text" class="form-control" name="dinheiro" id="dinheiro">
                        </div>
                     </div>
                     <div class="col-2">
                        <div class="form-group">
                           <label>Crédito</label>
                           <input  placeholder="R$ 0,00"  type="text" class="form-control" name="credito" id="dinheiro2">
                        </div>
                     </div>
                     <div class="col-2">
                        <div class="form-group">
                           <label>Débito</label>
                           <input  placeholder="R$ 0,00"  type="text" class="form-control" name="debito" id="dinheiro3">
                        </div>
                     </div>
                     <div class="col-3">
                        <div class="form-group">
                           <label>Pix</label>
                           <input  placeholder="R$ 0,00"  type="text" class="form-control" name="pix" id="dinheiro4">
                        </div>
                     </div>
                     <div class="col-3">
                        <div class="form-group">
                           <label>Transferência</label>
                           <input  placeholder="R$ 0,00"  type="text" class="form-control" name="transferencia" id="dinheiro5">
                        </div>
                     </div>

                     <div class="col-4">
                        <div class="form-group">

                           <label>Status</label>
                           <div>
                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="status" value="1" checked> Pago
                                 </label>
                              </div>

                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="status" value="0"> Em aberto
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="form-group">

                           <label>Tipo</label>
                           <div>

                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="tipo" value="1" checked> Entrada
                                 </label>
                              </div>

                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="tipo" value="0"> Saida
                                 </label>
                              </div>



                           </div>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="form-group">
                        <label>Observação</label>
                           <textarea class="form-control" aria-label="With textarea" name="descricao"></textarea>
                        </div>
                     </div>

                  </div>

               </div>


               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">FECHAR</button>
                  <button type="submit" class="btn btn-primary">SALVAR</button>
               </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- EDITAR -->

<div class="modal fade" id="editmodal">
   <div class="modal-dialog">
      <form action="./movimentacao-edit.php" method="GET">
         <input type="hidden" name="id" id="id">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" style="font-weight:600; text-transform:uppercase; font-size:22px">Pagamento
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">

               <div class="form-group">

                  <div class="row">
                     <div class="col-lg-2 col-2">
                        <div class="form-group">
                           <i style="color:#ff0000; margin-top:10px" class="fa fa-circle"></i>
                        </div>
                     </div>
                     <div class="col-lg-9 col-9">
                        <div class="form-group">

                           <span style="font-size: 23px;"><?php echo date("d/m/Y H:i:s");  ?></span>

                        </div>
                     </div>


                     <div class="col-lg-8 col-8">
                        <div class="form-group">
                           <label>Despesa</label>
                           <input style="background-color:#ffca10;color:#121212;border:none;font-weight:600; text-transform:uppercase; font-size:13px" type="text" class="form-control" name="categoria" id="categoria" required disabled>

                        </div>
                     </div>
                     <div class="col-lg-4 col-4">
                        <div class="form-group">
                           <label>Valor à pagar </label>
                           <input style="border:none !important; background-color:#a20808;color:#fff;font-size:18px;font-weight:600 " type="text" class="form-control" name="valor" id="valor" required>

                        </div>
                     </div>

                     <div class="col-lg-8 col-8">


                        <div class="form-group">
                           <label>Forma de dinheiro</label>
                           <select class="form-control select2bs4" style="width: 100%;" name="form_pagamento" required>

                              <option value=""> Selecione uma categoria </option>
                              <?php

                              foreach ($pagamentos as $item) {
                                 echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                              }
                              ?>

                           </select>

                        </div>
                     </div>

                     <div class="col-lg-4 col-4">

                        <div class="form-group">
                           <label>Valor Recebido </label>
                           <input placeholder="R$" style="border:none !important; background-color:#3d9970;color:#fff;font-size:18px;font-weight:600 " type="text" class="form-control" name="valor2" id="dinheiro3" required>
                        </div>

                     </div>

                  </div>
               </div>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">FECHAR</button>
               <button type="submit" class="btn btn-primary">PAGAR
               </button>
            </div>
         </div>
      </form>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-data">
   <div class="modal-dialog modal-lg">
      <div class="modal-content ">
         <form action="./gerar-data-pdf.php" method="GET" enctype="multipart/form-data">

            <div class="modal-header">
               <h4 class="modal-title">Relatórios
               </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="card-body">

               <div class="form-group">

                  <div class="row">

                     <div class="col-lg-4 col-4">
                        <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>" name="dataInicio">
                     </div>


                     <div class="col-lg-4 col-4">
                        <input class="form-control" type="date" value="<?php echo date('Y-m-d') ?>" name="dataFim">
                     </div>
                     <div class="col-lg-4 col-4">
                        <div class="form-group">
                           <div>
                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="status" value="1"> Pago
                                 </label>
                              </div>

                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="status" value="0"> Em aberto
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>



                  </div>
                  <div class="row">

                     <div class="col-lg-4 col-4">

                        <select class="form-control select2bs4" style="width: 100%;" name="form_pagamento" required>

                           <option value=""> Selecione uma categoria </option>
                           <?php

                           foreach ($pagamentos as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>
                     </div>


                     <div class="col-lg-4 col-4">

                        <select class="form-control select" name="catdespesas_id">
                           <option value=""> Categaria </option>
                           <?php

                           foreach ($categorias as $item) {
                              echo '<option value="' . $item->id . '">' . $item->nome . '</option>';
                           }
                           ?>

                        </select>

                     </div>
                     <div class="col-lg-4 col-4">
                        <div class="form-group">
                           <div>
                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="tipo" value="1"> Receita
                                 </label>
                              </div>

                              <div class="form-check form-check-inline">
                                 <label class="form-control">
                                    <input type="radio" name="tipo" value="0"> Despesa
                                 </label>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>

            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
               <button type="submit" class="btn btn-primary">Gerar relatório</button>
            </div>

         </form>

      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>