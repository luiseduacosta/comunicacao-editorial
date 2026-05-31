<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Pautas Controller
 *
 * @property \App\Model\Table\PautasTable $Pautas
 */
class PautasController extends AppController
{
    /**
     * Pagination configuration
     *
     * @var array
     */
    public array $paginate = [
        'limit' => 10,
        'order' => [
            'Pautas.data' => 'desc',
            'Pautas.id' => 'desc'
        ]
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Pautas->find();

        // Filter by archive status
        $arquivado = $this->request->getQuery('arquivado');
        if ($arquivado === '1') {
            $query->where(['Pautas.arquivar' => true]);
        } else {
            $query->where(['Pautas.arquivar' => false]);
        }

        // Filter by target audience (informandes)
        $informandes = $this->request->getQuery('informandes');
        if ($informandes !== null && $informandes !== '') {
            $query->where(['Pautas.informandes' => (int)$informandes]);
        }

        $pautas = $this->paginate($query);

        $this->set(compact('pautas'));
    }

    /**
     * View method
     *
     * @param string|null $id Pauta id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pauta = $this->Pautas->get($id, contain: [
            'Comentapautas' => [
                'sort' => ['Comentapautas.id' => 'ASC'],
            ],
            'Materias'
        ]);

        $comentapauta = $this->Pautas->Comentapautas->newEmptyEntity();

        $this->set(compact('pauta', 'comentapauta'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pauta = $this->Pautas->newEmptyEntity();
        if ($this->request->is('post')) {
            $pauta = $this->Pautas->patchEntity($pauta, $this->request->getData());
            if ($this->Pautas->save($pauta)) {
                $this->Flash->success(__('A pauta foi cadastrada com sucesso.'));

                return $this->redirect(['action' => 'view', $pauta->id]);
            }
            $this->Flash->error(__('Não foi possível cadastrar a pauta. Por favor, tente novamente.'));
        }
        $this->set(compact('pauta'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pauta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pauta = $this->Pautas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pauta = $this->Pautas->patchEntity($pauta, $this->request->getData());
            if ($this->Pautas->save($pauta)) {
                $this->Flash->success(__('A pauta foi atualizada com sucesso.'));

                return $this->redirect(['action' => 'view', $pauta->id]);
            }
            $this->Flash->error(__('Não foi possível salvar a pauta. Por favor, tente novamente.'));
        }
        $this->set(compact('pauta'));
    }

    /**
     * Archive method
     *
     * @param string|null $id Pauta id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function archive($id = null)
    {
        $this->request->allowMethod(['post']);
        $pauta = $this->Pautas->get($id);
        $pauta->arquivar = true;
        if ($this->Pautas->save($pauta)) {
            $this->Flash->success(__('A pauta foi arquivada com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível arquivar a pauta.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Restore method
     *
     * @param string|null $id Pauta id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function restore($id = null)
    {
        $this->request->allowMethod(['post']);
        $pauta = $this->Pautas->get($id);
        $pauta->arquivar = false;
        if ($this->Pautas->save($pauta)) {
            $this->Flash->success(__('A pauta foi restaurada com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível restaurar a pauta.'));
        }

        return $this->redirect(['action' => 'index', '?' => ['arquivado' => '1']]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Pauta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pauta = $this->Pautas->get($id);
        if ($this->Pautas->delete($pauta)) {
            $this->Flash->success(__('A pauta foi excluída permanentemente.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir a pauta.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
