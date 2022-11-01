<?php

/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 22/03/2018
 * Time: 08:05
 */

session_start();

setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$_token;
$_usuario;
$_cliente;
$_seo;
$_url_site;

$_nome_mes = array(
    '1' => 'Janeiro',
    '2' => 'Fevereiro',
    '3' => 'Março',
    '4' => 'Abril',
    '5' => 'Maio',
    '6' => 'Junho',
    '7' => 'Julho',
    '8' => 'Agosto',
    '9' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
);

function data($data, $tipo = 'completa')
{
    global $_nome_mes;
    $data = strtotime($data);

    if ($tipo == 'completa') {
        return date('d', $data) . ' de ' . $_nome_mes[date('m', $data) - 0] . ' de ' . date('Y', $data);
    }else if ($tipo == 'completa-hora') {
        return date('d', $data) . ' de ' . $_nome_mes[date('m', $data) - 0] . ' de ' . date('Y', $data) . ' ' . date('H:i', $data);
    } else if ($tipo == 'mes-Y') {
        return $_nome_mes[date('m', $data) - 0] . ' ' . date('Y', $data);
    } else if ($tipo == 'Y') {
        return date('Y', $data);
    } else if ($tipo == 'data-en') {
        return date('Y-m-d', $data);
    } else if ($tipo == 'br') {
        return date('d/m/Y H:i:s', $data);
    } else if ($tipo == 'br-data') {
        return date('d/m/Y', $data);
    } else if ($tipo == 'br-data-hi' || $tipo == 'datahora1') {
        return date('d/m/Y H:i', $data);
    } else if ($tipo == 'br-dmy-hi') {
        return date('d/m/y H:i', $data);
    }
}

function svg_painel($svg)
{
    echo file_get_contents('https://modelosistema.bravo.st/image/painel/svg/' . $svg);
}

function arquivo_nome_real($caminho, $somente_nome = false, $extensao = true)
{
    $caminho = strtolower($caminho);
    $arquivos = glob(dirname($caminho) . '/*');

    $retorno = "";

    foreach ($arquivos as $arquivo) {
        if (strtolower($arquivo) == $caminho) {
            $caminho_info = pathinfo($arquivo);
            if ($somente_nome) {
                if ($extensao) {
                    $retorno = $caminho_info["basename"];
                } else {
                    $retorno = $caminho_info["filename"];
                }
            } else {
                $retorno = $arquivo;
            }
        }
    }

    if (empty($retorno)) {
        foreach ($arquivos as $arquivo) {
            if (strtolower($arquivo) == "../view/404.php") {
                $caminho_info = pathinfo($arquivo);
                if ($somente_nome) {
                    if ($extensao) {
                        $retorno = $caminho_info["basename"];
                    } else {
                        $retorno = $caminho_info["filename"];
                    }
                } else {
                    $retorno = $arquivo;
                }
            }
        }
    }

    return $retorno;
}

function is_mobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function mask($val, $mask)
{
    if ($mask == '$') {
        return number_format($val, 2, ',', '.');
    }

    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function resumo_texto($texto)
{
    $texto = explode(" ", strip_tags($texto));
    $texto = count($texto) > 15 ? implode(" ", array_slice($texto, 0, 15)) . " [...]" : implode(" ", $texto);

    return $texto;
}

function texto_identificador($string)
{
    $string = preg_replace('~[^\\pL0-9_]+~u', '-', $string);
    $string = trim($string, "-");
    $string = iconv("utf-8", "us-ascii//TRANSLIT", $string);
    $string = strtolower($string);
    $string = preg_replace('~[^-a-z0-9_]+~', '', $string);
    return $string;
}

function pagina_restrita($pagina)
{
    global $_paginas;

    if (strpos($pagina, "/") !== false) {
        $pagina = explode("/", $pagina)[1];
    }

    $indice = array_search(strtolower($pagina), array_column($_paginas, "pagina"));

    if ($indice !== false) {
        return $_paginas[$indice]["restrita"] ?? false;
    } else {
        return false;
    }
}

function valida_acesso_pagina_restrita($pagina, $retorno = '')
{
    global $_paginas;
    global $_usuario;
    global $_rota_acesso;

    $indice = array_search(strtolower($pagina), array_column($_paginas, "pagina"));

    $possui_acesso = true;

    if ($indice !== false) {
        $restrita = $_paginas[$indice]["restrita"] ?? false;
        $possui_acesso = !$restrita || ((!isset($_paginas[$indice]["perfis"]) && !empty($_usuario)) || in_array($_usuario->perfil_slug, $_paginas[$indice]["perfis"]));
    }

    if (!$possui_acesso) {
        if (empty($_usuario)) {
            $pagina = str_replace('index', '', $pagina);
            header('location: ' . $_rota_acesso . '?retorno=' . $retorno ?? '/' . $pagina);
        } else {
            header('location: /');
        }
        exit;
    }
}

function metodo_restrito($metodo)
{
    global $_metodos;

    $metodo = explode("/", $metodo);

    if (count($metodo) < 3) {
        return false;
    }

    $controlador = $metodo[count($metodo) - 2];
    $metodo = end($metodo);

    $indice = false;

    $contador = 0;
    foreach ($_metodos as $_metodo) {
        if (strtolower($_metodo["controlador"]) == strtolower($controlador) && strtolower($_metodo["metodo"]) == strtolower($metodo)) {
            $indice = $contador;
            break;
        }
        $contador++;
    }

    if ($indice !== false) {
        return true;
    } else {
        return false;
    }
}

function valida_acesso_metodo_restrito($metodo)
{
    global $_metodos;
    global $_usuario;

    $metodo = explode("/", $metodo);

    if (count($metodo) < 3) {
        return true;
    }

    $controlador = $metodo[count($metodo) - 2];
    $metodo = end($metodo);

    $indice = false;

    $contador = 0;
    foreach ($_metodos as $_metodo) {
        if (strtolower($_metodo["controlador"]) == strtolower($controlador) && strtolower($_metodo["metodo"]) == strtolower($metodo)) {
            $indice = $contador;
            break;
        }
        $contador++;
    }

    if ($indice !== false) {
        return false || (!isset($_metodos[$indice]["perfis"]) || in_array($_usuario->perfil_slug, $_metodos[$indice]["perfis"]));
    } else {
        return true;
    }
}

function formataCnpjCpf($value)
{
    $cnpj_cpf = preg_replace("/\D/", '', $value);

    if (strlen($cnpj_cpf) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    }

    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function formataIe($value)
{
    return preg_replace('/(\d{3})(\d{3})/', "\$1/\$2", $value);
}

function validaCnpj($cnpj)
{

    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
    // Valida tamanho
    if (strlen($cnpj) != 14)
        return false;
    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $cnpj{
            $i} * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    if ($cnpj{
        12} != ($resto < 2 ? 0 : 11 - $resto))
        return false;
    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $cnpj{
            $i} * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    return $cnpj{
        13} == ($resto < 2 ? 0 : 11 - $resto);
}

function envia_email($email, $nome, $assunto, $modelo, $dados, $email_de = '', $email_de_nome = '')
{
    global $_email_de;
    global $_email_de_nome;
    global $_email_para;

    if (!empty($_email_para)) {
        $email = $_email_para;
    }

    $mail = new PHPMailer(true);
    try {

        $mensagem = file_get_contents("../view/email/$modelo.php");

        foreach ($dados as $key => $value) {
            if (!is_array($value)) {
                $mensagem = str_replace("{{" . $key . "}}", $value, $mensagem);
            } else {
                $conteudo = '';
                $modelo = file_get_contents("../view/email/{$modelo}_{$key}.php");

                foreach ($value as $item) {
                    $linha = $modelo;
                    foreach ($item as $chave => $valor) {
                        $linha = str_replace("{{" . $chave . "}}", $valor, $linha);
                    }

                    $conteudo .= $linha;
                }

                $mensagem = str_replace("{{" . $key . "}}", $conteudo, $mensagem);
            }
        }

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = "smtp.mailgun.org";
        $mail->SMTPAuth = true;
        $mail->Username = "postmaster@mg.amora.cusco.dev";
        $mail->Password = "2185b6e73e6e31f6bbbf397c40652baf-b6d086a8-7d3911f1";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        //        if(empty($email_de)){
        //            $email_de = $_email_de;
        //        }
        //
        //        if(empty($email_de_nome)){
        //            $email_de_nome = $_email_de_nome;
        //        }

        $mail->setFrom($_email_de, $_email_de_nome);

        if (!empty($email_de)) {
            $mail->AddReplyTo($email_de, $email_de_nome ?? $_email_de_nome);
        }

        if (!is_array($email)) {
            $email = array($email);
        }

        foreach ($email as $item) {
            $mail->addAddress(trim($item), $nome);
        }

        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return 1;
    } catch (Exception $e) {
        var_dump($e);
    }
}

function enviaremail($email, $nome, $assunto, $modelo, $dados, $email_de = '', $email_de_nome = '')
{
    global $_email_de;
    global $_email_de_nome;
    global $_email_para;

    if (!empty($_email_para)) {
        $email = $_email_para;
    }

    $mail = new PHPMailer(true);
    try {

        ob_start();
        include "../view/email/$modelo.php";
        $mensagem = ob_get_contents();
        ob_end_clean();

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = "smtp.mailgun.org";
        $mail->SMTPAuth = true;
        $mail->Username = "postmaster@mg.amora.cusco.dev";
        $mail->Password = "2185b6e73e6e31f6bbbf397c40652baf-b6d086a8-7d3911f1";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom($_email_de, $_email_de_nome);

        if (!empty($email_de)) {
            $mail->AddReplyTo($email_de, $email_de_nome ?? $_email_de_nome);
        }

        if (!is_array($email)) {
            $email = array($email);
        }

        foreach ($email as $item) {
            $mail->addAddress(trim($item), $nome);
        }

        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;
 
        $mail->send();
        return 1;
    } catch (Exception $e) {
        var_dump($e);
    }
}

function str_apenas_int($valor)
{
    return preg_replace("/\D/", "", $valor);
}

function real_para_decimal($valor)
{
    return str_replace(",", ".", str_replace(".", "", $valor));
}

function br_para_datetime($data)
{
    return date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data)));
}

function datetime_para_br($data)
{
    return date('d/m/Y H:i:s', strtotime($data));
}

function curl_post($url, $dados)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($dados),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

function get_remote_data($url, $post_paramtrs = false, $extra = array('schemeless' => true, 'replace_src' => true, 'return_array' => false))
{
    // start curl
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    //if parameters were passed to this function, then transform into POST method.. (if you need GET request, then simply change the passed URL)
    if ($post_paramtrs) {
        curl_setopt($c, CURLOPT_POST, TRUE);
        curl_setopt($c, CURLOPT_POSTFIELDS, (is_array($post_paramtrs) ? http_build_query($post_paramtrs) : $post_paramtrs));
    }
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:76.0) Gecko/20100101 Firefox/76.0";
    $headers[] = "Pragma: ";
    $headers[] = "Cache-Control: max-age=0";
    if (!empty($post_paramtrs) && !is_array($post_paramtrs) && is_object(json_decode($post_paramtrs))) {
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Content-Length: ' . strlen($post_paramtrs);
    }
    curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($c, CURLOPT_MAXREDIRS, 10);
    //if SAFE_MODE or OPEN_BASEDIR is set,then FollowLocation cant be used.. so...
    $follow_allowed = (ini_get('open_basedir') || ini_get('safe_mode')) ? false : true;
    if ($follow_allowed) {
        curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
    }
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
    curl_setopt($c, CURLOPT_REFERER, $url);
    curl_setopt($c, CURLOPT_TIMEOUT, 60);
    curl_setopt($c, CURLOPT_AUTOREFERER, true);
    curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($c, CURLOPT_HEADER, !empty($extra['return_array']));
    $data = curl_exec($c);
    if (!empty($extra['return_array'])) {
        preg_match("/(.*?)\r\n\r\n((?!HTTP\/\d\.\d).*)/si", $data, $x);
        preg_match_all('/(.*?): (.*?)\r\n/i', trim('head_line: ' . $x[1]), $headers_, PREG_SET_ORDER);
        foreach ($headers_ as $each) {
            $header[$each[1]] = $each[2];
        }
        $data = trim($x[2]);
    }
    $status = curl_getinfo($c);
    curl_close($c);
    // if redirected, then get that redirected page
    if ($status['http_code'] == 301 || $status['http_code'] == 302) {
        //if we FOLLOWLOCATION was not allowed, then re-get REDIRECTED URL
        //p.s. WE dont need "else", because if FOLLOWLOCATION was allowed, then we wouldnt have come to this place, because 301 could already auto-followed by curl  :)
        if (!$follow_allowed) {
            //if REDIRECT URL is found in HEADER
            if (empty($redirURL)) {
                if (!empty($status['redirect_url'])) {
                    $redirURL = $status['redirect_url'];
                }
            }
            //if REDIRECT URL is found in RESPONSE
            if (empty($redirURL)) {
                preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
                if (!empty($m[2])) {
                    $redirURL = $m[2];
                }
            }
            //if REDIRECT URL is found in OUTPUT
            if (empty($redirURL)) {
                preg_match('/moved\s\<a(.*?)href\=\"(.*?)\"(.*?)here\<\/a\>/si', $data, $m);
                if (!empty($m[1])) {
                    $redirURL = $m[1];
                }
            }
            //if URL found, then re-use this function again, for the found url
            if (!empty($redirURL)) {
                $t = debug_backtrace();
                return call_user_func($t[0]["function"], trim($redirURL), $post_paramtrs);
            }
        }
    } // if not redirected,and nor "status 200" page, then error..
    elseif ($status['http_code'] != 200) {
        $data = "ERRORCODE22 with $url<br/><br/>Last status codes:" . json_encode($status) . "<br/><br/>Last data got:$data";
    }
    //URLS correction
    if (function_exists('url_corrections_for_content_HELPER')) {
        $data = url_corrections_for_content_HELPER($data, $status['url'], array('schemeless' => !empty($extra['schemeless']), 'replace_src' => !empty($extra['replace_src']), 'rawgit_replace' => !empty($extra['rawgit_replace'])));
    }
    $answer = (!empty($extra['return_array']) ? array('data' => $data, 'header' => $header, 'info' => $status) : $data);
    return $answer;
}

function url_corrections_for_content_HELPER($content = false, $url = false, $extra_opts = array('schemeless' => false, 'replace_src' => false, 'rawgit_replace' => false))
{
    $GLOBALS['rdgr']['schemeless'] = $extra_opts['schemeless'];
    $GLOBALS['rdgr']['replace_src'] = $extra_opts['replace_src'];
    $GLOBALS['rdgr']['rawgit_replace'] = $extra_opts['rawgit_replace'];
    if ($GLOBALS['rdgr']['schemeless'] || $GLOBALS['rdgr']['replace_src']) {
        if ($url) {
            $GLOBALS['rdgr']['parsed_url'] = parse_url($url);
            $GLOBALS['rdgr']['urlparts']['domain_X'] = $GLOBALS['rdgr']['parsed_url']['scheme'] . '://' . $GLOBALS['rdgr']['parsed_url']['host'];
            $GLOBALS['rdgr']['urlparts']['path_X'] = stripslashes(dirname($GLOBALS['rdgr']['parsed_url']['path']) . '/');
            $GLOBALS['rdgr']['all_protocols'] = array('adc', 'afp', 'amqp', 'bacnet', 'bittorrent', 'bootp', 'camel', 'dict', 'dns', 'dsnp', 'dhcp', 'ed2k', 'empp', 'finger', 'ftp', 'gnutella', 'gopher', 'http', 'https', 'imap', 'irc', 'isup', 'javascript', 'ldap', 'mime', 'msnp', 'map', 'modbus', 'mosh', 'mqtt', 'nntp', 'ntp', 'ntcip', 'openadr', 'pop3', 'radius', 'rdp', 'rlogin', 'rsync', 'rtp', 'rtsp', 'ssh', 'sisnapi', 'sip', 'smtp', 'snmp', 'soap', 'smb', 'ssdp', 'stun', 'tup', 'telnet', 'tcap', 'tftp', 'upnp', 'webdav', 'xmpp');
        }
        $GLOBALS['rdgr']['ext_array'] = array(
            'src' => array('audio', 'embed', 'iframe', 'img', 'input', 'script', 'source', 'track', 'video'),
            'srcset' => array('source'),
            'data' => array('object'),
            'href' => array('link', 'area', 'a'),
            'action' => array('form')
            //'param', 'applet' and 'base' tags are exclusion, because of a bit complex structure
        );
        $content = preg_replace_callback(
            '/<(((?!<).)*?)>/si',    //avoids unclosed & closing tags
            function ($matches_A) {
                $content_A = $matches_A[0];
                $tagname = preg_match('/((.*?)(\s|$))/si', $matches_A[1], $n) ? $n[2] : "";
                foreach ($GLOBALS['rdgr']['ext_array'] as $key => $value) {
                    if (in_array($tagname, $value)) {
                        preg_match('/ ' . $key . '=(\'|\")/i', $content_A, $n);
                        if (!empty($n[1])) {
                            $GLOBALS['rdgr']['aphostrope_type'] = $n[1];
                            $content_A = preg_replace_callback(
                                '/( ' . $key . '=' . $GLOBALS['rdgr']['aphostrope_type'] . ')(.*?)(' . $GLOBALS['rdgr']['aphostrope_type'] . ')/i',
                                function ($matches_B) {
                                    $full_link = $matches_B[2];
                                    //correction to files/urls
                                    if (!empty($GLOBALS['rdgr']['replace_src'])) {
                                        //if not schemeless url
                                        if (substr($full_link, 0, 2) != '//') {
                                            $replace_src_allow = true;
                                            //check if the link is a type of any special protocol
                                            foreach ($GLOBALS['rdgr']['all_protocols'] as $each_protocol) {
                                                //if protocol found - dont continue
                                                if (substr($full_link, 0, strlen($each_protocol) + 1) == $each_protocol . ':') {
                                                    $replace_src_allow = false;
                                                    break;
                                                }
                                            }
                                            if ($replace_src_allow) {
                                                $full_link = $GLOBALS['rdgr']['urlparts']['domain_X'] . (str_replace('//', '/', $GLOBALS['rdgr']['urlparts']['path_X'] . $full_link));
                                            }
                                        }
                                    }
                                    //replace http(s) with sheme-less urls
                                    if (!empty($GLOBALS['rdgr']['schemeless'])) {
                                        $full_link = str_replace(array('https://', 'http://'), '//', $full_link);
                                    }
                                    //replace github mime
                                    if (!empty($GLOBALS['rdgr']['rawgit_replace'])) {
                                        $full_link = str_replace('//raw.github' . 'usercontent.com/', '//rawgit.com/', $full_link);
                                    }
                                    $matches_B[2] = $full_link;
                                    unset($matches_B[0]);
                                    $content_B = '';
                                    foreach ($matches_B as $each) {
                                        $content_B .= $each;
                                    }
                                    return $content_B;
                                },
                                $content_A
                            );
                        }
                    }
                }
                return $content_A;
            },
            $content
        );
        $content = preg_replace_callback(
            '/style="(.*?)background(\-image|)(.*?|)\:(.*?|)url\((\'|\"|)(.*?)(\'|\"|)\)/i',
            function ($matches_A) {
                $url = $matches_A[7];
                $url = (substr($url, 0, 2) == '//' || substr($url, 0, 7) == 'http://' || substr($url, 0, 8) == 'https://' ? $url : '#');
                return 'style="' . $matches_A[1] . 'background' . $matches_A[2] . $matches_A[3] . ':' . $matches_A[4] . 'url(' . $url . ')'; //$matches_A[5] is url taged ,7 is url
            },
            $content
        );
    }
    return $content;
}

function salvar_arquivo_base64($local, $base64)
{
    $image_parts = explode(";base64,", $base64);
    $image_type_aux = explode("/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);
    $file_name = uniqid() . '.' . ($image_type == 'octet-stream' ? 'rar' : $image_type);
    $file = $local . $file_name;
    file_put_contents($file, $image_base64);

    return $file_name;
}

function is_base64($data)
{
    if (base64_encode(base64_decode($data, true)) === $data) {
        return true;
    } else {
        return false;
    }
}

function monta_clausula_contem($valores, $campo, $comparar = '=', $consulta = '')
{
    $retorno = '';
    if (!empty($valores)) {
        $retorno = array();

        if (!is_array($valores)) {
            $valores = array($valores);
        }
        foreach ($valores as $valor) {
            $clausula = "$campo $comparar ";
            if ($comparar == '=') {
                $clausula .= "'{$valor}'";
            } else {
                $clausula .= str_replace('{{valor}}', $valor, $consulta);
            }

            $retorno[] = $clausula;
        }
        $retorno = implode(' OR ', $retorno);
        $retorno = " AND ($retorno)";
    }
    return $retorno;
}

function resizeImage($fileName, $new_width, $directory)
{
    set_time_limit(0);
    ini_set('memory_limit', -1);

    list($width, $height, $type) = getimagesize($fileName);
    $new_height = round($height * $new_width / $width);
    $old_image = imagecreatetruecolor($new_width, $new_height);
    switch ($type) {
        case IMAGETYPE_JPEG:
            $new_image = imagecreatefromjpeg($fileName);
            break;
        case IMAGETYPE_GIF:
            $new_image = imagecreatefromgif($fileName);
            break;
        case IMAGETYPE_PNG:
            $new_image = imagecreatefrompng($fileName);
            break;
    }

    if (file_exists($directory)) {
        unlink($directory);
    }

    switch ($type) {
        case IMAGETYPE_JPEG:
            imagecopyresampled($old_image, $new_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($old_image, $directory);
            break;
        case IMAGETYPE_GIF:
            $bgcolor = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagefill($old_image, 0, 0, $bgcolor);
            imagecolortransparent($old_image, $bgcolor);
            imagecopyresampled($old_image, $new_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagegif($old_image, $directory);
            break;
        case IMAGETYPE_PNG:
            $targetImage = imagecreatetruecolor($new_width, $new_height);
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);

            imagecopyresampled(
                $targetImage,
                $new_image,
                0,
                0,
                0,
                0,
                $new_width,
                $new_height,
                $width,
                $height
            );

            imagepng($targetImage, $directory, 9);
            break;
    }
    imagedestroy($old_image);
    imagedestroy($new_image);
}

function descreve_array_itens($array, $e_ou = 'e')
{
    $ultimo = array_pop($array);
    return implode(', ', $array) . (!empty($array) ? " $e_ou " : '') . $ultimo;
}

function array_sort($array, $on, $order = SORT_ASC)
{

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    $v2 = texto_identificador($v2);
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $v = texto_identificador($v);
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function limparDiretorio($caminho, $tabelas_campos)
{
    $model = new \model\_BaseModel();
    $sql = array();

    echo "<hr/><b>Limpeza da pasta $caminho</b><br/>";
    echo date('Y-m-d H:i:s') . '<br/>';

    foreach ($tabelas_campos as $tabela => $campos) {
        foreach ($campos as $campo) {
            $sql[] = "SELECT LOWER({$campo}) AS nome FROM {$tabela}";
        }
    }

    $sql = implode(' UNION ', $sql);

    $retorno = $model->obterLista($sql);

    $diretorios = new DirectoryIterator($caminho);
    foreach ($diretorios as $diretorio) {

        if (!$diretorio->isDir()) {

            $apagar = true;
            $nome_arquivo = strtolower($diretorio->getFilename());

            if (in_array($nome_arquivo, array('placeholder.jpg', 'placeholder.png'))) {
                continue;
            }

            foreach ($retorno as $valor) {
                if (strpos($valor->nome, $nome_arquivo) !== false) {
                    $apagar = false;
                    break;
                }
            }

            if ($apagar) {
                echo 'Apagar = ' . $nome_arquivo . '<br>';
                unlink($caminho . $diretorio->getFilename());
            }
        }
    }

    echo date('Y-m-d H:i:s') . '<br/>';
}

function gerarSitemap()
{

    global $_sitemap_paginas_excluir;
    global $_sitemap_controllers;

    $url_raiz = 'http' . ($_SERVER['HTTPS'] ? 's' : '') . '://' . $_SERVER['SERVER_NAME'];
    $data = date('Y-m-d');

    $xml_indice = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
    <sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
    <sitemap>
    <loc>sitemaps_paginas.xml</loc>
    <lastmod>{$data}</lastmod>
    </sitemap>";

    $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
    <urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">
    <url>
    <loc>{$url_raiz}</loc>
    <lastmod>$data</lastmod>
    <priority>1.00</priority>
    </url>";

    $diretorios = new DirectoryIterator("../view");
    foreach ($diretorios as $diretorio) {
        $nome = strtolower(explode('.', $diretorio->getFilename())[0]);
        if (!$diretorio->isDir() && $nome[0] != '_' && !in_array($nome, $_sitemap_paginas_excluir)) {
            $data = date('Y-m-d', $diretorio->getMTime());

            $xml .= "\n<url>
            <loc>{$url_raiz}/{$nome}</loc>
            <lastmod>$data</lastmod>
            <priority>1.00</priority>
            </url>";
        }
    }

    $xml .= "\n</urlset>";

    file_put_contents('sitemaps_paginas.xml', $xml);

    foreach ($_sitemap_controllers as $sitemap_controller) {

        $caminho = "../controller/" . $sitemap_controller . "Controller.php";
        $nome_controller = arquivo_nome_real($caminho, true, false);
        $controller = "controller\\" . $nome_controller;

        $controller = new $controller;

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
        <urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";

        $dados = $controller->gerarSitemap();

        $contador_arquivos = 1;
        $contador = 0;
        $novo_sitemap = true;

        foreach ($dados as $dado) {
            if ($novo_sitemap) {
                $novo_sitemap = false;

                $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
                <urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
            }

            $xml .= "\n<url>
            <loc>{$url_raiz}{$dado['url']}</loc>
            <lastmod>{$dado['data']}</lastmod>
            <priority>1.00</priority>
            </url>";

            $contador++;

            if ($contador == 1000 || $dado == end($dados)) {
                $xml .= "\n</urlset>";

                $nome_arquivo = "sitemaps_{$sitemap_controller}_{$contador_arquivos}.xml";

                if ($dado == end($dados) && $contador_arquivos == 1) {
                    $nome_arquivo = "sitemaps_{$sitemap_controller}.xml";
                }

                file_put_contents($nome_arquivo, $xml);

                $xml_indice .= "\n<sitemap>
                <loc>{$nome_arquivo}</loc>
                <lastmod>{$data}</lastmod>
                </sitemap>";

                $contador = 0;
                $novo_sitemap = true;

                $contador_arquivos++;
            }
        }
    }

    $xml_indice .= "\n</sitemapindex>";

    file_put_contents('sitemaps.xml', $xml_indice);
}

function paginas($parametros, $total_paginas)
{
    $pagina_atual = $parametros['pagina'] ?? 1;
    $paginas_navegacao = 2;
    $pontos_pre = false;
    $pontos_pos = false;

    unset($parametros['pagina']);

    if ($total_paginas > 1) {
        for ($i = 0; $i < $total_paginas; $i++) {
            $pagina_item = $i + 1;

            if ($pagina_item == $pagina_atual) { ?>
                <span class="ativo"><?php echo $pagina_item ?></span>
                <?php } else if ($pagina_item < ($pagina_atual - $paginas_navegacao) && $pagina_item != 1) {
                if (!$pontos_pre) {
                    $pontos_pre = true;
                ?>
                    <span>…</span>
                <?php }  ?>
                <?php } else if ($pagina_item > ($pagina_atual + $paginas_navegacao) && $pagina_item != $total_paginas) {
                if (!$pontos_pos) {
                    $pontos_pos = true;
                ?>
                    <span>…</span>
                <?php }
            } else {

                $url = array("pagina=$pagina_item");

                foreach ($parametros as $chave => $valor) {
                    $url[] =  "$chave=$valor";
                }

                $url = implode('&', $url);

                ?>
                <a href="?<?php echo $url; ?>"><?php echo $pagina_item; ?></a>
<?php }
        }
    }
}

function daysDiff($date1, $date2)
{
    // Calculating the difference in timestamps
    $diff = strtotime($date2) - strtotime($date1);

    // 1 day = 24 hours
    // 24 * 60 * 60 = 86400 seconds
    return round($diff / 86400);
}

function daysBirthday($birthdate)
{
    $birthdateArray = date_parse_from_format("d-m-Y", $birthdate);
    $todayArray = date_parse_from_format("d-m-Y", date('d-m-Y')); //In the real thing, this should instead grab the actual current date

    $birthdate = date_create($todayArray["year"] . "-" . $birthdateArray["month"] . "-" . $birthdateArray["day"]);
    $today = date_create(date('d-m-Y')); //This should also be actual current date

    $diff = date_diff($today, $birthdate);
    return intval($diff->format("%R%a"));
}

function timeDiff($firstTime, $lastTime)
{
    $to = new DateTime($firstTime);
    $from = new DateTime($lastTime);
    $stat = $to->diff($from);

    return $stat->format('%Hh:%Im');
}

function objectToArrayKeyValue($items)
{
    $array = array();
    foreach ($items as $item) {
        $array[intval($item->id)] = $item->nome;
    }

    return $array;
}
