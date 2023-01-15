        <?php

declare(strict_types=1);



use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class AccountController extends ControllerBase
{



        public function indexAction()
        {
        }




        public function searchAction()
        {
                $numberPage = $this->request->getQuery('page', 'int', 1);
                $parameters = Criteria::fromInput($this->di, 'Account', $_GET)->getParams();
                $parameters['order'] = "id";

                $paginator = new Model(
                        [
                                'model' => 'Account',
                                'parameters' => $parameters,
                                'limit' => 10,
                                'page' => $numberPage,
                        ]
                );

                $paginate = $paginator->paginate();

                if (0 === $paginate->getTotalItems()) {
                        $this->flash->notice("The search did not find any account");

                        $this->dispatcher->forward([
                                "controller" => "account",
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
                        $account = Account::findFirstByid($id);
                        if (!$account) {
                                $this->flash->error("account was not found");

                                $this->dispatcher->forward([
                                        'controller' => "account",
                                        'action' => 'index'
                                ]);

                                return;
                        }

                        $this->view->id = $account->id;

                        $this->tag->setDefault("id", $account->id);
                        $this->tag->setDefault("username", $account->username);
                        $this->tag->setDefault("password", $account->password);
                        $this->tag->setDefault("email", $account->email);
                        $this->tag->setDefault("phone", $account->phone);
                        $this->tag->setDefault("role", $account->role);
                        $this->tag->setDefault("address", $account->address);
                        $this->tag->setDefault("create_at", $account->create_at);
                        $this->tag->setDefault("update_at", $account->update_at);
                }
        }




        public function createAction()
        {
                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "account",
                                'action' => 'index'
                        ]);

                        return;
                }

                $account = new Account();
                $account->username = $this->request->getPost("username");
                $account->password = $this->request->getPost("password");
                $account->email = $this->request->getPost("email", "email");
                $account->phone = $this->request->getPost("phone");
                $account->role = $this->request->getPost("role", "int");
                $account->address = $this->request->getPost("address");
                $account->createAt = $this->request->getPost("create_at");
                $account->updateAt = $this->request->getPost("update_at");


                if (!$account->save()) {
                        foreach ($account->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "account",
                                'action' => 'new'
                        ]);

                        return;
                }

                $this->flash->success("account was created successfully");

                $this->dispatcher->forward([
                        'controller' => "account",
                        'action' => 'index'
                ]);
        }





        public function saveAction()
        {

                if (!$this->request->isPost()) {
                        $this->dispatcher->forward([
                                'controller' => "account",
                                'action' => 'index'
                        ]);

                        return;
                }

                $id = $this->request->getPost("id");
                $account = Account::findFirstByid($id);

                if (!$account) {
                        $this->flash->error("account does not exist " . $id);

                        $this->dispatcher->forward([
                                'controller' => "account",
                                'action' => 'index'
                        ]);

                        return;
                }

                $account->username = $this->request->getPost("username");
                $account->password = $this->request->getPost("password");
                $account->email = $this->request->getPost("email", "email");
                $account->phone = $this->request->getPost("phone");
                $account->role = $this->request->getPost("role", "int");
                $account->address = $this->request->getPost("address");
                $account->createAt = $this->request->getPost("create_at");
                $account->updateAt = $this->request->getPost("update_at");


                if (!$account->save()) {

                        foreach ($account->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "account",
                                'action' => 'edit',
                                'params' => [$account->id]
                        ]);

                        return;
                }

                $this->flash->success("account was updated successfully");

                $this->dispatcher->forward([
                        'controller' => "account",
                        'action' => 'index'
                ]);
        }






        public function deleteAction($id)
        {
                $account = Account::findFirstByid($id);
                if (!$account) {
                        $this->flash->error("account was not found");

                        $this->dispatcher->forward([
                                'controller' => "account",
                                'action' => 'index'
                        ]);

                        return;
                }

                if (!$account->delete()) {

                        foreach ($account->getMessages() as $message) {
                                $this->flash->error($message);
                        }

                        $this->dispatcher->forward([
                                'controller' => "account",
                                'action' => 'search'
                        ]);

                        return;
                }

                $this->flash->success("account was deleted successfully");

                $this->dispatcher->forward([
                        'controller' => "account",
                        'action' => "index"
                ]);
        }
}
