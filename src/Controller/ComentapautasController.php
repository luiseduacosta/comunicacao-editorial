<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Comentapautas Controller
 *
 * @property \App\Model\Table\ComentapautasTable $Comentapautas
 */
class ComentapautasController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comentapauta = $this->Comentapautas->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Automatically set current user
            $identity = $this->request->getAttribute('identity');
            if ($identity) {
                $data['user_id'] = $identity->id;
            }
            
            $comentapauta = $this->Comentapautas->patchEntity($comentapauta, $data);
            if ($this->Comentapautas->save($comentapauta)) {
                $this->Flash->success(__('Comentário adicionado com sucesso.'));
            } else {
                $this->Flash->error(__('Não foi possível adicionar o comentário. Por favor, tente novamente.'));
            }
            
            return $this->redirect(['controller' => 'Pautas', 'action' => 'view', $comentapauta->pauta_id]);
        }
        return $this->redirect(['controller' => 'Pautas', 'action' => 'index']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Comentapauta id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comentapauta = $this->Comentapautas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comentapauta = $this->Comentapautas->patchEntity($comentapauta, $this->request->getData());
            if ($this->Comentapautas->save($comentapauta)) {
                $this->Flash->success(__('O comentário foi atualizado com sucesso.'));

                return $this->redirect(['controller' => 'Pautas', 'action' => 'view', $comentapauta->pauta_id]);
            }
            $this->Flash->error(__('Não foi possível atualizar o comentário.'));
        }
        return $this->redirect(['controller' => 'Pautas', 'action' => 'view', $comentapauta->pauta_id]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Comentapauta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comentapauta = $this->Comentapautas->get($id);
        $pautaId = $comentapauta->pauta_id;
        if ($this->Comentapautas->delete($comentapauta)) {
            $this->Flash->success(__('O comentário foi removido.'));
        } else {
            $this->Flash->error(__('Não foi possível remover o comentário.'));
        }

        return $this->redirect(['controller' => 'Pautas', 'action' => 'view', $pautaId]);
    }
}
