/*Limpeza do banco*/
DELETE FROM marcas WHERE usuario_id NOT IN (SELECT id FROM usuarios);
DELETE FROM clientes WHERE usuario_id NOT IN (SELECT id FROM usuarios);
DELETE FROM investimentostipos WHERE usuario_id NOT IN (SELECT id FROM usuarios);
DELETE FROM vendas WHERE usuario_id NOT IN (SELECT id FROM usuarios);
DELETE FROM produtos WHERE usuario_id NOT IN (SELECT id FROM usuarios);
DELETE FROM tokens WHERE usuario_id NOT IN (SELECT id FROM usuarios);
DELETE FROM produtosskus WHERE produto_id NOT IN (SELECT id FROM produtos);
DELETE FROM clientespagamentos WHERE cliente_id NOT IN (SELECT id FROM clientes);
DELETE FROM investimentos WHERE investimentotipo_id NOT IN (SELECT id FROM investimentostipos);
DELETE FROM vendas_produtos WHERE venda_id NOT IN (SELECT id FROM vendas);
DELETE FROM vendas_produtos_entregas WHERE vendaproduto_id NOT IN (SELECT id FROM vendas_produtos);
DELETE FROM entregas WHERE id NOT IN (SELECT entrega_id FROM vendas_produtos_entregas);
DELETE FROM produtosskus_entregas WHERE entrega_id NOT IN (SELECT id FROM entregas);

$2y$10$IRn4in.QL8OF9BprdsYWce2QUQ8QFCnDqkG9Rvd2SZr17u7KyBY0y

INSERT INTO `usuarios` (`id`, `USERID`, `nome`, `email`, `senha`, `perfil_ids`, `assinante`, `criado_em`, `alterado_em`) VALUES (NULL, '0', 'Thiago', 'cthiagotavares@gmail.com', '$2y$10$IRn4in.QL8OF9BprdsYWce2QUQ8QFCnDqkG9Rvd2SZr17u7KyBY0y', '[\"1\"]', '1', '2021-04-02 13:43:05', '2021-04-02 13:43:05');