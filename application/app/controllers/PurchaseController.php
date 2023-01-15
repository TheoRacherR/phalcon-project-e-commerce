<?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class PurchaseController extends ControllerBase
{



        public function indexAction()
        {
        }

        public function testAction()
        {
                $account = 'accountant';
                $this->view->setVar("ownerNewPurchase", $account);  
        }




        public function searchAction()
        {
                $numberPage = $this->request->getQuery('page', 'int', 1);
                $parameters = Criteria::fromInput($this->di, 'Purchase', $_GET)->getParams();
                $parameters['order'] = "id";

                $paginator = new Model(
                        [
                                'model' => 'Purchase',
                                'parameters' => $parameters,
                                'limit' => 10,
                                'page' => $numberPage,
                        ]
                );

                $paginate = $paginator->paginate();

                if (0 === $paginate->getTotalItems()) {
                        $this->flash->notice("The search did not find any purchase");

                        $this->dispatcher->forward([
                                "controller" => "purchase",
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
                        $purchase = Purchase::findFirstByid($id);
                        if (!$purchase) {
                                $this->flash->error("purchase was not found");

                                $this->dispatcher->forward([
                                        'controller' => "purchase",
                                        'action' => 'index'
                                ]);

                                return;
                        }

                        $this->view->id = $purchase->id;

                        $this->tag->setDefault("id", $purchase->id);
                        $this->tag->setDefault("id_account", $purchase->id_account);
                        $this->tag->setDefault("total_price", $purchase->total_price);
                        $this->tag->setDefault("purchase_at", $purchase->purchase_at);
                        $this->tag->setDefault("create_at", $purchase->create_at);
                        $this->tag->setDefault("update_at", $purchase->update_at);
                }
        }




        public function createAction()
        {
                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "purchase",
                                'action' => 'index'
                        ]);

                        return;
                }

                $purchase = new Purchase();
                $purchase->idAccount = $this->request->getPost("id_account", "int");
                $purchase->totalPrice = $this->request->getPost("total_price", "int");
                $purchase->purchaseAt = $this->request->getPost("purchase_at");
                $purchase->createAt = $this->request->getPost("create_at");
                $purchase->updateAt = $this->request->getPost("update_at");


                if (!$purchase->save()) {
                        foreach ($purchase->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "purchase",
                                'action' => 'new'
                        ]);

                        return;
                }

                $this->flash->success("purchase was created successfully");

                $this->dispatcher->forward([
                        'controller' => "purchase",
                        'action' => 'index'
                ]);
        }





        public function saveAction()
        {

                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "purchase",
                                'action' => 'index'
                        ]);

                        return;
                }

                $id = $this->request->getPost("id");
                $purchase = Purchase::findFirstByid($id);

                if (!$purchase) {
                        $this->flash->error("purchase does not exist " . $id);

                        $this->dispatcher->forward([
                                'controller' => "purchase",
                                'action' => 'index'
                        ]);

                        return;
                }

                $purchase->idAccount = $this->request->getPost("id_account", "int");
                $purchase->totalPrice = $this->request->getPost("total_price", "int");
                $purchase->purchaseAt = $this->request->getPost("purchase_at");
                $purchase->createAt = $this->request->getPost("create_at");
                $purchase->updateAt = $this->request->getPost("update_at");


                if (!$purchase->save()) {

                        foreach ($purchase->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "purchase",
                                'action' => 'edit',
                                'params' => [$purchase->id]
                        ]);

                        return;
                }

                $this->flash->success("purchase was updated successfully");

                $this->dispatcher->forward([
                        'controller' => "purchase",
                        'action' => 'index'
                ]);
        }






        public function deleteAction($id)
        {
                $purchase = Purchase::findFirstByid($id);
                if (!$purchase) {
                        $this->flash->error("purchase was not found");

                        $this->dispatcher->forward([
                                'controller' => "purchase",
                                'action' => 'index'
                        ]);

                        return;
                }

                if (!$purchase->delete()) {

                        foreach ($purchase->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "purchase",
                                'action' => 'search'
                        ]);

                        return;
                }

                $this->flash->success("purchase was deleted successfully");

                $this->dispatcher->forward([
                        'controller' => "purchase",
                        'action' => "index"
                ]);
        }
}
