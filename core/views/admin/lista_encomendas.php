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

            <h3>Lista de encomendas <?= $filtro != '' ? $filtro : '' ?></h3>
            <hr>

            <div class="row">
                <div class="col">
                    <a href="?a=lista_encomendas" class="btn btn-primary btn-sm">Ver todas as encomendas</a>
                </div>
                <div class="col">
                    <?php
                    $f = '';
                    if (isset($_GET['f'])) {
                        $f = $_GET['f'];
                    }
                    ?>

                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-4 text-end col-form-label">Escolher estado:</label>
                        <div class="col-sm-8">
                            <select id="combo-status" class="form-control" onchange="definir_filtro()">
                                <option value="" <?= $f == '' ? 'selected' : '' ?>></option>
                                <option value="pendente" <?= $f == 'pendente' ? 'selected' : '' ?>>Pendentes</option>
                                <option value="em_processamento" <?= $f == 'em_processamento' ? 'selected' : '' ?>>Em processamento</option>
                                <option value="usada" <?= $f == 'usada' ? 'selected' : '' ?>>Usadas</option>
                                <option value="cancelada" <?= $f == 'cancelada' ? 'selected' : '' ?>>Canceladas</option>
                                <option value="concluida" <?= $f == 'concluida' ? 'selected' : '' ?>>Concluídas</option>
                            </select>
                        </div>
                    </div>
            </div>
        </div>

        <?php if (count($lista_encomendas) == 0) : ?>
            <hr>
            <p>Não existem encomendas registadas.</p>
            <hr>
        <?php else : ?>
            <small>
                <table class="table table-striped" id="tabela-encomendas">
                    <thead class="table-dark">
                        <tr>
                            <th>Data</th>
                            <th>Código</th>
                            <th>Nome Cliente</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Status</th>
                            <th>Atualizado em</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($lista_encomendas as $encomenda) : ?>
                            <tr>
                                <td><?= $encomenda->data_encomenda ?></td>
                                <td><?= $encomenda->codigo_encomenda ?></td>
                                <td><?= $encomenda->nome_completo ?></td>
                                <td><?= $encomenda->email ?></td>
                                <td><?= $encomenda->telefone ?></td>
                                <td>
                                    <a href="?a=detalhe_encomenda&e=<?= Store::aesEncriptar($encomenda->id_encomenda) ?>"><?= $encomenda->status ?></a>
                                </td>
                                <td><?= $encomenda->updated_at ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <small>
                <?php endif; ?>

    </div>

</div>
</div>

<script>
    $(document).ready(function() {
        $('#tabela-encomendas').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No data available in table",
                "info": "Mostrando página _PAGE_ de um total de _PAGES_",
                "infoEmpty": "Não existem encomendas disponíveis",
                "infoFiltered": "(Filtrado de um total de _MAX_ encomendas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Apresenta _MENU_ encomendas por página",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "search": "Procurar:",
                "zeroRecords": "Não foram encontradas encomendas",
                "paginate": {
                    "first": "Primeira",
                    "last": "Última",
                    "next": "Seguinte",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": ativar para ordenar a coluna de forma ascendente",
                    "sortDescending": ": ativar para ordenar a coluna de forma descendente"
                }
            }
        });
    });

    function definir_filtro() {
        var filtro = document.getElementById("combo-status").value;
        // reload da página com determinado filtro
        window.location.href = window.location.pathname + "?" + $.param({
            'a': 'lista_encomendas',
            'f': filtro
        });
    }
</script>