    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->

    <section class="section section-intro context-dark" style="background:url('../assets/images/perfil.png') no-repeat center center; background-size:cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 text-center">
                    <h1 class="font-weight-bold wow fadeInLeft"> ADMIN LOGIN </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row my-5">
            <div class="col-sm-4 offset-sm-4">

                <div>

                    <form action="?a=admin_login_submit" method="post">

                        <?php if (isset($_SESSION['erro'])) : ?>
                            <div class="alert alert-danger text-center">
                                <?= $_SESSION['erro'] ?>
                                <?php unset($_SESSION['erro']); ?>
                            </div>
                        <?php endif; ?>

                        <img class="mb-4 text-center" src="../assets/images/logo-default-200x34.png" alt="" width="72" height="57">
                        <div class="form-floating my-4">
                            <input type="email" class="form-control" name="text_admin" id="floatingInput" placeholder="Usuario Admin">
                        </div>
                        <div class="form-floating my-4">
                            <input type="password" class="form-control" name="text_senha" id="floatingPassword" placeholder="Senha">
                        </div>

                        <button class="w-100 btn btn-lg btn-success" type="submit">Login</button>
                        <p class="mt-5 mb-3 text-muted">&copy; <?= APP_NAME ?> - 2021</p>

                    </form>
                </div>

            </div>
        </div>
    </div>







