<?php

if (isset($_GET['status'])) {

   switch ($_GET['status']) {
      case 'success':
         $icon  = 'success';
         $title = 'Parabéns';
         $text = 'Cadastro realizado com Sucesso !!!';
         break;

      case 'del':
         $icon  = 'error';
         $title = 'Parabéns';
         $text = 'Esse usuário foi excluido !!!';
         break;

      case 'edit':
         $icon  = 'warning';
         $title = 'Parabéns';
         $text = 'Cadastro atualizado com sucesso !!!';
         break;


      default:
         $icon  = 'error';
         $title = 'Opss !!!';
         $text = 'Você não tem nenhum saldo na carteira até o momento!!!';
         break;
   }

   function alerta($icon, $title, $text)
   {
      echo "<script type='text/javascript'>
      Swal.fire({
        type:'type',  
        icon: '$icon',
        title: '$title',
        text: '$text'
       
      }) 
      </script>";
   }

   alerta($icon, $title, $text);
}

$sub_total = 0;
$dev_total = 0;
$bruto = 0;
$saldo = 0;
$sub = 0;
$calc = 0;

$sub_total_dev = 0;
$dev_total_dev = 0;
$bruto_dev = 0;
$saldo_dev = 0;
$sub_dev = 0;
$calc_dev = 0;

$resultados = '';


foreach ($entregas as $item) {



   $id = $item->id;


   $sub =   $sub_total * 2;

   $calc += $sub;

   $bruto += $sub_total;

   $saldo = $bruto * 2;

   $resultados .= '<tr>
                     
                      <td style="text-transform:uppercase">' . $item->id . '</td>
                      <td style="text-transform:uppercase">' .  date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</td>
                      <td style="text-transform:uppercase">' . $item->apelido . '</td>
                      <td style="text-transform:uppercase; text-align:center"> <h5><span class="badge badge-pill badge-success">' . $item->qtd . '</span></h5> </td>
                      
                      <td style="text-align: center; width:100px">R$ ' . number_format($sub, "2", ",", ".") . '</td>
                      </tr>

                      ';
}

$resultados = strlen($resultados) ? $resultados : '<tr>
                                                     <td colspan="6" class="text-center" > Nenhum cliente cadastrado !!!!! </td>
                                                     </tr>';

foreach ($devolucoes as $item) {

   $codigo = $item->apelido;

   $id = $item->id;

   $sub_dev =   $sub_total_dev * 2;

   $calc_dev += $sub_dev;

   $bruto_dev += $item->qtd;

   $saldo_dev = $bruto_dev * 2;

   $resultados2 .= '<tr>
                                                                        
        
         <td style="text-transform:uppercase">' .  date('d/m/Y  Á\S  H:i:s', strtotime($item->data)) . '</td>
         <td style="text-transform:uppercase">' . $item->apelido . '</td>
     
         <td style="text-transform:uppercase; text-align:left"> <h5><span class="badge badge-pill badge-secondary">' . $item->ocorrencias . '</span></h5> </td>
         <td style="text-transform:uppercase; text-align:center"> <h5><span class="badge badge-pill badge-danger">' . $item->qtd . '</span></h5> </td>
         
         
         <td style="text-align: center; width:100px">R$ ' . number_format($sub_dev, "2", ",", ".") . '</td>
         </tr>

         ';
}

$resultados2 = strlen($resultados2) ? $resultados2 : '<tr>
                                                         <td colspan="6" class="text-center" > Nenhum cliente cadastrado !!!!! </td>
                                                         </tr>';



?>

<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-6">
            <div class="card">
               <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                     <h3 class="card-title">PRODUÇÃO DIÁRIA</h3>
                     <a href="gerar-pdf.php?id=<?php echo $codigo ?>" target="_blank"> IMPRIMIR RELATÓRIO</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="d-flex">
                     <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Quantidade: &nbsp; <?= $bruto ?></span>

                     </p>
                     <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                           <i class="fas fa-arrow-up"></i>&nbsp; R$ <?= number_format($saldo, "2", ",", ".") ?>
                        </span>
                        <span class="text-muted">Desde o último dia</span>
                     </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="card-body">

                     <table class="table">
                        <thead>
                           <tr>
                              <th>CÓDIGO</th>
                              <th>DATA ENTREGA</th>
                              <th>ENTREGADOR</th>
                              <th>ENTREGA</th>
                             
                              <th>SALDO</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <?= $resultados ?>
                           </tr>
                           <tr>
                              <td colspan="3" style="text-align: right;">
                                 TOTAL
                              </td>
                              <td style="text-align: center;">
                                 <?= $bruto ?>
                              </td>
                              <td style="text-align: center;">
                                 R$ <?= number_format($calc, "2", ",", ".") ?>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                     <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Data
                     </span>

                     <span>
                        <i class="fas fa-square text-gray"></i> <?= date('d/m/Y') ?>
                     </span>
                  </div>
               </div>
            </div>

         </div>

         <div class="col-lg-6">
            <div class="card">
               <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                     <h3 class="card-title">PRODUÇÃO DIÁRIA</h3>
                     <a href="gerar-pdf.php?id=<?php echo $codigo ?>" target="_blank">RELATÓRIO DETALHADO</a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="d-flex">
                     <p class="d-flex flex-column">
                        <span class="text-bold text-lg">Quantidade: &nbsp; <?= $bruto_dev ?></span>

                     </p>
                     <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-danger">
                           <i class="fas fa-arrow-down"></i>&nbsp; R$ 0,00
                        </span>
                        <span class="text-muted">Desde o último dia</span>
                     </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="card-body">

                     <table class="table">
                        <thead>
                           <tr>
                            
                              <th>DATA DEVOLUÇÃO</th>
                              <th>ENTREGADOR</th>
                              <th>OCORRÊNCIAS</th>
                              <th>DEVOLUÇÕES</th>             
                              <th>SALDO</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <?= $resultados2 ?>
                           </tr>
                           <tr>
                              <td colspan="3" style="text-align: right;">
                                 TOTAL
                              </td>
                              <td style="text-align: center;">
                                 <?= $bruto_dev ?>
                              </td>
                              <td style="text-align: center;">
                                 R$ <?= number_format($calc_dev, "2", ",", ".") ?>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                     <span class="mr-2">
                        <i class="fas fa-square text-primary"></i> Data
                     </span>

                     <span>
                        <i class="fas fa-square text-gray"></i> <?= date('d/m/Y') ?>
                     </span>
                  </div>
               </div>
            </div>

         </div>

         <div class="col-lg-12">
            <div class="card">
               <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                     <h3 class="card-title">
                        <P>PRODUÇÃO DIÁRIA</P>
                     </h3>
                     <a href="javascript:void(0);">TOTAL POR DIA </a>
                  </div>
               </div>
               <div class="card-body">
                  <div class="d-flex">
                     <p class="d-flex flex-column">
                        <span class="text-bold text-lg">R$ <?= number_format($saldo, "2", ",", ".") ?></span>
                        <span>Acumulado do dia</span>
                     </p>
                     <p class="ml-auto d-flex flex-column text-right">
                        <span class="text-success">
                           <i class="fas fa-arrow-up"></i> &nbsp; Entregas <?= $bruto ?> / <span class="text-danger">
                           <i class="fas fa-arrow-down"></i> &nbsp; Devoluções <?= $bruto_dev ?>
                        </span>
                        </span>
                        <span class="text-muted">Acumulado do dia </span>
                     </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="card-body">

                     <canvas id="myChart2" width="400" height="130"></canvas>

                  </div>

                  <div class="d-flex flex-row justify-content-end">
                     <span class="mr-2">
                        <i class="fas fa-square text-success"></i> Entrega: <?= $bruto ?>
                     </span>

                     <span>
                        <i class="fas fa-square text-danger"></i> Devolução: <?= $dev_total ?>
                     </span>
                  </div>
               </div>
            </div>

         </div>


      </div>

</section>