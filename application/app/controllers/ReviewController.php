<?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class ReviewController extends ControllerBase
{



        public function indexAction()
        {
        }




        public function searchAction()
        {
                $numberPage = $this->request->getQuery('page', 'int', 1);
                $parameters = Criteria::fromInput($this->di, 'Review', $_GET)->getParams();
                $parameters['order'] = "id";

                $paginator = new Model(
                        [
                                'model' => 'Review',
                                'parameters' => $parameters,
                                'limit' => 10,
                                'page' => $numberPage,
                        ]
                );

                $paginate = $paginator->paginate();

                if (0 === $paginate->getTotalItems()) {
                        $this->flash->notice("The search did not find any review");

                        $this->dispatcher->forward([
                                "controller" => "review",
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
                        $review = Review::findFirstByid($id);
                        if (!$review) {
                                $this->flash->error("review was not found");

                                $this->dispatcher->forward([
                                        'controller' => "review",
                                        'action' => 'index'
                                ]);

                                return;
                        }

                        $this->view->id = $review->id;

                        $this->tag->setDefault("id", $review->id);
                        $this->tag->setDefault("id_product", $review->id_product);
                        $this->tag->setDefault("id_account", $review->id_account);
                        $this->tag->setDefault("comment", $review->comment);
                        $this->tag->setDefault("nb_star", $review->nb_star);
                }
        }




        public function createAction()
        {
                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "review",
                                'action' => 'index'
                        ]);

                        return;
                }

                $review = new Review();
                $review->idProduct = $this->request->getPost("id_product", "int");
                $review->idAccount = $this->request->getPost("id_account", "int");
                $review->comment = $this->request->getPost("comment");
                $review->nbStar = $this->request->getPost("nb_star", "int");


                if (!$review->save()) {
                        foreach ($review->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "review",
                                'action' => 'new'
                        ]);

                        return;
                }

                $this->flash->success("review was created successfully");

                $this->dispatcher->forward([
                        'controller' => "review",
                        'action' => 'index'
                ]);
        }





        public function saveAction()
        {

                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "review",
                                'action' => 'index'
                        ]);

                        return;
                }

                $id = $this->request->getPost("id");
                $review = Review::findFirstByid($id);

                if (!$review) {
                        $this->flash->error("review does not exist " . $id);

                        $this->dispatcher->forward([
                                'controller' => "review",
                                'action' => 'index'
                        ]);

                        return;
                }

                $review->idProduct = $this->request->getPost("id_product", "int");
                $review->idAccount = $this->request->getPost("id_account", "int");
                $review->comment = $this->request->getPost("comment");
                $review->nbStar = $this->request->getPost("nb_star", "int");


                if (!$review->save()) {

                        foreach ($review->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "review",
                                'action' => 'edit',
                                'params' => [$review->id]
                        ]);

                        return;
                }

                $this->flash->success("review was updated successfully");

                $this->dispatcher->forward([
                        'controller' => "review",
                        'action' => 'index'
                ]);
        }






        public function deleteAction($id)
        {
                $review = Review::findFirstByid($id);
                if (!$review) {
                        $this->flash->error("review was not found");

                        $this->dispatcher->forward([
                                'controller' => "review",
                                'action' => 'index'
                        ]);

                        return;
                }

                if (!$review->delete()) {

                        foreach ($review->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "review",
                                'action' => 'search'
                        ]);

                        return;
                }

                $this->flash->success("review was deleted successfully");

                $this->dispatcher->forward([
                        'controller' => "review",
                        'action' => "index"
                ]);
        }
}
