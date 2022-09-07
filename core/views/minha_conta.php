<section class="section section-intro context-dark" style="background:url('../public/assets/images/perfil.png') no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <h1 class="font-weight-bold wow fadeInLeft">A Minha Conta </h1>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row my-5">
        <div class="col">

            <table class="table table-striped">

                <?php foreach($dados_cliente as $key=>$value): ?>
                    <tr>
                        <td class="text-end" width="40%"><?= $key ?>:</td>
                        <td width="60%"><strong><?= $value ?></strong></td>
                    </tr>
                <?php endforeach; ?>

            </table>

        </div>
    </div>
</div>