<?php 
    use core\classes\Store;
?>

<section class="section section-intro context-dark" style="background:url('../public/assets/images/perfil.png') no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <h1 class="font-weight-bold wow fadeInLeft">A Minha Conta </h1>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">
    <div class="row">
        <div class="col-8 md-5-sm-5">

            <h3 class="text-center">Histórico de encomendas</h3>

            <?php if (count($historico_encomendas) == 0) : ?>
                <p class="text-center">Não existem encomendas registadas.</p>
            <?php else : ?>

                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Data da Encomenda</th>
                            <th>Código encomenda</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($historico_encomendas as $encomenda) : ?>
                            <tr>
                                <td><?= $encomenda->data_encomenda ?></td>
                                <td><?= $encomenda->codigo_encomenda ?></td>
                                <td><?= $encomenda->status ?></td>
                                <td>
                                    <a href="?a=detalhe_encomenda&id=<?= Store::aesEncriptar($encomenda->id_encomenda) ?>">Detalhes</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p class="text-end">Total encomendas: <strong><?= count($historico_encomendas) ?></strong></p>

            <?php endif; ?>
        </div>
    </div>
</div>