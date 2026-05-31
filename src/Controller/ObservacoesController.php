<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Observacoes Controller
 *
 * @property \App\Model\Table\ObservacoesTable $Observacoes
 */
class ObservacoesController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $observaco = $this->Observacoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Automatically set current user
            $identity = $this->request->getAttribute('identity');
            if ($identity) {
                $data['user_id'] = $identity->id;
                $data['autor'] = $identity->username;
            }            
            $observaco = $this->Observacoes->patchEntity($observaco, $data);
            if ($this->Observacoes->save($observaco)) {
                $this->Flash->success(__('Observação adicionada com sucesso.'));
            } else {
                $this->Flash->error(__('Não foi possível adicionar a observação. Por favor, tente novamente.'));
            }
            
            return $this->redirect(['controller' => 'Materias', 'action' => 'view', $observaco->materia_id]);
        }
        return $this->redirect(['controller' => 'Materias', 'action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Observaco id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $observaco = $this->Observacoes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $observaco = $this->Observacoes->patchEntity($observaco, $this->request->getData());
            if ($this->Observacoes->save($observaco)) {
                $this->Flash->success(__('A observação foi atualizada com sucesso.'));

                return $this->redirect(['controller' => 'Materias', 'action' => 'view', $observaco->materia_id]);
            }
            $this->Flash->error(__('Não foi possível atualizar a observação.'));
        }
        return $this->redirect(['controller' => 'Materias', 'action' => 'view', $observaco->materia_id]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Observaco id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $observaco = $this->Observacoes->get($id);
        $materiaId = $observaco->materia_id;
        if ($this->Observacoes->delete($observaco)) {
            $this->Flash->success(__('A observação foi removida.'));
        } else {
            $this->Flash->error(__('Não foi possível remover a observação.'));
        }

        return $this->redirect(['controller' => 'Materias', 'action' => 'view', $materiaId]);
    }
}
