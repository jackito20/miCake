<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Articles Controller
 *
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
use Cake\ORM\TableRegistry;

class ArticlesController extends AppController
{
    var $paginate = array('limit' =>5, 'order' => array('id'));
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        /*$articles = $this->paginate($this->Articles);

        $this->set(compact('articles'));*/
        
        /*$articles = $this->paginate($this->Articles);
        $this->set('articles', $articles);*/

        $articles = $this->Articles->find('all');
        $this->set([
            'articles' => $articles,
            '_serialize' => 'articles',
        ]);
        $this->RequestHandler->renderAs($this, 'json');
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);

        $this->set('article', $article);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $articlesTable = TableRegistry::get('Articles');
        $article = $articlesTable->newEntity();

        $article->title = $this->request->query['title'];
        $article->body = $this->request->query['body'];

        if ($articlesTable->save($article)) {
            // The $article entity contains the id now
            $id = $article->id;
            $this->set([
                'message' => 'Saved',
                'article' => $article,
                '_serialize' => ['message', 'article']
            ]);
        }
        
        $this->RequestHandler->renderAs($this, 'json');
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The article could not be saved. Please, try again.'));
        }
        $this->set(compact('article'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
