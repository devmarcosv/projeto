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
)