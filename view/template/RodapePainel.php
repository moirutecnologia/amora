    <?php global $_versao; ?>

    <?php if (!$_usuario->assinante) { ?>
        <a href="#seja-assinante" data-fancybox class="seja-assinante">
            Seja assinante
        </a>
        
        <div id="seja-assinante" style="display: none;">
            <?php include '../view/painel/includes/seja-assinante.php'; ?>
        </div>
    <?php } // if $_usuario->assinante 
    ?>

    <footer class="footer">
        <div class="content has-text-centered">
            <small>versão <?php echo $_versao; ?></small>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/extensao/simpleUpload.min.js?<?php echo $_versao; ?>"></script>
    <script src="/js/extensao/jquery.mask.min.js?<?php echo $_versao; ?>"></script>
    <script src="/js/extensao/selectsearch.js?<?php echo $_versao; ?>"></script>
    <script src="/js/extensao/_funcao.js?<?php echo $_versao; ?>"></script>
    <script src="/js/_Site.js?<?php echo $_versao; ?>"></script>

    <?php

    $arquivo = arquivo_nome_real("../public/js/$pagina.js", false);

    if (!empty($arquivo)) : ?>
        <script src="/<?php echo str_replace('../public/', '', $arquivo) . "?" . $_versao; ?>"></script>
    <?php endif; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js?<?php echo $_versao; ?>" crossorigin="anonymous"></script>

    </body>

    </html>