<?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class CartController extends ControllerBase
{



        public function indexAction()
        {
        }




        public function searchAction()
        {
                $numberPage = $this->request->getQuery('page', 'int', 1);
                $parameters = Criteria::fromInput($this->di, 'Cart', $_GET)->getParams();
                $parameters['order'] = "id";

                $paginator = new Model(
                        [
                                'model' => 'Cart',
                                'parameters' => $parameters,
                                'limit' => 10,
                                'page' => $numberPage,
                        ]
                );

                $paginate = $paginator->paginate();

                if (0 === $paginate->getTotalItems()) {
                        $this->flash->notice("The search did not find any cart");

                        $this->dispatcher->forward([
                                "controller" => "cart",
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
                        $cart = Cart::findFirstByid($id);
                        if (!$cart) {
                                $this->flash->error("cart was not found");

                                $this->dispatcher->forward([
                                        'controller' => "cart",
                                        'action' => 'index'
                                ]);

                                return;
                        }

                        $this->view->id = $cart->id;

                        $this->tag->setDefault("id", $cart->id);
                        $this->tag->setDefault("create_at", $cart->create_at);
                        $this->tag->setDefault("update_at", $cart->update_at);
                }
        }




        public function createAction()
        {
                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "cart",
                                'action' => 'index'
                        ]);

                        return;
                }

                $cart = new Cart();
                $cart->createAt = $this->request->getPost("create_at");
                $cart->updateAt = $this->request->getPost("update_at");


                if (!$cart->save()) {
                        foreach ($cart->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "cart",
                                'action' => 'new'
                        ]);

                        return;
                }

                $this->flash->success("cart was created successfully");

                $this->dispatcher->forward([
                        'controller' => "cart",
                        'action' => 'index'
                ]);
        }





        public function saveAction()
        {

                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "cart",
                                'action' => 'index'
                        ]);

                        return;
                }

                $id = $this->request->getPost("id");
                $cart = Cart::findFirstByid($id);

                if (!$cart) {
                        $this->flash->error("cart does not exist " . $id);

                        $this->dispatcher->forward([
                                'controller' => "cart",
                                'action' => 'index'
                        ]);

                        return;
                }

                $cart->createAt = $this->request->getPost("create_at");
                $cart->updateAt = $this->request->getPost("update_at");


                if (!$cart->save()) {

                        foreach ($cart->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "cart",
                                'action' => 'edit',
                                'params' => [$cart->id]
                        ]);

                        return;
                }

                $this->flash->success("cart was updated successfully");

                $this->dispatcher->forward([
                        'controller' => "cart",
                        'action' => 'index'
                ]);
        }






        public function deleteAction($id)
        {
                $cart = Cart::findFirstByid($id);
                if (!$cart) {
                        $this->flash->error("cart was not found");

                        $this->dispatcher->forward([
                                'controller' => "cart",
                                'action' => 'index'
                        ]);

                        return;
                }

                if (!$cart->delete()) {

                        foreach ($cart->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "cart",
                                'action' => 'search'
                        ]);

                        return;
                }

                $this->flash->success("cart was deleted successfully");

                $this->dispatcher->forward([
                        'controller' => "cart",
                        'action' => "index"
                ]);
        }
}
