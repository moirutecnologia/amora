<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 28/02/2018
 * Time: 11:23
 */

namespace model;

class _BaseModel
{
    public $conexao;
    public $tabela;
    public $_usuario_id;
    public $registros_por_pagina;

    public function __construct()
    {
        global $_banco_servidor;
        global $_banco_nome;
        global $_banco_usuario;
        global $_banco_senha;

        $this->conexao = new \PDO("mysql:host={$_banco_servidor}; dbname={$_banco_nome}; charset=utf8;", $_banco_usuario, $_banco_senha);
        $this->conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->conexao->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

        $this->registros_por_pagina = 20;
    }

    public function obterRegistro($sql)
    {
        $comando = $this->conexao->query($sql);

        return $comando->fetchObject();
    }

    public function obterLista($sql, $pagina = null)
    {
        $comando = $this->conexao->prepare($sql);
        $comando->execute();

        $resultado = $comando->fetchAll(\PDO::FETCH_CLASS);
        $total_paginas = ceil($comando->rowcount() / $this->registros_por_pagina);

        if(!empty($pagina)){
            $resultado = array_splice($resultado, $this->registros_por_pagina * ($pagina - 1), $this->registros_por_pagina);
            
            return (object)array(
                'resultado' => $resultado,
                'total_paginas' => $total_paginas,
                'total_registros' => $comando->rowcount(), 
            );
        }

        return $resultado;
    }

    public function buscarPor($campo, $valor)
    {

        if (!is_array($campo)) {
            $campo = array($campo);
        }

        if (!is_array($valor)) {
            $valor = array($valor);
        }

        $sql = "SELECT 
                    *
                FROM {$this->tabela}";

        if (!empty($campo)) {
            $sql .= " WHERE ";

            for ($i = 0; $i < count($campo); $i++) {
                if(strtoupper($valor[$i]) != "IS NOT NULL") {
                    $valor[$i] = addslashes($valor[$i]);
                    $sql .= ($i > 0 ? " AND " : "") . "{$campo[$i]} = '{$valor[$i]}'";
                }else{
                    $sql .= ($i > 0 ? " AND " : "") . "{$campo[$i]} IS NOT NULL";
                }
            }

        }

        return $this->obterLista($sql);
    }

    public function obterPor($campo, $valor)
    {

        if (!is_array($campo)) {
            $campo = array($campo);
        }

        if (!is_array($valor)) {
            $valor = array($valor);
        }

        $sql = "SELECT 
                    * 
                FROM {$this->tabela}";

        if (!empty($campo)) {
            $sql .= " WHERE ";

            for ($i = 0; $i < count($campo); $i++) {
                $valor[$i] = addslashes($valor[$i]);
                $sql .= ($i > 0 ? " AND " : "") . "{$campo[$i]} = '{$valor[$i]}'";
            }

        }

        return $this->obterRegistro($sql);
    }

    public function obter()
    {
        $sql = "SELECT * FROM {$this->tabela} WHERE id = '{$this->id}'";

        $comando = $this->conexao->query($sql);
        return (object)$comando->fetchObject();

    }

    public function executar($sql)
    {
        $comando = $this->conexao->prepare($sql);
        $comando->execute();
    }


    public function salvar()
    {
        if (!empty($this->id)) {
            $sql = "UPDATE {$this->tabela} SET alterado_em = NOW()";

            $campos = array();

            foreach ($this as $nome => $valor) {
                if (!in_array($nome, array("conexao", "tabela", "_usuario_id", "registros_por_pagina", "token", "criado_em", "alterado_em"))) {
                    $valor = addslashes($valor);
                    $valor = $valor === "" || $valor === null ? "null" : "'$valor'";
                    $sql .= ", $nome = $valor";
                    $campos[$nome] = $valor;
                }
            }

            $sql .= " WHERE id = $this->id";

            $comando = $this->conexao->prepare($sql);

            $comando->execute();


        } else {

            $campos = array();
            $valores = array();

            foreach ($this as $nome => $valor) {
                if (!in_array($nome, array("conexao", "tabela", "_usuario_id", "registros_por_pagina", "token", "criado_em", "alterado_em"))) {
                    $campos[] = $nome;
                    $valor = addslashes($valor);
                    $valor = $valor === "" || $valor === null ? "null" : "'$valor'";
                    $valores[] = "$valor";
                }
            }

            $campos[] = "criado_em";
            $campos[] = "alterado_em";

            $valores[] = "NOW()";
            $valores[] = "NOW()";

            $camposSql = implode(", ", $campos);
            $valoresSql = implode(", ", $valores);

            $sql = "INSERT INTO {$this->tabela} ($camposSql) VALUES ($valoresSql)";

            $comando = $this->conexao->prepare($sql);
            $comando->execute();

            $this->id = $this->conexao->lastInsertId();
        }
    }

    public function atualizar()
    {
        $sql = "UPDATE {$this->tabela} SET alterado_em = NOW()";

        $campos = array();

        foreach ($this as $nome => $valor) {
            if (!in_array($nome, array("conexao", "tabela", "_usuario_id", "registros_por_pagina", "token", "criado_em", "alterador_em"))) {
                if ($valor !== "" && $valor != null) {
                    $valor = addslashes($valor);
                    $valor = "'$valor'";
                    $sql .= ", $nome = $valor";
                    $campos[$nome] = $valor;
                }
            }
        }

        $sql .= " WHERE id = $this->id";

        $comando = $this->conexao->prepare($sql);

        $comando->execute();

    }

    public function excluir()
    {
        $sql = "DELETE FROM {$this->tabela} WHERE id = :id";
        $comando = $this->conexao->prepare($sql);

        $comando->bindParam(':id', $this->id, \PDO::PARAM_STR);

        $comando->execute();
    }

    public function excluirPor($campo_clausula, $valor)
    {
        if(!is_array($campo_clausula)){
            $campo_clausula = array($campo_clausula);
        }

        if(!is_array($valor)){
            $valor = array($valor);
        }

        $sql = "DELETE FROM {$this->tabela} WHERE ";

        for ($i = 0; $i < count($campo_clausula); $i++) {
            $sql .= ($i > 0 ? " AND " : "") . "{$campo_clausula[$i]} = '{$valor[$i]}'";
        }

        $comando = $this->conexao->prepare($sql);

        $comando->execute();
    }

    public function setToken($token)
    {
        $this->token = $token;
        $this->validaToken();
    }

    public function getToken()
    {
        return $this->token;
    }

    public function __set($nome, $valor)
    {
        switch ($nome) {
            case 'token':
                return $this->setToken($valor);
        }
    }

    public function __get($nome)
    {
        switch ($nome) {
            case 'token':
                return $this->getToken();
        }
    }

    public function validaToken($desativar = true)
    {

        $sql = "SELECT 
                    t.id, 
                    t.usuario_id, 
                    t.ativo,
                    t.alterado_em
                FROM tokens AS t 
                INNER JOIN usuarios AS u 
                ON 
                    t.usuario_id = u.id 
                WHERE 
                    token = '{$this->token}'";
        $consulta = $this->conexao->query($sql);
        $dados = $consulta->fetchObject();

        if (!empty($this->token) && ($dados->ativo || !empty($dados))) {
            $this->_usuario_id = $dados->usuario_id;

            if ($desativar) {
                $sql = "UPDATE tokens SET alterado_em = NOW(), ativo = 0 WHERE id = :id";

                $comando = $this->conexao->prepare($sql);

                $comando->bindParam(':id', $dados->id, \PDO::PARAM_STR);
                $comando->execute();
            }

            $this->criarToken();
        } else {
            if ($desativar) {
                $sql = "UPDATE tokens SET 
                        alterado_em = NOW(), 
                        ativo = 0 
                    WHERE 
                        usuario_id = :usuario_id";

                $comando = $this->conexao->prepare($sql);

                $comando->bindParam(':usuario_id', $dados->usuario_id, \PDO::PARAM_STR);
                $comando->execute();

                throw new \Exception("token inválido:" . var_dump($this->token));
            }
        }

    }

    public function criarToken()
    {
        global $_usuario;

        $token = strtoupper(bin2hex(random_bytes(16)));

        $sql = "INSERT INTO tokens(
                      usuario_id, 
                      token,
                      ativo,
                      criado_em, 
                      alterado_em
                )VALUES (
                      :usuario_id, 
                      :token,
                      1, 
                      NOW(), 
                      NOW() 
                )";

        $comando = $this->conexao->prepare($sql);

        $comando->bindParam(':usuario_id', $_usuario->id, \PDO::PARAM_STR);
        $comando->bindParam(':token', $token, \PDO::PARAM_STR);

        $comando->execute();

        setcookie('token', $token, time() + (10 * 365 * 24 * 60 * 60), '/');

        return $token;
    }

    public function atualizarCampo($campo, $valor)
    {
        $sql = "UPDATE {$this->tabela} SET $campo = " . ($valor !== null ? "'$valor'" : 'null') . " WHERE id = {$this->id}";
        $comando = $this->conexao->prepare($sql);

        $comando->execute();
    }

}
