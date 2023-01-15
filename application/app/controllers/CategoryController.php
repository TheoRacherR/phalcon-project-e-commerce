<?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class CategoryController extends ControllerBase
{



        public function indexAction()
        {
        }




        public function searchAction()
        {
                $numberPage = $this->request->getQuery('page', 'int', 1);
                $parameters = Criteria::fromInput($this->di, 'Category', $_GET)->getParams();
                $parameters['order'] = "id";

                $paginator = new Model(
                        [
                                'model' => 'Category',
                                'parameters' => $parameters,
                                'limit' => 10,
                                'page' => $numberPage,
                        ]
                );

                $paginate = $paginator->paginate();

                if (0 === $paginate->getTotalItems()) {
                        $this->flash->notice("The search did not find any category");

                        $this->dispatcher->forward([
                                "controller" => "category",
                                "action" => "index"
                        ]);

                        return;
                }

                $this->view->page = $paginate;
        }




        public function newAction()
        {
        }






        public function editAction($id)
        {
                if (!$this->request->isPost()) {
                        $category = Category::findFirstByid($id);
                        if (!$category) {
                                $this->flash->error("category was not found");

                                $this->dispatcher->forward([
                                        'controller' => "category",
                                        'action' => 'index'
                                ]);

                                return;
                        }

                        $this->view->id = $category->id;

                        $this->tag->setDefault("id", $category->id);
                        $this->tag->setDefault("child_category", $category->child_category);
                        $this->tag->setDefault("parent_category", $category->parent_category);
                        $this->tag->setDefault("name", $category->name);
                        $this->tag->setDefault("create_at", $category->create_at);
                        $this->tag->setDefault("update_at", $category->update_at);
                }
        }




        public function createAction()
        {
                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "category",
                                'action' => 'index'
                        ]);

                        return;
                }

                $category = new Category();
                $category->childCategory = $this->request->getPost("child_category", "int");
                $category->parentCategory = $this->request->getPost("parent_category", "int");
                $category->name = $this->request->getPost("name");
                $category->createAt = $this->request->getPost("create_at");
                $category->updateAt = $this->request->getPost("update_at");


                if (!$category->save()) {
                        foreach ($category->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "category",
                                'action' => 'new'
                        ]);

                        return;
                }

                $this->flash->success("category was created successfully");

                $this->dispatcher->forward([
                        'controller' => "category",
                        'action' => 'index'
                ]);
        }





        public function saveAction()
        {

                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "category",
                                'action' => 'index'
                        ]);

                        return;
                }

                $id = $this->request->getPost("id");
                $category = Category::findFirstByid($id);

                if (!$category) {
                        $this->flash->error("category does not exist " . $id);

                        $this->dispatcher->forward([
                                'controller' => "category",
                                'action' => 'index'
                        ]);

                        return;
                }

                $category->childCategory = $this->request->getPost("child_category", "int");
                $category->parentCategory = $this->request->getPost("parent_category", "int");
                $category->name = $this->request->getPost("name");
                $category->createAt = $this->request->getPost("create_at");
                $category->updateAt = $this->request->getPost("update_at");


                if (!$category->save()) {

                        foreach ($category->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "category",
                                'action' => 'edit',
                                'params' => [$category->id]
                        ]);

                        return;
                }

                $this->flash->success("category was updated successfully");

                $this->dispatcher->forward([
                        'controller' => "category",
                        'action' => 'index'
                ]);
        }






        public function deleteAction($id)
        {
                $category = Category::findFirstByid($id);
                if (!$category) {
                        $this->flash->error("category was not found");

                        $this->dispatcher->forward([
                                'controller' => "category",
                                'action' => 'index'
                        ]);

                        return;
                }

                if (!$category->delete()) {

                        foreach ($category->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "category",
                                'action' => 'search'
                        ]);

                        return;
                }

                $this->flash->success("category was deleted successfully");

                $this->dispatcher->forward([
                        'controller' => "category",
                        'action' => "index"
                ]);
        }
}
