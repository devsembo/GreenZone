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
        <h3 class="my-3">Os seus bilhetes </h3>
        <hr>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">







            <?php if ($carrinho == null) : ?>
                
                <p class="text-center">Não existem produtos no carrinho.</p>
                <div class="mt-4 text-center">
                    <a href="?a=bilheteira" class="btn btn-success">Ir para a BILHETEIRA</a>
                </div>
            <hr>
            <?php else : ?>

                <div style="margin-bottom: 80px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Produto</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-end">Valor total</th>
                                <th></th>
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
                                        <td><img src="assets/images/bilhetes/<?= $produto['imagem']; ?>" class="img-fluid" width="50px"></td>
                                        <td class="align-middle"><h5><?= $produto['titulo'] ?></h5></td>
                                        <td class="text-center align-middle"><h5><?= $produto['quantidade'] ?></h5></td>
                                        <td class="text-end align-middle"><h4><?= str_replace('.', ',', $produto['preco']) . '€' ?></h4></td>
                                        <td class="text-center align-middle"><button class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button></td>
                                    </tr>

                                <?php else : ?>

                                    <!-- total -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-end"><h3>Total:</h3></td>
                                        <td class="text-end"><h3><?= str_replace('.', ',', $produto) . '€' ?></h3></td>
                                        <td></td>
                                    </tr>

                                <?php endif; ?>
                                <?php $index++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col">
                            <a href="?a=limpar_carrinho" class="btn btn-sm btn-success">Limpar carrinho</a>
                        </div>

                        <div class="col text-end">
                            <a href="?a=bilheteira" class="btn btn-sm btn-success">Continuar a comprar</a>
                            <a href="?a=finalizar_encomenda" class="btn btn-sm btn-success">Finalizar encomenda</a>
                        </div>
                    </div>
                </div>

            <?php endif; ?>










        </div>
    </div>
</div>