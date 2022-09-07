<!-- Footer -->
<footer class="section footer-classic section-sm">
    <div class="container">
        <div class="row row-30">
            <div class="col-lg-3 wow fadeInLeft">
                <!--Brand-->
                <a class="brand" href="index.php"><img class="brand-logo-dark" src="../public/assets/images/logo-inverse-200x34.png" alt="" width="100" height="17" /><img class="brand-logo-light" src="../public/assets/images/logo-inverse-200x34.png" alt="" width="100" height="17" /></a>
                <p class="footer-classic-description offset-top-0 offset-right-25"></p>
            </div>
            <div class="col-lg-3 col-sm-8 wow fadeInUp">
                <P class="footer-classic-title">inf Contacto</P>
                <div class="d-block offset-top-0">Angola C.Sul <span class="d-lg-block">Sumbe Rua do 1º de Maio</span></div><a class="d-inline-block accent-link" href="mailto:andersonpedro004@gmail.com">andersonpedro004@gmail.com</a><a class="d-inline-block" href="tel:#">+244 924 304 127</a>
                <ul>
                    <li>Seg-Sex:<span class="d-inline-block offset-left-10 text-white">09:30 - 20:00</span></li>
                    <li>Sab:<span class="d-inline-block offset-left-10 text-white">10:00 - 15:00 </span></li>
                </ul>
            </div>
            <div class="col-lg-2 col-sm-4 wow fadeInUp" data-wow-delay=".3s">
                <P class="footer-classic-title">Links Rápidos</P>
                <ul class="footer-classic-nav-list">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="about.html">Sobre Nós</a></li>
                    <li><a href="#">Serviços</a></li>
                    <li><a href="#">Pagina da Loja</a></li>
                    <li><a href="contacts.html">Contactos</a></li>
                </ul>
            </div>
            <div class="col-lg-4 wow fadeInLeft" data-wow-delay=".2s">
                <P class="footer-classic-title">Novidades</P>
                <form data-form-output="form-output-global" data-form-type="contact" method="post" action="?a=Enviar_email_newlester">
                    <!-- Mensagem de Envio Correto -->
                    <?php if (isset($_SESSION['Sucesso'])) : ?>
                        <div class="alert alert-success text-end p-2 ">
                            <?= $_SESSION['Sucesso'] ?>
                            <?php unset($_SESSION['Sucesso']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Mensagem de Falha no envio -->
                    <?php if (isset($_SESSION['erro'])) : ?>
                        <div class="alert alert-danger text-center p-2 ">
                            <?= $_SESSION['erro'] ?>
                            <?php unset($_SESSION['erro']) ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-wrap">
                        <label class="form-label" for="subscribe-email">Insira o seu Email</label>
                        <input class="form-input" id="subscribe-email" type="email" name="email"   required >
                    </div>
                    <div class="form-button group-sm text-center text-lg-left">
                        <button class="button button-primary button-circle" type="submit">Enviar</button>
                    </div>
                </form>
                <p>Seja o primeiro a saber sobre as nossas novidades.</p>
            </div>
        </div>
    </div>
    <div class="container wow fadeInUp" data-wow-delay=".4s">
        <div class="footer-classic-aside">
            <p class="rights"><span>&copy;&nbsp;</span><span class="copyright-year"></span>. All Rights Reserved. Design by <a href="https://APdesigner.com">Anderson Pedro</a></p>
            <ul class="social-links">
                <li>
                    <a class="fa fa-linkedin" href="#"></a>
                </li>
                <li>
                    <a class="fa fa fa-twitter" href="#"></a>
                </li>
                <li>
                    <a class="fa fa-facebook" href="#"></a>
                </li>
                <li>
                    <a class="fa fa-instagram" href="#"></a>
                </li>
            </ul>
        </div>
    </div>
</footer>
</div>
<div class="snackbars" id="form-output-global"></div>
<script src="../public/assets/js/core.min.js"></script>
<script src="../public/assets/js/axios.min.js"></script>
<script src="../public/assets/js/script.js"></script>
</body>

</html>