<section class="section section-intro context-dark" style="background:url('../public/assets/images/ticket.jpg') no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <h1 class="font-weight-bold wow fadeInLeft">BILHETEIRA ONLINE </h1>
            </div>
        </div>
    </div>
</section>

<section class="section section-md bg-xs-overlay" style="background:url('images/bg-image-3-1700x883.jpg')no-repeat;background-size:cover">
    <div class="container">
        <div class="row row-50 justify-content-center">
            <div class="col-12 text-center col-md-10 col-lg-8">
                <h3 class="wow fadeInLeft text-capitalize" data-wow-delay=".3s">Dê uma olhada ao<span class="text-primary">Preçário</span></h3>
                <p>Bebé Grátis*, Aniversariaante Ganha 50% de desconto</p>
            </div>
        </div>
        <div class="row row-30 justify-content-center">
            <!-- ciclo de apresentação dos produtos -->
            <?php foreach ($produtos as $produto) : ?>
                <div class="col-sm-4 col-6 p-2">

                    <div class="text-center p-3 box-produto ">
                        <img src="../public/assets/images/bilhetes/<?= $produto->imagem ?>" class="img-fluid">
                        <div>
                        <hr>
                            <?php if($produto->stock > 0):?>
                                <button class="btn btn-info btn-sm" onclick="adicionar_carrinho(<?= $produto->n_bilhete ?>)"><i class="fas fa-shopping-cart me-2"></i> Adicionar ao carrinho</button>
                            <?php else:?>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-shopping-cart me-2"></i> Indisponivel </button>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>




<!-- 

[id_produto] => 1
[categoria] => homem
[nome_produto] => Tshirt Vermelha
[descricao] => Ab laborum, commodi aspernatur, quas distinctio cum quae omnis autem ea, odit sint quisquam similique! Labore aliquam amet veniam ad fugiat optio.
[imagem] => tshirt_vermelha.png
[preco] => 45.70
[stock] => 100
[visivel] => 1
[created_at] => 2021-02-06 19:45:18
[updated_at] => 2021-02-06 19:45:25
[deleted_at] => 

 -->
