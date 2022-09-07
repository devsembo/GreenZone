<section class="section section-intro context-dark" style="background:url('../public/assets/images/chitas.png') no-repeat center center; background-size:cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 text-center">
                <h1 class="font-weight-bold wow fadeInLeft">Bilhetes Confirmados </h1>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="row my-5">
        <div class="col text-center">
            <h3 class="text-center">Encomenda confirmada</h3>            
            <p>Muito obrigado pela sua encomenda.</p>

            <div class="my-5">
                <h4>Dados de Pagamento</h4>
                <p>Entidade: 6789</p>
                <p>Referência: 305314</p>
                <p>Código da encomenda: <strong><?= $codigo_encomenda ?></strong></p>
                <p>Total da encomenda: <strong><?= number_format($total_encomenda,2,',','.') . '€' ?></strong></p>
            </div>

            <p>
                Vai receber um email com a confirmação da encomenda e os dados de pagamento.
            <br>
                A sua encomenda só será processada após confirmação do pagamento.
            </p>
            <p><small>Por favor verifique se o email aparece na sua conta ou se foi para a pasta do SPAM.</small></p>
            <div class="my-5"><a href="?a=bilheteira" class="btn btn-success">Voltar</a></div>
        </div>
    </div>
</div>