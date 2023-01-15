<?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class ReturnedController extends ControllerBase
{



        public function indexAction()
        {
        }




        public function searchAction()
        {
                $numberPage = $this->request->getQuery('page', 'int', 1);
                $parameters = Criteria::fromInput($this->di, 'Returned', $_GET)->getParams();
                $parameters['order'] = "id";

                $paginator = new Model(
                        [
                                'model' => 'Returned',
                                'parameters' => $parameters,
                                'limit' => 10,
                                'page' => $numberPage,
                        ]
                );

                $paginate = $paginator->paginate();

                if (0 === $paginate->getTotalItems()) {
                        $this->flash->notice("The search did not find any returned");

                        $this->dispatcher->forward([
                                "controller" => "returned",
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
                        $returned = Returned::findFirstByid($id);
                        if (!$returned) {
                                $this->flash->error("returned was not found");

                                $this->dispatcher->forward([
                                        'controller' => "returned",
                                        'action' => 'index'
                                ]);

                                return;
                        }

                        $this->view->id = $returned->id;

                        $this->tag->setDefault("id", $returned->id);
                        $this->tag->setDefault("id_account", $returned->id_account);
                        $this->tag->setDefault("create_at", $returned->create_at);
                        $this->tag->setDefault("update_at", $returned->update_at);
                }
        }




        public function createAction()
        {
                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "returned",
                                'action' => 'index'
                        ]);

                        return;
                }

                $returned = new Returned();
                $returned->idAccount = $this->request->getPost("id_account", "int");
                $returned->createAt = $this->request->getPost("create_at");
                $returned->updateAt = $this->request->getPost("update_at");


                if (!$returned->save()) {
                        foreach ($returned->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "returned",
                                'action' => 'new'
                        ]);

                        return;
                }

                $this->flash->success("returned was created successfully");

                $this->dispatcher->forward([
                        'controller' => "returned",
                        'action' => 'index'
                ]);
        }





        public function saveAction()
        {

                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "returned",
                                'action' => 'index'
                        ]);

                        return;
                }

                $id = $this->request->getPost("id");
                $returned = Returned::findFirstByid($id);

                if (!$returned) {
                        $this->flash->error("returned does not exist " . $id);

                        $this->dispatcher->forward([
                                'controller' => "returned",
                                'action' => 'index'
                        ]);

                        return;
                }

                $returned->idAccount = $this->request->getPost("id_account", "int");
                $returned->createAt = $this->request->getPost("create_at");
                $returned->updateAt = $this->request->getPost("update_at");


                if (!$returned->save()) {

                        foreach ($returned->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "returned",
                                'action' => 'edit',
                                'params' => [$returned->id]
                        ]);

                        return;
                }

                $this->flash->success("returned was updated successfully");

                $this->dispatcher->forward([
                        'controller' => "returned",
                        'action' => 'index'
                ]);
        }






        public function deleteAction($id)
        {
                $returned = Returned::findFirstByid($id);
                if (!$returned) {
                        $this->flash->error("returned was not found");

                        $this->dispatcher->forward([
                                'controller' => "returned",
                                'action' => 'index'
                        ]);

                        return;
                }

                if (!$returned->delete()) {

                        foreach ($returned->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "returned",
                                'action' => 'search'
                        ]);

                        return;
                }

                $this->flash->success("returned was deleted successfully");

                $this->dispatcher->forward([
                        'controller' => "returned",
                        'action' => "index"
                ]);
        }
}
