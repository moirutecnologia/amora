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

-- TEMPO DE RECOMPRA
CREATE TEMPORARY TABLE ultimas_vendas
SELECT
    sv.data,
    svp.produto_id,
    sv.cliente_id,
    c.whatsapp,
    m.nome AS marca,
    p.nome AS produto,
    c.nome AS cliente,
    m.enviar_whatsapp
FROM vendas_produtos AS svp
INNER JOIN vendas AS sv
    ON svp.venda_id = sv.id
INNER JOIN clientes AS c
    ON sv.cliente_id = c.id
INNER JOIN produtos AS p
    ON svp.produto_id = p.id
INNER JOIN marcas AS m
    ON p.marca_id = m.id
WHERE
    sv.usuario_id = '13'
    AND ('2014-05-06' = '1900-01-01' OR sv.data >= '2014-05-06')
    AND ('6000-01-01 23:59:59' = '6000-01-01 23:59:59' OR sv.data <= '6000-01-01 23:59:59');

create index idx_produto_id ON ultimas_vendas(produto_id);
create index idx_data ON ultimas_vendas(data);
create index idx_cliente ON ultimas_vendas(cliente_id);
create index idx_venda ON ultimas_vendas(produto_id, cliente_id, data);

CREATE TEMPORARY TABLE ultimas_vendas_produtos
SELECT * FROM ultimas_vendas;

create index idx_produto_id_2 ON ultimas_vendas_produtos(produto_id);
create index idx_data_2 ON ultimas_vendas_produtos(data);
create index idx_cliente_2 ON ultimas_vendas_produtos(cliente_id);
create index idx_venda_2 ON ultimas_vendas_produtos(produto_id, cliente_id, data);

CREATE TEMPORARY TABLE produto_datas
SELECT
    uv.cliente,
    uv.produto,
    uv.marca,
    uv.cliente_id,
    uv.whatsapp,
    uv.enviar_whatsapp,
    (
        SELECT
            MAX(suvp.data)
        FROM ultimas_vendas_produtos AS suvp
        WHERE
            suvp.produto_id = uv.produto_id
            AND suvp.cliente_id = uv.cliente_id
            AND suvp.data < uv.data
        GROUP BY suvp.produto_id
        LIMIT 1
    ) AS anterior,
    uv.data AS ultima,
    uv.produto_id
FROM ultimas_vendas AS uv
ORDER BY uv.data;

SELECT
    d.cliente_id,
    d.cliente,
    d.whatsapp,
    CONCAT(d.marca , ' - ', d.produto) AS produto,
    ROUND(AVG(DATEDIFF(ultima, anterior)),0) AS media,
    DATEDIFF(now(), MAX(ultima)) AS ultima,
    (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima))) - 15 AS alerta,
    AVG(DATEDIFF(ultima, anterior)) - DATEDIFF(now(), MAX(ultima)) AS ordem
FROM produto_datas AS d
WHERE
    d.anterior IS NOT NULL
    AND ('1' = '' OR d.enviar_whatsapp = '1')
    AND d.whatsapp IS NULL
GROUP BY
    d.cliente_id,
    d.cliente,
    d.whatsapp,
    d.marca,
    d.produto
HAVING
    ('15' = '' OR (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima))) >= '15')
ORDER BY 
    (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima)))

-- PRÓXIMOS ENVIOS DO WHATS --
CREATE TEMPORARY TABLE ultimas_vendas
SELECT
    sv.data,
    svp.produto_id,
    sv.cliente_id,
    c.whatsapp,
    m.nome AS marca,
    p.nome AS produto,
    c.nome AS cliente,
    m.enviar_whatsapp
FROM vendas_produtos AS svp
INNER JOIN vendas AS sv
    ON svp.venda_id = sv.id
INNER JOIN clientes AS c
    ON sv.cliente_id = c.id
INNER JOIN produtos AS p
    ON svp.produto_id = p.id
INNER JOIN marcas AS m
    ON p.marca_id = m.id
WHERE
    sv.usuario_id = '13'
    AND ('2014-05-06' = '1900-01-01' OR sv.data >= '2014-05-06')
    AND ('6000-01-01 23:59:59' = '6000-01-01 23:59:59' OR sv.data <= '6000-01-01 23:59:59');

create index idx_produto_id ON ultimas_vendas(produto_id);
create index idx_data ON ultimas_vendas(data);
create index idx_cliente ON ultimas_vendas(cliente_id);
create index idx_venda ON ultimas_vendas(produto_id, cliente_id, data);

CREATE TEMPORARY TABLE ultimas_vendas_produtos
SELECT * FROM ultimas_vendas;

create index idx_produto_id_2 ON ultimas_vendas_produtos(produto_id);
create index idx_data_2 ON ultimas_vendas_produtos(data);
create index idx_cliente_2 ON ultimas_vendas_produtos(cliente_id);
create index idx_venda_2 ON ultimas_vendas_produtos(produto_id, cliente_id, data);

CREATE TEMPORARY TABLE produto_datas
SELECT
    uv.cliente,
    uv.produto,
    uv.marca,
    uv.cliente_id,
    uv.whatsapp,
    uv.enviar_whatsapp,
    (
        SELECT
            MAX(suvp.data)
        FROM ultimas_vendas_produtos AS suvp
        WHERE
            suvp.produto_id = uv.produto_id
            AND suvp.cliente_id = uv.cliente_id
            AND suvp.data < uv.data
        GROUP BY suvp.produto_id
        LIMIT 1
    ) AS anterior,
    uv.data AS ultima,
    uv.produto_id
FROM ultimas_vendas AS uv
ORDER BY uv.data;

SELECT
    d.cliente,
    CONCAT(d.marca , ' - ', d.produto) AS produto,
    (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima))) - 15 AS alerta
FROM produto_datas AS d
WHERE
    d.anterior IS NOT NULL
    AND ('1' = '' OR d.enviar_whatsapp = '1')
    AND d.whatsapp IS NULL
GROUP BY
    d.cliente_id,
    d.cliente,
    d.whatsapp,
    d.marca,
    d.produto
HAVING
    ('15' = '' OR (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima))) >= '15')
ORDER BY 
    (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima)))