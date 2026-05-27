<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Utility\Text;

/**
 * Materias Controller
 *
 * @property \App\Model\Table\MateriasTable $Materias
 */
class MateriasController extends AppController
{
    /**
     * Pagination configuration
     *
     * @var array
     */
    public array $paginate = [
        'limit' => 10,
        'order' => [
            'Materias.id' => 'desc'
        ]
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Materias->find()->contain(['Pautas', 'Tags']);

        // Filter by archive status
        $arquivado = $this->request->getQuery('arquivado');
        if ($arquivado === '1') {
            $query->where(['Materias.arquivar' => true]);
        } else {
            $query->where(['Materias.arquivar' => false]);
        }

        // Filter by target audience (informandes)
        $informandes = $this->request->getQuery('informandes');
        if ($informandes !== null && $informandes !== '') {
            $query->where(['Materias.informandes' => (int)$informandes]);
        }

        // Filter by tag
        $tagId = $this->request->getQuery('tag_id');
        if (!empty($tagId)) {
            $query->innerJoinWith('Tags', function($q) use ($tagId) {
                return $q->where(['Tags.id' => $tagId]);
            });
        }

        // Search text
        $search = $this->request->getQuery('search');
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Materias.titulo LIKE' => '%' . $search . '%',
                    'Materias.conteudo LIKE' => '%' . $search . '%'
                ]
            ]);
        }

        // CSV Export Mode
        if ($this->request->getQuery('export') === 'csv') {
            return $this->exportCsv($query->all());
        }

        $materias = $this->paginate($query);
        $tags = $this->Materias->Tags->find('list', limit: 200)->all();

        $this->set(compact('materias', 'tags'));
    }

    /**
     * View method
     *
     * @param string|null $id Materia id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $materia = $this->Materias->get($id, contain: [
            'Pautas',
            'Tags',
            'Observacoes' => [
                'sort' => ['Observacoes.id' => 'ASC'],
            ]
        ]);

        $observaco = $this->Materias->Observacoes->newEmptyEntity();

        $this->set(compact('materia', 'observaco'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materia = $this->Materias->newEmptyEntity();
        
        // Check if pre-populated pauta_id is passed in query
        $pautaId = $this->request->getQuery('pauta_id');
        if ($pautaId) {
            $materia->pauta_id = (int)$pautaId;
        }
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $uploadedFiles = $this->request->getData('upload_files');
            $uploadedNames = [];
            
            if (!empty($uploadedFiles)) {
                // Ensure array format for loop
                if (!is_array($uploadedFiles)) {
                    $uploadedFiles = [$uploadedFiles];
                }
                
                foreach ($uploadedFiles as $index => $file) {
                    if ($file->getError() === UPLOAD_ERR_OK) {
                        $originalName = $file->getClientFilename();
                        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                        
                        // Naming: materia-{YYYY-MM-DD-HH:mm}-{index}.{ext}
                        $dateStr = date('Y-m-d-H\hi');
                        $fileName = sprintf('materia-%s-%d.%s', $dateStr, $index + 1, $ext);
                        
                        $destPath = WWW_ROOT . 'files' . DS;
                        if (!is_dir($destPath)) {
                            mkdir($destPath, 0777, true);
                        }
                        
                        $file->moveTo($destPath . $fileName);
                        $uploadedNames[] = $fileName;
                    }
                }
            }
            
            $data['anexos'] = !empty($uploadedNames) ? implode(',', $uploadedNames) : null;
            $materia = $this->Materias->patchEntity($materia, $data);
            
            if ($this->Materias->save($materia)) {
                $this->Flash->success(__('A matéria foi cadastrada com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar a matéria. Por favor, tente novamente.'));
        }
        // Fetch all pautas without materias for dropdown
        $pautas = $this->Materias->Pautas
            ->find('list', keyField: 'id', valueField: function ($pauta) {
                $titulo = $pauta->titulo ?? '';
                $titulo = trim(preg_replace('/\s+/', ' ', $titulo));

                $titulo = Text::truncate($titulo, 30, [
                    'ellipsis' => '…',
                    'exact' => false,
                ]);

                return $pauta->id . ' - ' . $titulo;
            })
            ->select(['Pautas.id', 'Pautas.titulo', 'Pautas.data'])
            ->orderBy(['Pautas.data' => 'DESC', 'Pautas.id' => 'DESC'])
            ->notMatching('Materias')
            ->all();
        $tags = $this->Materias->Tags->find('list', limit: 200)->all();
        $this->set(compact('materia', 'pautas', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Materia id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $materia = $this->Materias->get($id, contain: ['Tags', 'Pautas']);

        // Handle specific attachment deletion request
        $deleteFile = $this->request->getQuery('delete_file');
        if (!empty($deleteFile)) {
            $filePath = WWW_ROOT . 'files' . DS . $deleteFile;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $existingAnexos = $materia->anexos ? explode(',', $materia->anexos) : [];
            $updatedAnexos = array_filter($existingAnexos, function($val) use ($deleteFile) {
                return $val !== $deleteFile;
            });
            $materia->anexos = !empty($updatedAnexos) ? implode(',', $updatedAnexos) : null;
            $this->Materias->save($materia);
            
            $this->Flash->success(__('O anexo foi removido com sucesso.'));
            return $this->redirect(['action' => 'edit', $materia->id]);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $uploadedFiles = $this->request->getData('upload_files');
            $uploadedNames = $materia->anexos ? explode(',', $materia->anexos) : [];
            
            if (!empty($uploadedFiles)) {
                if (!is_array($uploadedFiles)) {
                    $uploadedFiles = [$uploadedFiles];
                }
                
                $baseIndex = count($uploadedNames);
                foreach ($uploadedFiles as $index => $file) {
                    if ($file->getError() === UPLOAD_ERR_OK) {
                        $originalName = $file->getClientFilename();
                        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
                        
                        $dateStr = date('Y-m-d-H\hi');
                        $fileName = sprintf('materia-%s-%d.%s', $dateStr, $baseIndex + $index + 1, $ext);
                        
                        $destPath = WWW_ROOT . 'files' . DS;
                        if (!is_dir($destPath)) {
                            mkdir($destPath, 0777, true);
                        }
                        
                        $file->moveTo($destPath . $fileName);
                        $uploadedNames[] = $fileName;
                    }
                }
            }
            
            $data['anexos'] = !empty($uploadedNames) ? implode(',', $uploadedNames) : null;
            $materia = $this->Materias->patchEntity($materia, $data);

            if ($this->Materias->save($materia)) {
                $this->Flash->success(__('A matéria foi atualizada com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar a matéria. Por favor, tente novamente.'));
        }
        
        $pautas = $this->Materias->Pautas
            ->find('list', keyField: 'id', valueField: function ($pauta) {
                $titulo = $pauta->titulo ?? '';
                $titulo = trim(preg_replace('/\s+/', ' ', $titulo));

                $titulo = Text::truncate($titulo, 20, [
                    'ellipsis' => '…',
                    'exact' => false,
                ]);

                return $pauta->id . ' - ' . $titulo;
            })
            ->select(['Pautas.id', 'Pautas.titulo', 'Pautas.data'])
            ->orderBy(['Pautas.data' => 'DESC', 'Pautas.id' => 'DESC'])
            ->notMatching('Materias')
            ->all()
            ->toArray();

        if ($materia->pauta_id !== null) {
            $pautaAtual = $this->Materias->Pautas
                ->find('list', keyField: 'id', valueField: function ($pauta) {
                    $titulo = $pauta->titulo ?? '';
                    $titulo = trim(preg_replace('/\s+/', ' ', $titulo));

                    $titulo = Text::truncate($titulo, 20, [
                        'ellipsis' => '…',
                        'exact' => false,
                    ]);

                    return $pauta->id . ' - ' . $titulo;
                })
                ->select(['Pautas.id', 'Pautas.titulo', 'Pautas.data'])
                ->where(['Pautas.id' => $materia->pauta_id])
                ->all()
                ->toArray();

            $pautas = $pautaAtual + $pautas;
        }

        $tags = $this->Materias->Tags->find('list')->all();
        $this->set(compact('materia', 'pautas', 'tags'));
    }

    /**
     * Archive method
     *
     * @param string|null $id Materia id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function archive($id = null)
    {
        $this->request->allowMethod(['post']);
        $materia = $this->Materias->get($id);
        $materia->arquivar = true;
        if ($this->Materias->save($materia)) {
            $this->Flash->success(__('A matéria foi arquivada com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível arquivar a matéria.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Restore method
     *
     * @param string|null $id Materia id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function restore($id = null)
    {
        $this->request->allowMethod(['post']);
        $materia = $this->Materias->get($id);
        $materia->arquivar = false;
        if ($this->Materias->save($materia)) {
            $this->Flash->success(__('A matéria foi restaurada com sucesso.'));
        } else {
            $this->Flash->error(__('Não foi possível restaurar a matéria.'));
        }

        return $this->redirect(['action' => 'index', '?' => ['arquivado' => '1']]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Materia id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materia = $this->Materias->get($id);
        
        // Clean up file attachments from system
        if (!empty($materia->anexos)) {
            $files = explode(',', $materia->anexos);
            foreach ($files as $file) {
                $filePath = WWW_ROOT . 'files' . DS . $file;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        
        if ($this->Materias->delete($materia)) {
            $this->Flash->success(__('A matéria foi excluída permanentemente.'));
        } else {
            $this->Flash->error(__('Não foi possível excluir a matéria.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Export dynamic CSV method
     *
     * @param iterable $data Dataset
     * @return \Cake\Http\Response
     */
    protected function exportCsv($data)
    {
        $this->autoRender = false;
        $response = $this->response->withType('csv')
            ->withHeader('Content-Disposition', 'attachment; filename="materias_report_' . date('Y-m-d') . '.csv"');

        $stream = fopen('php://temp', 'r+');
        // Add UTF-8 BOM for Excel compatibility
        fprintf($stream, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header columns
        fputcsv($stream, [
            'ID', 'Título', 'Pauta ID', 'Veículo', 'Data de Publicação', 'Arquivada', 'Anexos', 'Criada', 'Modificada'
        ], ';');

        foreach ($data as $row) {
            fputcsv($stream, [
                $row->id,
                $row->titulo,
                $row->pauta_id ?: 'Sem Pauta',
                $row->informandes ? 'Newsletter' : 'Website',
                $row->data->format('d/m/Y'),
                $row->arquivar ? 'Sim' : 'Não',
                $row->anexos ?: 'Nenhum',
                $row->created ? $row->created->format('d/m/Y H:i') : '-',
                $row->modified ? $row->modified->format('d/m/Y H:i') : '-'
            ], ';');
        }

        rewind($stream);
        $csvContent = stream_get_contents($stream);
        fclose($stream);

        return $response->withStringBody($csvContent);
    }
}
