<?php

class TemplatemasterController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionSetTemplate($lng,$file)
	{
		Yii::app()->session['prefferd_language']=$lng;
		$this->renderPartial($file);
	}
	
	public function actioncreateUser()
	{
		$this->renderPartial('createuser');
	}
}