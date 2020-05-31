<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Revisoes Controller
 *
 * @property \App\Model\Table\RevisoesTable $Revisoes
 *
 * @method \App\Model\Entity\Reviso[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RevisoesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Carros'],
        ];
        $revisoes = $this->paginate($this->Revisoes);

        $this->set(compact('revisoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Reviso id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reviso = $this->Revisoes->get($id, [
            'contain' => ['Carros'],
        ]);

        $this->set('reviso', $reviso);
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
        
        $reviso = $this->Revisoes->newEntity();

        if ($this->request->is('post')) {
            $reviso = $this->Revisoes->patchEntity($reviso, $this->request->getData());
            if ($this->Revisoes->save($reviso)) {
                $result['success'] = true;
                $result['message'] = 'Revisão agendada com sucesso';
            }else{
                $result['errors'] = $reviso->errors();  
                $result['message'] = 'Não foi possivel agendar revisão';
            }
        }

        $this->set($result);
    }

    /**
     * Edit method
     *
     * @param string|null $id Reviso id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $result = [
            'success'=> false,
            'message' => ''
        ];

        $reviso = $this->Revisoes->get($id, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reviso = $this->Revisoes->patchEntity($reviso, $this->request->getData());
            if ($this->Revisoes->save($reviso)) {
                $result['success'] = true;
                $result['message'] = 'Revisão alterada com sucesso';
            }else{
                $result['errors'] = $reviso->errors();  
                $result['message'] = 'Não foi possivel alterar revisão';
            }
        }

        $this->set($result);
    }

    /**
     * Delete method
     *
     * @param string|null $id Reviso id.
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
        $reviso = $this->Revisoes->get($id);
        
        if ($this->Revisoes->delete($reviso)) {
            $result['success'] = true;
            $result['message'] = 'Revisão deletada com sucesso';
        }else{
            $result['message'] = 'Não foi possivel deletar revisão';
        }
        
        $this->set($result);
    }
}
