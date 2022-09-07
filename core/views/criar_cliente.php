<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

<section class="section section-intro context-dark" style="background:url('../public/assets/images/ave.jpg') no-repeat center center; background-size:cover;">
    <div class="conteiner">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <div class="col-12">
                    <h1 class="font-weight-bold wow fadeInLeft">Formulário de Registo </h1>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="conteiner">
    <div class="row my-4">
        <div class="col-sm-4 offset-sm-4 ">
            <form action="?a=criar_cliente" method="post">

            <?php if(isset($_SESSION['erro'])):?>
                    <div class="alert alert-danger text-center p-2 ">
                        <?= $_SESSION['erro'] ?>
                        <?php unset($_SESSION['erro']) ?>
                    </div>
                <?php endif; ?>

                <!-- Email -->
                <div class="my-3">
                    <label for="Email">Email</label>
                    <input type="email" name="text_email" placeholder="Email" class="form-control" id="text_email" required>
                </div>

                <!-- Senha 1 -->
                <div class="my-3">
                    <label for="Senha">Senha</label>
                    <input type="password" name="text_senha_1" placeholder="Senha" class="form-control" required>
                </div>

                <!-- Senha 2 -->
                <div class="my-3">
                    <label for="Senha">Confirmar a senha</label>
                    <input type="password" name="text_senha_2" placeholder="Confirmar a senha" class="form-control" required>
                </div>

                <!-- Nome -->
                <div class="my-3">
                    <label for="Nome">Nome Completo</label>
                    <input type="text" name="text_nome_completo" placeholder="Primeiro e ultimo nome" class="form-control" required>
                </div>

                <!-- Telefone-->
                <div class="my-3">
                    <label for="telefone">Telefone</label>
                    <input type="text" name="text_telefone" placeholder="Telefone" class="form-control">
                </div>

                <!-- Submit-->
                <div class="my-4 text-center">
                    <input type="submit" value="Criar Conta" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 
Email *
senha_1 *
senha_2 *
nome_completo *
telefone
-->