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
            <?php include(__DIR__ . '/layouts/admin_menu.php')?>
        </div>

        <div class="col-md-10">
            <h3>Lista de clientes</h3>
            <hr>

            <?php if(count($clientes) == 0): ?>
                <p class="text-center text-muted">Não existem cliente registados.</p>
            <?php else: ?>
                <!-- apresenta a tabela de clientes -->
                <table class="table table-sm" id="tabela-clientes">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th class="text-center">Encomendas</th>
                            <th class="text-center">Ativo</th>
                            <th class="text-center">Eliminado</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach($clientes as $cliente): ?>
                            <tr>
                                <td>
                                    <a href="?a=detalhe_cliente&c=<?= Store::aesEncriptar($cliente->id_cliente)?>"><?= $cliente->nome_completo ?></a>                                    
                                </td>

                                <td><?= $cliente->email ?></td>
                                <td><?= $cliente->telefone ?></td>

                                <td class="text-center">
                                    <?php if($cliente->total_encomendas == 0):?>
                                        -
                                    <?php else: ?>
                                       <a href="?a=lista_encomendas&c=<?= Store::aesEncriptar($cliente->id_cliente)?>"><?= $cliente->total_encomendas ?></a>
                                    <?php endif; ?>
                                </td>

                                <!-- ativo -->
                                <td class="text-center">
                                <?php if($cliente->ativo == 1):?>
                                    <i class="text-success fas fa-check-circle"></i></span>
                                <?php else:?>
                                    <i class="text-danger fas fa-times-circle"></i></span>
                                <?php endif; ?>
                                </td>

                                <!-- eliminado -->
                                <td class="text-center">
                                <?php if($cliente->deleted_at == null):?>
                                    <i class="text-danger fas fa-times-circle"></i></span>
                                <?php else:?>
                                    <i class="text-success fas fa-check-circle"></i></span>
                                <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;?>

                    </tbody>
                </table>
            <?php endif; ?>

        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tabela-clientes').DataTable({
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
</script>