<section class="section section-intro context-dark" style="background:url('../public/assets/images/cart.jpg') no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <h1 class="font-weight-bold wow fadeInLeft">Carrinho de compras </h1>
            </div>
        </div>
    </div>
</section>


<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="my-3">A sua encomenda - resumo</h3>
            <hr>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">

            <div style="margin-bottom: 80px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Bilhete</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-end">Valor total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 0;
                        $total_rows = count($carrinho);
                        ?>
                        <?php foreach ($carrinho as $produto) : ?>
                            <?php if ($index < $total_rows - 1) : ?>

                                <!-- lista dos produtos -->
                                <tr>
                                    <td class="align-middle"><?= $produto['titulo'] ?></td>
                                    <td class="text-center align-middle"><?= $produto['quantidade'] ?></td>
                                    <td class="text-end align-middle"><?= number_format($produto['preco'], 2, ',', '.') . '€' ?></td>
                                </tr>

                            <?php else : ?>

                                <!-- total -->
                                <tr>
                                    <td></td>
                                    <td class="text-end">
                                        <h4>Total:</h4>
                                    </td>
                                    <td class="text-end">
                                        <h4><?= number_format($produto, 2, ',', '.') . '€' ?></h4>
                                    </td>
                                </tr>

                            <?php endif; ?>
                            <?php $index++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>


                <!-- dados do cliente -->
                <h5 class="bg-success text-white p-2">Dados do Cliente</h5>
                <div class="row">
                    <div class="col">
                        <p>Nome: <strong><?= $cliente->nome_completo ?></strong></p>
                    </div>
                    <div class="col">
                        <p>Email: <strong><?= $cliente->email ?></strong></p>
                        <p>Telefone: <strong><?= $cliente->telefone ?></strong></p>
                    </div>
                </div>

                <!-- DADOS DE PAGAMENTO -->
                <h5 class="bg-success text-white p-2">Dados do Pagamento</h5>
                <div class="row">
                    <div class="col">
                        <p>Conta bancária: 1234567890</p>
                        <p>Código da encomenda: <strong><?= $_SESSION['codigo_encomenda'] ?></strong></p>
                        <p>Total: <strong><?= number_format($produto, 2, ',', '.') . '€' ?></strong></p>
                    </div>
                </div>

                <div class="row my-5">
                    <div class="col">
                        <a href="?a=carrinho" class="btn btn-success">Cancelar</a>
                    </div>

                    <div class="col text-end">
                        <a href="?a=confirmar_encomenda" onclick="morada_alternativa()" class="btn btn-success">Confirmar encomenda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>