<?php
namespace controllers;

use db\DatabaseException;
use models\ProfileModel;
use renderers\Renderer;
use forms\fields\EmailField;
use forms\fields\InputField;
use forms\fields\PhoneField;
use forms\fields\DateField;
use forms\fields\SubmitField;
use forms\Form;
use forms\validators\DateValidator;
use forms\validators\EmailValidator;
use forms\validators\MaxLengthValidator;
use forms\validators\RequiredValidator;

/**
 * Class ProfileController
 *
 * Controller for profile page
 *
 * @package controllers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class ProfileController extends BaseController {
    /**
     * @var ProfileModel $profileModel Profile model instance
     */
    private $profileModel;

    /**
     * Public constructor
     */
    public function __construct() {
        parent::__construct();

        try {
            $this->profileModel = new ProfileModel();
        }
        catch (DatabaseException $e) {
            (new ErrorsController())->error503();
        }
    }

    /**
     * Default controller command
     * Shows and handles user's profile form
     */
    public function index() {
        $this->auth->isAuthorized() ? $userId = $this->auth->getUserId() : $this->goHome();

        $form = new Form();

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

        $form->addField($firstNameField)
             ->addField($lastNameField)
             ->addField($emailField)
             ->addField($phoneField)
             ->addField($birthDateField)
             ->addField(new SubmitField('Save'));

        try {
            if (!empty($_POST)) {
                $form->populate($_POST);

                if ($form->validate()->isValid()) {
                    $values = array_merge($_POST, ['id' => $userId]);
                    $this->profileModel->update($values);
                    $this->redirect('/profile/');
                }
            }
            else {
                $user = $this->profileModel->get($userId);

                if (is_null($user)) {
                    $this->logout();
                }

                $fields = [
                    'first_name' => $user->firstName,
                    'last_name' => $user->lastName,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'birth_date' => $user->birthDate
                ];

                $this->profileModel->convertDates($fields, ['birth_date']);

                $form->populate($fields);

            }

            $formString = $form->render();

            Renderer::getInstance()->render('profile', ['form' => $formString]);
        }
        catch (DatabaseException $e) {
            (new ErrorsController())->error503();
        }
    }

    /**
     * Makes logout
     */
    public function logout() {
        $this->auth->logout();
        $this->goHome();
    }
}