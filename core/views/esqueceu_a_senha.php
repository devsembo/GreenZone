<section class="section section-intro context-dark" style="background:url('../public/assets/images/chitas.jpg') no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <h1 class="font-weight-bold wow fadeInLeft">Recuperar Senha </h1>
            </div>
        </div>
    </div>
</section>

<div class="conteiner">
    <div class="row my-4">
        <div class="col-sm-4 offset-sm-4 ">
            <form action="?a=login_submit" method="post">

                <?php if (isset($_SESSION['erro'])) : ?>
                    <div class="alert alert-danger text-center p-2 ">
                        <?= $_SESSION['erro'] ?>
                        <?php unset($_SESSION['erro']) ?>
                    </div>
                <?php endif; ?>

                <!-- Email -->
                <div class="my-3">
                    <label >Ususario</label>
                    <input type="email" name="text_usuario" placeholder="Usuario" class="form-control"  required>
                </div>

                <!-- Submit-->
                <div class="my-4 text-center">
                    <input type="submit" value="Recuperar Senha" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</div>