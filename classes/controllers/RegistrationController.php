<?php
namespace controllers;

use db\DatabaseException;
use forms\fields\EmailField;
use forms\fields\InputField;
use forms\fields\PhoneField;
use forms\fields\DateField;
use forms\fields\PasswordField;
use forms\fields\SubmitField;
use forms\Form;
use forms\validators\DateValidator;
use forms\validators\EmailValidator;
use forms\validators\EqualToValidator;
use forms\validators\MinLengthValidator;
use forms\validators\MaxLengthValidator;
use forms\validators\PasswordValidator;
use forms\validators\RequiredValidator;
use models\ModelException;
use models\ProfileModel;
use renderers\Renderer;

/**
 * Class RegistrationController
 *
 * Controller for registration page
 *
 * @package controllers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class RegistrationController extends BaseController {
    /**
     * Default controller command
     * Shows and handles registration form
     */
    public function index() {
        if ($this->auth->isAuthorized()) {
            $this->redirect('/profile/');
        }

        $form = new Form();

        // Login field
        $loginField = new InputField('login', 'Login');
        $loginField->addValidator(new RequiredValidator())
                   ->addValidator(new MinLengthValidator(3))
                   ->addValidator(new MaxLengthValidator(20));

        // Password field
        $passwordField = new PasswordField('password', 'Password');
        $passwordField->addValidator(new RequiredValidator())
                      ->addValidator(new PasswordValidator());

        // Repeat password field
        $repeatPasswordField = new PasswordField('password2', 'Repeat password');
        $repeatPasswordField->addValidator(new RequiredValidator())
                            ->addValidator(new EqualToValidator($passwordField));

        // First name field
        $firstNameField = new InputField('first_name', 'First name');
        $firstNameField->addValidator(new RequiredValidator());

        // Last name field
        $lastNameField = new InputField('last_name', 'Last name');
        $lastNameField->addValidator(new RequiredValidator());

        // E-mail field
        $emailField = new EmailField('email', 'E-mail');
        $emailField->addValidator(new EmailValidator());

        // Phone field
        $phoneField = new PhoneField('phone', 'Phone');
        $phoneField->addValidator(new MaxLengthValidator(20));

        // Birth date field
        $birthDateField = new DateField('birth_date', 'Birth date');
        $birthDateField->addValidator(new DateValidator());

        $form->addField($loginField)
             ->addField($passwordField)
             ->addField($repeatPasswordField)
             ->addField($firstNameField)
             ->addField($lastNameField)
             ->addField($emailField)
             ->addField($phoneField)
             ->addField($birthDateField)
             ->addField(new SubmitField('Register'));

        if (!empty($_POST)) {
            $form->populate($_POST);

            if ($form->validate()->isValid()) {
                try {
                    (new ProfileModel())->create($_POST);
                    $this->redirect('/registration/ok/');
                }
                catch (ModelException $e) {
                    $form->getField('login')->setError($e->getMessage());
                }
                catch (DatabaseException $e) {
                    (new ErrorsController())->error503();
                }
            }
        }

        $formString = $form->render();

        Renderer::getInstance()->render('registration', ['form' => $formString]);
    }

    /**
     * Shows registration confirmation
     */
    public function ok() {
        if ($this->auth->isAuthorized()) {
            $this->redirect('/profile/');
        }

        Renderer::getInstance()->render('registration_ok');
    }
}