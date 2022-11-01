<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="color: #000; background-color: #fff; width: 100%; font-family: 'Arial' sans-serif !important;">
        <tr>
            <td align="center">
                <div style="width: 600px;">
                    <table border="0" cellspacing="0" cellpadding="0" class="container" style="background-color: #d25a65; font-size: 20px; color: #fff; padding: 30px; width: 100%;">
                        <tr>
                            <td align="center"><strong>amora</strong></td>
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
                                Uma nova senha foi solicitada na plataforma:<br>
                                <strong><?php echo $dados['senha']; ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0px 30px 30px 30px">
                                Acesse a plataforma e atualize sua senha.
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <div style="width: 600px;">
                    <table border="0" cellspacing="0" cellpadding="0" class="container" style="background-color: #d25a65; color: #fff; padding: 30px; width: 100%;">
                        <tr>
                            <td align="center">Amora - 2017 - <?php echo date('Y'); ?> - todos direitos reservados</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>