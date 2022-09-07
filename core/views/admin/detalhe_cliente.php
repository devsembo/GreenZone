<?php
use core\classes\Store;
?>


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
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>

        <div class="col-md-10">
            <h3>Detalhe do cliente</h3>
            <hr>

            <div class="row mt-3">
                <!-- nome completo -->
                <div class="col-3 text-end fw-bold">Nome completo:</div>
                <div class="col-9"><?= $dados_cliente->nome_completo ?></div>
                <!-- telefone -->
                <div class="col-3 text-end fw-bold">Telefone:</div>
                <div class="col-9"><?= empty($dados_cliente->telefone) ? '-' : $dados_cliente->telefone ?></div>
                <!-- email -->
                <div class="col-3 text-end fw-bold">Email:</div>
                <div class="col-9"><a href="mailto:<?= $dados_cliente->email ?>"><?= $dados_cliente->email ?></a></div>
                <!-- ativo -->
                <div class="col-3 text-end fw-bold">Estado:</div>
                <div class="col-9"><?= $dados_cliente->ativo == 0 ? '<span class="text-danger">Inativo</span>' : '<span class="text-success">Ativo</span>' ?></div>
                <!-- criado em -->
                <div class="col-3 text-end fw-bold">Cliente desde:</div>
                <?php
                $data = DateTime::createFromFormat('Y-m-d H:i:s', $dados_cliente->created_at);
                ?>
                <div class="col-9"><?= $data->format('d-m-Y') ?></div>
            </div>

            <div class="row mt-3">
                <div class="col-9 offset-3">
                    <?php if ($total_encomendas == 0) : ?>
                        <div class="col text-center">
                            <p class="text-muted">Não existem encomendas deste cliente.</p>
                        </div>
                    <?php else : ?>
                        <a href="?a=cliente_historico_encomendas&c=<?= Store::aesEncriptar($dados_cliente->id_cliente) ?>" class="btn btn-primary">Ver histórico de encomendas...</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>



    </div>
</div>