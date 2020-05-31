<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Carros Controller
 *
 * @property \App\Model\Table\CarrosTable $Carros
 *
 * @method \App\Model\Entity\Carro[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CarrosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes'],
        ];
        $carros = $this->paginate($this->Carros);

        $this->set(compact('carros'));
    }

    /**
     * View method
     *
     * @param string|null $id Carro id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $carro = $this->Carros->get($id, [
            'contain' => ['Clientes', 'Revisoes'],
        ]);

        $this->set('carro', $carro);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $result = [
            'success'=> false,
            'message' => ''
        ];

        $carro = $this->Carros->newEntity();

        if ($this->request->is('post')) {
            $carro = $this->Carros->patchEntity($carro, $this->request->getData());
            if ($this->Carros->save($carro)) {
                $result['success'] = true;
                $result['message'] = 'Veiculo cadastrado com sucesso';
            }else{
                $result['errors'] = $carro->errors();  
                $result['message'] = 'Não foi possivel cadastrar veiculo';
            }
        }

        $this->set($result);
    }

    /**
     * Edit method
     *
     * @param string|null $id Carro id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $result = [
            'success'=> false,
            'message' => ''
        ];

        $carro = $this->Carros->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $carro = $this->Carros->patchEntity($carro, $this->request->getData());
            if ($this->Carros->save($carro)) {
                $result['success'] = true;
                $result['message'] = 'Veiculo alterar com sucesso';
            }else{
                $result['errors'] = $carro->errors();  
                $result['message'] = 'Não foi possivel alterar veiculo';
            }
        }
        
        $this->set($result);
    }

    /**
     * Delete method
     *
     * @param string|null $id Carro id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $result = [
            'success'=> false,
            'message' => ''
        ];

        $this->request->allowMethod(['post', 'delete']);
        $carro = $this->Carros->get($id);
        if ($this->Carros->delete($carro)) {
            $result['success'] = true;
            $result['message'] = 'Veiculo deletado sucesso';
        } else {
            $result['message'] = 'Não foi possivel deletar veiculo';
        }

        $this->set($result);
    }
}
