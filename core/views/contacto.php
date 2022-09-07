<section class="section section-intro context-dark">
    <div class="intro-bg" style="background: url(images/intro-bg-1.jpg) no-repeat;background-size:cover;background-position: top center;"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <h1 class="font-weight-bold wow fadeInLeft">Informação e Contacto </h1>
                <p class="intro-description wow fadeInRight">Mande-nos os seus dados com uma mensagem, entraremos em contacto logo que possivel.</p>
            </div>
        </div>
    </div>
</section>

<!--Mail-Info-->

<section class="section section-md">
    <div class="container">
        <!--Formulário de contacto-->
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-8 col-12">
                <form method="post" action="?a=Enviar_email_contacto">
            
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
                        <label class="form-label" for="contact-name">Nome<span class="req-symbol"></span></label>
                        <input class="form-input" id="contact-name" type="text" name="name" data-constraints="@Required">
                    </div>
                    <div class="form-wrap">
                        <label class="form-label" for="contact-phone">Telefone<span class="req-symbol"></span></label>
                        <input class="form-input" id="contact-phone" type="text" name="phone" data-constraints="@Required @PhoneNumber">
                    </div>
                    <div class="form-wrap">
                        <label class="form-label" for="contact-email">E-Mail<span class="req-symbol"></span></label>
                        <input class="form-input" id="contact-email" type="email" name="email" data-constraints="@Required @Email">
                    </div>
                    <div class="form-wrap">
                        <label class="form-label label-textarea" for="contact-message">Deixe sua mensagem<span class="req-symbol"></span></label>
                        <textarea class="form-input" id="contact-message" name="message" required data-constraints="@Required"></textarea>
                    </div>
                    <div class="form-button group-sm text-center text-lg-left">
                        <button class="button button-primary" type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>