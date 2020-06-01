-- Criar schema postgres

CREATE SCHEMA marcus_vinicius; 

-- Selecionar schema para salvar no postgres
SET search_path TO marcos_vinicius;

-- Tabelas

CREATE TABLE clientes (
    id SERIAL PRIMARY KEY,
    nome_cliente VARCHAR(255) NOT NULL,
    sexo_cliente VARCHAR(255) NOT NULL,
    idade_cliente SMALLINT NOT NULL
);

CREATE TABLE carros (
    id SERIAL PRIMARY KEY,
    placa char(8),
    nome_carro VARCHAR(40) NOT NULL,
    cor_carro VARCHAR(25) NOT NULL,
    ano_carro CHAR(4) NOT NULL,
    marca_carro varchar(255),
    combustivel_carro varchar(255),
    cliente_id int,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE revisoes (
    id SERIAL PRIMARY KEY,
    data_revisao DATE NOT NULL,
    descricao_revisao TEXT NOT NULL,
    valor_revisao REAL NOT NULL,
    carro_id int,
    FOREIGN KEY (carro_id) REFERENCES carros(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- Todas as pessoas
select * from clientes
-- Todas as pessoas separadas por homens e mulheres ( com idade média de homens e mulheres )
SELECT
	id, nome_cliente, sexo_cliente, idade_cliente,
	TRUNC(idade_media_homens, 1) as idade_media_homens, 
	TRUNC(idade_media_mulheres, 1) as idade_media_mulheres, 
	TRUNC(avg(idade_media_geral), 1) as idade_media_geral
FROM clientes,
	(
		SELECT avg(idade_cliente) as idade_media_homens
		from clientes
		where sexo_cliente = 'M'
	)as idade_homens,
	(
		SELECT avg(idade_cliente) as idade_media_mulheres
		from clientes
		where sexo_cliente = 'F'
	)as idade_mulheres,
	(
		SELECT avg(idade_cliente) as idade_media_geral from clientes
	) as idade_media_geral
GROUP BY
	id, nome_cliente, sexo_cliente, idade_cliente, idade_media_homens, idade_media_mulheres
ORDER BY
	id ASC

-- Todos os carros
SELECT 
	placa, nome_carro, cor_carro, ano_carro, nome_cliente, c.id, combustivel_carro, marca_carro
FROM 
	carros v, clientes c
WHERE
	c.id = v.cliente_id

-- Todos os carros por pessoa ordenado por ordem de pessoa
SELECT 
	placa, nome_carro, cor_carro, ano_carro, nome_cliente, c.id, combustivel_carro, marca_carro
FROM 
	carros v, clientes c
WHERE
	v.cliente_id = c.id
ORDER BY 
	nome_cliente ASC

-- Informação de quem tem mais carros ( homens ou mulheres )
SELECT
	c.id, nome_cliente, placa, nome_carro, marca_carro, combustivel_carro, ano_carro, cor_carro, homens, mulheres
FROM
	clientes c,  carros v,(
	SELECT 
		count(sexo_cliente) as homens 
	FROM 
		clientes c,  carros v
	WHERE 
		c.id = v.cliente_id
	AND 
		sexo_cliente = 'M'
	) as quantHomens,(
	SELECT 
		count(sexo_cliente) as mulheres 
	FROM 
		clientes c,  carros v
	WHERE 
		c.id = v.cliente_id
	AND 
		sexo_cliente = 'F'
	) as quantMulheres
WHERE
	c.id = v.cliente_id limit 1


-- Todas as marcas ordenadas pelo número de carros

SELECT 
	placa, nome_carro, cor_carro, ano_carro,  marca_carro, combustivel_carro, nome_cliente, c.id
FROM 
	(SELECT count(marca_carro)quant_marca, marca_carro as marca_aux
		FROM 
			carros 
		GROUP BY 
			marca_aux 
		ORDER BY 
			quant_marca DESC
	) marcas, 
	carros v, clientes c
WHERE 
	marca_carro = marca_aux
AND
	v.cliente_id = c.id 
ORDER BY 
	quant_marca DESC


-- Totais de marcas ordenados do maior para o menor, separados entre homens e mulheres
SELECT 
	placa, nome_cliente, c.id, cor_carro, nome_carro, ano_carro, marca_carro, combustivel_carro, sexo_cliente
FROM 
	carros v, clientes c, (
	SELECT count(marca_carro)quant_marca_homens, marca_carro as marca_homens
		FROM 
			carros v, clientes c
		WHERE 
			c.id = v.cliente_id
		GROUP BY 
			marca_homens 
		ORDER BY 
			quant_marca_homens DESC
	) as quantMarcasHomens
WHERE
	c.id = v.cliente_id
ORDER BY
	sexo_cliente ASC, quantMarcasHomens DESC

-- Todas as revisões dentro de um período
SELECT 
	r.id, to_char(data_revisao, 'DD/MM/YYYY') as data_revisao, descricao_revisao, valor_revisao, placa, marca_carro, nome_cliente, c.id
FROM 
	clientes c, revisoes r, carros v
WHERE 
	v.cliente_id = c.id 
AND 
	r.carro_id = v.id
AND
	data_revisao BETWEEN '$data1' AND '$data2'


-- Pessoas com maior número de revisões
SELECT
	r.id, to_char(data_revisao, 'DD/MM/YYYY') as data_revisao , descricao_revisao, 
	valor_revisao, placa, marca_carro, nome_cliente, c.id
FROM
	clientes c, revisoes r, carros v, (
		SELECT 
			count(nome_cliente) as quant_cliente, c.id as id_cliente_quant
		FROM
			clientes c, revisoes r, carros v
		WHERE 
			r.carro_id = v.id
		AND
			v.cliente_id = c.id 
		GROUP BY
			c.id
		ORDER BY
			quant_cliente DESC
	) as clientes 
WHERE
	id_cliente_quant = c.id 
AND 
	r.carro_id = v.id
AND 
	v.cliente_id = c.id 
ORDER BY 
	 quant_cliente DESC, r.id ASC

-- Marcas com maior número de revisões
SELECT 
	r.id, to_char(data_revisao, 'DD/MM/YYYY') as data_revisao , descricao_revisao, 
	valor_revisao, placa, marca_carro, nome_cliente, c.id
FROM 
	carros v, revisoes r, clientes c,
(
	SELECT 
		count(marca_carro)quant_marca, marca_carro as marca_carro_quant
	FROM 
		carros v, revisoes r
	WHERE 
		r.carro_id = v.id
	GROUP BY 
		marca_carro_quant
	ORDER BY 
		quant_marca DESC
) as marcas
WHERE
	v.marca_carro = marca_carro_quant
AND
	v.cliente_id = c.id 
AND
	r.carro_id = v.id
ORDER BY 
	quant_marca DESC

-- Média de tempo entre uma revisão e outra de uma mesma pessoa
SELECT r.id, c.id, placa, marca_carro, combustivel_carro, to_char(data_revisao, 'DD/MM/YYYY') as data_revisao , descricao_revisao, valor_revisao, nome_cliente,
	(MAX(data_meio) - MIN(data_meio)) / 
		CASE WHEN COUNT(id_cliente_meio) > 1  
			THEN (COUNT(id_cliente_meio) - 1)
			ELSE COUNT(id_cliente_meio)
		END	as mediaTempo
FROM 
	 clientes c, revisoes r, carros v, (
		SELECT
			c.id AS id_cliente_meio, data_revisao AS data_meio
		FROM 
			clientes c, revisoes r, carros v
		WHERE 
			v.id = r.carro_id AND v.cliente_id = c.id	 
		)AS datas
WHERE 
	id_cliente_meio = v.cliente_id
AND
	v.cliente_id = c.id 
AND 
	r.carro_id = v.id
GROUP BY 
	r.id, c.id, placa, marca_carro, combustivel_carro, data_revisao , descricao_revisao, valor_revisao, nome_cliente
ORDER BY
	r.id ASC 

-- Próximas revisões baseado no tempo médio baseado na última revisão
SELECT r.id, c.id, placa, marca_carro, combustivel_carro, to_char(data_revisao, 'DD/MM/YYYY') AS data_revisao , descricao_revisao, valor_revisao, nome_cliente,
	to_char((MAX(data_meio) + ((MAX(data_meio) - MIN(data_meio)) / 
		CASE WHEN COUNT(id_cliente_meio) > 1  
			THEN (COUNT(id_cliente_meio) - 1)
			ELSE COUNT(id_cliente_meio)
	END || ' days')::interval)::date, 'DD/MM/YYYY') AS prox_revisao
FROM 
	 clientes c, revisoes r, carros v,(
		SELECT
			c.id AS id_cliente_meio, data_revisao AS data_meio
		FROM 
			clientes c, revisoes r, carros v
		where 
			v.id = r.carro_id AND v.cliente_id = c.id 
		)AS datas
WHERE 
	id_cliente_meio = v.cliente_id
AND
	v.cliente_id = c.id
AND 
	r.carro_id = v.id
GROUP BY 
	c.id, placa, marca_carro, combustivel_carro, data_revisao , descricao_revisao, valor_revisao, nome_cliente, r.id
ORDER BY
	r.id