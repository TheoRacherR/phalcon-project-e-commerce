<?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class DeliveryController extends ControllerBase
{



        public function indexAction()
        {
        }




        public function searchAction()
        {
                $numberPage = $this->request->getQuery('page', 'int', 1);
                $parameters = Criteria::fromInput($this->di, 'Delivery', $_GET)->getParams();
                $parameters['order'] = "id";

                $paginator = new Model(
                        [
                                'model' => 'Delivery',
                                'parameters' => $parameters,
                                'limit' => 10,
                                'page' => $numberPage,
                        ]
                );

                $paginate = $paginator->paginate();

                if (0 === $paginate->getTotalItems()) {
                        $this->flash->notice("The search did not find any delivery");

                        $this->dispatcher->forward([
                                "controller" => "delivery",
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
                        $delivery = Delivery::findFirstByid($id);
                        if (!$delivery) {
                                $this->flash->error("delivery was not found");

                                $this->dispatcher->forward([
                                        'controller' => "delivery",
                                        'action' => 'index'
                                ]);

                                return;
                        }

                        $this->view->id = $delivery->id;

                        $this->tag->setDefault("id", $delivery->id);
                        $this->tag->setDefault("id_account", $delivery->id_account);
                        $this->tag->setDefault("status", $delivery->status);
                        $this->tag->setDefault("estimated_date", $delivery->estimated_date);
                        $this->tag->setDefault("delivery_at", $delivery->delivery_at);
                        $this->tag->setDefault("create_at", $delivery->create_at);
                        $this->tag->setDefault("update_at", $delivery->update_at);
                }
        }




        public function createAction()
        {
                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "delivery",
                                'action' => 'index'
                        ]);

                        return;
                }

                $delivery = new Delivery();
                $delivery->idAccount = $this->request->getPost("id_account", "int");
                $delivery->status = $this->request->getPost("status");
                $delivery->estimatedDate = $this->request->getPost("estimated_date");
                $delivery->deliveryAt = $this->request->getPost("delivery_at");
                $delivery->createAt = $this->request->getPost("create_at");
                $delivery->updateAt = $this->request->getPost("update_at");


                if (!$delivery->save()) {
                        foreach ($delivery->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "delivery",
                                'action' => 'new'
                        ]);

                        return;
                }

                $this->flash->success("delivery was created successfully");

                $this->dispatcher->forward([
                        'controller' => "delivery",
                        'action' => 'index'
                ]);
        }





        public function saveAction()
        {

                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "delivery",
                                'action' => 'index'
                        ]);

                        return;
                }

                $id = $this->request->getPost("id");
                $delivery = Delivery::findFirstByid($id);

                if (!$delivery) {
                        $this->flash->error("delivery does not exist " . $id);

                        $this->dispatcher->forward([
                                'controller' => "delivery",
                                'action' => 'index'
                        ]);

                        return;
                }

                $delivery->idAccount = $this->request->getPost("id_account", "int");
                $delivery->status = $this->request->getPost("status");
                $delivery->estimatedDate = $this->request->getPost("estimated_date");
                $delivery->deliveryAt = $this->request->getPost("delivery_at");
                $delivery->createAt = $this->request->getPost("create_at");
                $delivery->updateAt = $this->request->getPost("update_at");


                if (!$delivery->save()) {

                        foreach ($delivery->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "delivery",
                                'action' => 'edit',
                                'params' => [$delivery->id]
                        ]);

                        return;
                }

                $this->flash->success("delivery was updated successfully");

                $this->dispatcher->forward([
                        'controller' => "delivery",
                        'action' => 'index'
                ]);
        }






        public function deleteAction($id)
        {
                $delivery = Delivery::findFirstByid($id);
                if (!$delivery) {
                        $this->flash->error("delivery was not found");

                        $this->dispatcher->forward([
                                'controller' => "delivery",
                                'action' => 'index'
                        ]);

                        return;
                }

                if (!$delivery->delete()) {

                        foreach ($delivery->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "delivery",
                                'action' => 'search'
                        ]);

                        return;
                }

                $this->flash->success("delivery was deleted successfully");

                $this->dispatcher->forward([
                        'controller' => "product",
                        'action' => "index"
                ]);
        }
}
