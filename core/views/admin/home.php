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
    <div class="row mt-3">
        
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php')?>
        </div>

        <div class="col-md-10">
            
            <!-- apresenta informações sobre o total de encomendas PENDENTES -->
            <h4>Encomendas pendentes</h4>
            <?php if($total_encomendas_pendentes == 0): ?>
                <p class="text-a1a1a1">Não existem encomendas pendentes.</p>
            <?php else: ?>                
                <div class="alert alert-info p-2">
                    <span class="me-3">Existem encomendas pendentes: <strong><?= $total_encomendas_pendentes ?></strong></span>
                    <a href="?a=lista_encomendas&f=pendente">Ver</a>
                </div>
            <?php endif; ?>

            <hr>
            <!-- apresenta informações sobre o total de encomendas EM PROCESSAMENTO -->
            <h4>Encomendas em processamento</h4>
            <?php if($total_encomendas_em_processamento == 0): ?>
                <p class="text-a1a1a1">Não existem encomendas em processamento.</p>
            <?php else: ?>                
                <div class="alert alert-warning p-2">
                    <span class="me-3">Existem encomendas em processamento: <strong><?= $total_encomendas_em_processamento ?></strong></span>
                    <a href="?a=lista_encomendas&f=em_processamento">Ver</a>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>