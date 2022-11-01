<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="color: #000; background-color: #fff; width: 100%; font-family: 'Arial' sans-serif !important;">
        <tr>
            <td align="center">
                <div style="width: 600px;">
                    <table border="0" cellspacing="0" cellpadding="0" class="container" style="background-color: #8460bd; font-size: 20px; color: #fff; padding: 30px; width: 100%;">
                        <tr>
                            <td align="center"><strong>trocas cool</strong></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <div style="width: 600px;">
                    <table border="0" cellspacing="0" cellpadding="0" style="background-color: #fafafa; padding: 30px; width: 100%;">
                        <tr>
                            <td style="padding: 30px;">
                                <strong>Olá, <?php echo $dados['nome']; ?>!</strong><br /><br />
                                Você recebe uma pergunta sobre <?php echo $dados['item']; ?>.<br /><br />
                                Pergunta:<br />
                                <?php echo nl2br($dados['pergunta']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0px 30px 30px 30px">
                                Acesse seu anúncio para responder <a href="https://trocas.cool/anuncios/<?php echo $dados['item_id']; ?>">clicando aqui</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <div style="width: 600px;">
                    <table border="0" cellspacing="0" cellpadding="0" class="container" style="background-color: #4dc989; color: #fff; padding: 30px; width: 100%;">
                        <tr>
                            <td align="center">trocas cool - 2021 - <?php echo date('Y'); ?> - todos direitos reservados</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>