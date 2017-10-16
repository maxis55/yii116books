<?php

class BookController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create'),
                'users'=>array('@'),
            ),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update'),
				'users'=>User::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Book;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Book']))
		{
            $newAuthors=$_POST['Book']['authors'];
            unset($_POST['Book']['authors']);
			$model->attributes=$_POST['Book'];
            $uploadedFile = CUploadedFile::getInstance($model, "img_path");
            if($uploadedFile!==null){
                $fileName = "image-prefix-" . time() . "." . $uploadedFile->getExtensionName();
                $model->img_path = $fileName;
                $fullPath =  'images/' . $fileName;
                $uploadedFile->saveAs($fullPath);
            }else
                $model->img_path=null;

            if($model->published!=null)
                $model->published = date('Y-m-d',strtotime($model->published));
            else
                $model->published=null;
            if($model->save()){
			    if(isset($newAuthors)&&!empty($newAuthors)){
                    foreach ($newAuthors as $author){
                        $bookAuthor= new BookAuthor();
                        $bookAuthor->author_id=$author;
                        $bookAuthor->book_id=$model->id;
                        $bookAuthor->save();
                    }
                }

                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Book']))
		{

            $hasImg=false;
            $oldPath='';
            $oldAuthors=$model->authors;
            $newAuthors=$_POST['Book']['authors'];
            unset($_POST['Book']['authors']);
            if($model->img_path!=null){
                $hasImg=true;
                $oldPath=$model->img_path;
            }
			$model->attributes=$_POST['Book'];
            if($model->published!=null)
                $model->published = date('Y-m-d',strtotime($model->published));
            else
                $model->published=null;
            $uploadedFile = CUploadedFile::getInstance($model, "img_path");
            if($uploadedFile != null) {
                if($hasImg&&file_exists('images/' . $oldPath))
                    unlink('images/' . $oldPath);
                $fileName = "image-prefix-" . time() . "." . $uploadedFile->getExtensionName();
                $model->img_path = $fileName;
                $fullPath = 'images/' . $model->img_path;
                $uploadedFile->saveAs($fullPath);
            }else
                $model->img_path=$oldPath;

			if($model->save()){
                if(isset($_POST['Book']['authors'])){
                    $oldArr=array();
                    foreach ($oldAuthors as $author){
                        $oldArr[]=$author->getId();
                    }
                    $authorsToDelete=implode(", ",array_diff($oldArr, $newAuthors));
                    $authorsToAdd=array_diff($newAuthors, $oldArr);

                    foreach ($authorsToAdd as $author){
                        $bookAuthor= new BookAuthor();
                        $bookAuthor->author_id=$author;
                        $bookAuthor->book_id=$model->id;
                        $bookAuthor->save();
                    }
                    if(!empty($authorsToDelete)){
                        $criteria=new CDbCriteria;
                        $criteria->addCondition("author_id in (:authorsToDelete) and book_id=:model_id",array(':authorsToDelete'=>$authorsToDelete,':model_id'=>$model->id));
                        BookAuthor::model()->deleteAll($criteria);
                    }

                }

                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
	    $model=$this->loadModel($id);
        if($model->img_path!=null){
            if (file_exists('images/' . $model->img_path))
            unlink('images/' . $model->img_path);
        }
        $model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Book');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Book('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Book']))
			$model->attributes=$_GET['Book'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Book the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Book::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Book $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='book-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
