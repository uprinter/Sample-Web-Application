<?php
namespace controllers;

use db\DatabaseException;
use models\FilesModel;
use models\ModelException;
use renderers\Renderer;
use forms\Form;
use forms\fields\FileField;
use forms\fields\SubmitField;

/**
 * Class FilesController
 *
 * Controller for working with files
 *
 * @package controllers
 * @author Yury Kosharovskiy <kosharovskiy@gmail.com>
 */
class FilesController extends BaseController {
    /**
     * @var FilesModel $filesModel Files model instance
     */
    private $filesModel;

    /**
     * Public constructor
     */
    public function __construct() {
        parent::__construct();
        $this->filesModel = new FilesModel();
    }

    /**
     * Default controller command
     * Shows list of user's files
     */
    public function index() {
        $this->auth->isAuthorized() ? $userId = $this->auth->getUserId() : $this->goHome();

        try {
            $files = $this->filesModel->getList($userId);
            $canAddFile = $this->filesModel->canAddFiles($userId);
        }
        catch (DatabaseException $e) {
            (new ErrorsController())->error503();
        }

        Renderer::getInstance()->render('files', ['files' => $files, 'canAddFile' => $canAddFile]);
    }

    /**
     * Handles file uploading
     */
    public function upload() {
        $this->auth->isAuthorized() ? $userId = $this->auth->getUserId() : $this->goHome();

        $data = [];

        $form = new Form();
        $form->addField(new FileField('file', 'File to upload'))
             ->addField(new SubmitField('Upload'));

        if (isset($_FILES['file'])) {
            try {
                $this->filesModel->create($_FILES['file'], $userId);
                $this->redirect('/files/');
            }
            catch (DatabaseException $e) {
                (new ErrorsController())->error503();
            }
            catch (ModelException $e) {
                $form->getField('file')->setError($e->getMessage());
            }
        }

        $formString = $form->render();

        Renderer::getInstance()->render('upload_file', ['form' => $formString]);
    }

    /**
     * Handles file downloading
     */
    public function download() {
        $this->auth->isAuthorized() ? $userId = $this->auth->getUserId() : $this->goHome();

        $params = $this->getParams();

        if (isset($params[0])) {
            try {
                $this->filesModel->sendFile($params[0], $userId);
            }
            catch (DatabaseException $e) {
                (new ErrorsController())->error503();
            }
            catch (ModelException $e) {
                (new ErrorsController())->error503();
            }
        }
        else {
            $this->redirect('/files/');
        }
    }

    /**
     * Handles file removing
     */
    public function remove() {
        $this->auth->isAuthorized() ? $userId = $this->auth->getUserId() : $this->goHome();

        $params = $this->getParams();

        if (isset($params[0])) {
            try {
                $this->filesModel->removeFile($params[0], $userId);
                $this->redirect('/files/');
            }
            catch (DatabaseException $e) {
                (new ErrorsController())->error503();
            }
            catch (ModelException $e) {
                (new ErrorsController())->error503();
            }
        }
        else {
            $this->redirect('/files/');
        }
    }
}