<?php
namespace controllers;

use authorization\LoginNotFoundException;
use authorization\IncorrectPasswordException;
use renderers\Renderer;
use forms\Form;
use forms\fields\InputField;
use forms\fields\PasswordField;
use forms\fields\SubmitField;
use forms\validators\RequiredValidator;

/**
 * Class IndexController
 *
 * Controller for main page
 *
 * @package controllers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class IndexController extends BaseController {
    /**
     * Default controller command
     * Shows and handles authorization form
     */
    public function index() {
        if ($this->auth->isAuthorized()) {
            $this->redirect('/profile/');
        }

        $form = new Form();

        // Login field
        $loginField = new InputField('login', 'Login');
        $loginField->addValidator(new RequiredValidator());

        // Password field
        $passwordField = new PasswordField('password', 'Password');
        $passwordField->addValidator(new RequiredValidator());

        $form->addField($loginField)
             ->addField($passwordField)
             ->addField(new SubmitField('Login'));

        if (!empty($_POST)) {
            $form->populate($_POST);

            if ($form->validate()->isValid()) {
                try {
                    $this->auth->login($_POST['login'], $_POST['password'],
                        (isset($_POST['remember']) ? $_POST['remember'] : false));

                    $this->redirect('/profile/');
                }
                catch (LoginNotFoundException $e) {
                    $form->getField('login')->setError($e->getMessage());
                }
                catch (IncorrectPasswordException $e) {
                    $form->getField('password')->setError($e->getMessage());
                }
                catch (Exception $e) {
                    (new ErrorsController())->error503();
                }
            }
        }

        $formString = $form->render();

        Renderer::getInstance()->render('index', ['form' => $formString]);
    }
}