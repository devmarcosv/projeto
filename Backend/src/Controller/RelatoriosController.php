<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Relatorios Controller
 *
 *
 * @method \App\Model\Entity\Relatorio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RelatoriosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    
    public function index()
    {   
        // Conexão com banco de dados
        $connection = ConnectionManager::get('default');

        $relatorio1 =  $connection->execute("
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
            id ASC ")->fetchAll('assoc');


        $relatorio2 =  $connection->execute("SELECT  placa, nome_carro, cor_carro, ano_carro, nome_cliente, c.id, combustivel_carro, marca_carro FROM  carros v, clientes c WHERE  c.id = v.cliente_id")->fetchAll('assoc');
        
        $relatorio3 =  $connection->execute("
        SELECT 
            placa, nome_carro, cor_carro, ano_carro, nome_cliente, c.id, combustivel_carro, marca_carro
        FROM 
            carros v, clientes c
        WHERE
            v.cliente_id = c.id
        ORDER BY 
            nome_cliente ASC")->fetchAll('assoc');

        
        $relatorio4 =  $connection->execute("
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
    ")->fetchAll('assoc');

        $relatorio5 =  $connection->execute("
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
        ")->fetchAll('assoc');

        $relatorio6 =  $connection->execute("
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
        ")->fetchAll('assoc');

        $relatorio7 =  $connection->execute("
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
            quant_cliente DESC, r.id ASC")->fetchAll('assoc');


        $relatorio8 =  $connection->execute("                 
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
            quant_marca DESC")->fetchAll('assoc');


        $relatorio9 =  $connection->execute("
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
              r.id ASC ")->fetchAll('assoc');

        $relatorio10 =  $connection->execute("
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
                r.id ")->fetchAll('assoc');

        $result = [
            'success' => true,
            'message' => 'Relatórios',
            'relatorio1' => [
                'titulo' => 'Todas as pessoas separadas por homens e mulheres ( com idade média de homens e mulheres )',
                'relatorio' => $relatorio1
            ],
            'relatorio2' => [
                'titulo' => ' Todos os carros',
                'relatorio' => $relatorio2
            ],
            'relatorio3' => [
                'titulo' => 'Todos os carros por pessoa ordenado por ordem de pessoa',
                'relatorio' => $relatorio3
            ],
            'relatorio4' => [
                'titulo' => 'Informação de quem tem mais carros ( homens ou mulheres )',
                'relatorio' => $relatorio4
            ],
            'relatorio5' =>  [
                'titulo' => 'Todas as marcas ordenadas pelo número de carros',
                'relatorio' => $relatorio5
            ],
            'relatorio6' =>  [
                'titulo' => 'Totais de marcas ordenados do maior para o menor, separados entre homens e mulheres',
                'relatorio' => $relatorio6
            ],
            'relatorio7' => [
                'titulo' => 'Pessoas com maior número de revisões',
                'relatorio' => $relatorio7
            ],
            'relatorio8' =>  [
                'titulo' => 'Marcas com maior número de revisões',
                'relatorio' => $relatorio8
            ],
            'relatorio9' =>  [
                'titulo' => 'Média de tempo entre uma revisão e outra de uma mesma pessoa',
                'relatorio' => $relatorio9
            ],
            'relatorio10' => [
                'titulo' => ' Próximas revisões baseado no tempo médio baseado na última revisão',
                'relatorio' => $relatorio10
            ]
        ];

        $this->set($result);
    }

    public function revisoesPeriodo(){ // /relatorios/revisoes-periodo?data1=01-05-2019&data2=31-05-2020
        $connection = ConnectionManager::get('default');

        $data1 = $this->request->query('data1');
        $data2 = $this->request->query('data2');

        $relatorio =   $relatorio10 =  $connection->execute("
            SELECT 
                r.id, to_char(data_revisao, 'DD/MM/YYYY') as data_revisao, descricao_revisao, valor_revisao, placa, marca_carro, nome_cliente, c.id
            FROM 
                clientes c, revisoes r, carros v
            WHERE 
                v.cliente_id = c.id 
            AND 
                r.carro_id = v.id
            AND
                data_revisao BETWEEN :data1 AND :data2
        ",
        [
            'data1' => $data1, 
            'data2'=>$data2
        ]
        )->fetchAll('assoc');


        $result = [
            'success' => true,
            'titulo' => 'Todas as revisões dentro de um período',
            'relatorio' => $relatorio
        ];

        $this->set($result);
    }
}
