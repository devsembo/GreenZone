<section class="section section-intro context-dark" style="background:url('../assets/images/perfil.png') no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <h1 class="font-weight-bold wow fadeInLeft"> ADMIN </h1>
            </div>
        </div>
    </div>
</section>


<div class="container-fluid">
    <div class="row mt-3 mb-5">
        
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php')?>
        </div>

        <div class="col-md-10">

            <div class="row">
                <div class="col">
                    <h4>DETALHE ENCOMENDA</h4><small><?= $encomenda->codigo_encomenda ?></small>
                </div>
                <div class="col text-end">
                    <div class="text-center p-3 badge bg-primary status-clicavel" onclick="apresentarModal()"><?= $encomenda->status?></div>
                    <?php if($encomenda->status == 'EM PROCESSAMENTO'):?>                       
                    <div>
                        <a href="?a=criar_pdf_encomenda&e=<?= core\classes\Store::aesEncriptar($encomenda->id_encomenda)?>" class="btn btn-primary btn-sm">PDF</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>
            
            <div class="row">

                <div class="col">
                    <p>Nome cliente:<br><strong><?= $encomenda->nome_completo ?></strong></p>
                    <p>Email:<br><strong><?= $encomenda->email ?></strong></p>
                    <p>Telefone:<br><strong><?= $encomenda->telefone ?></strong></p>
                </div>

                <div class="col">
                    <p>Data encomenda:<br><strong><?= $encomenda->data_encomenda ?></strong></p>
                </div>
            </div>

            <hr>
            <table class="table">
                <thead>
                    <th>Produto</th>
                    <th class="text-end">Preço/unid</th>
                    <th class="text-center">Quantidade</th>
                </thead>
                <tbody>
                    <?php foreach($lista_produtos as $produto):?>
                        <tr>
                            <td><?= $produto->designacao_produto ?></td>
                            <td class="text-end"><?=  preg_replace("/\./", ",", $produto->preco_unidade) . '€' ?></td>
                            <td class="text-center"><?= $produto->quantidade ?></td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

        </div>

    </div>
</div>



<!-- modal -->
<div class="modal fade" id="modalStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alterar estado da encomenda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        
        <div class="text-center">
            <?php foreach(STATUS as $estado): ?>

                <?php if($encomenda->status == $estado):?>
                    <p><?= $estado ?></p>
                <?php else:?>
                    <p><a href="?a=encomenda_alterar_estado&e=<?= core\classes\Store::aesEncriptar($encomenda->id_encomenda) ?>&s=<?= $estado ?>"><?= $estado ?></a></p>
                <?php endif;?>

            

            <?php endforeach; ?>
        </div>
    
	
	
	
	


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

<script>
    function apresentarModal(){
        var modalStatus = new bootstrap.Modal(document.getElementById('modalStatus'));
        modalStatus.show();
    }
</script>