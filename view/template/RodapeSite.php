    <?php global $_versao; ?>

    <a href="https://wa.me/5551996777932?text=Olá! Como funciona a Amora?" target="_blank" class="fale-conosco">
        Fale conosco
    </a>

    <footer class="footer site">
        <div class="content has-text-centered">
            Amora - 2017 - <?php echo date('Y'); ?> - todos direitos reservados - versão <?php echo $_versao; ?>
        </div>
    </footer>

    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script async src="/js/extensao/jquery.mask.min.js?<?php echo $_versao; ?>"></script>
    <script async src="/js/extensao/selectsearch.js?<?php echo $_versao; ?>"></script>
    <script async src="/js/extensao/_funcao.js?<?php echo $_versao; ?>"></script>

    <?php

    $arquivo = arquivo_nome_real("../public/js/$pagina.js", false);

    if (!empty($arquivo)) : ?>
        <script src="/<?php echo str_replace('../public/', '', $arquivo) . "?" . $_versao; ?>"></script>
    <?php endif; ?>

    <script async src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js?<?php echo $_versao; ?>" crossorigin="anonymous"></script>

    </body>

    </html>