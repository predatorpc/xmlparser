<?php

namespace app\controllers;

use Yii;
use app\models\FilesDescriptions;
use app\models\FilesDescriptionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FilesDescriptionsController implements the CRUD actions for FilesDescriptions model.
 */
class FilesDescriptionsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FilesDescriptions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FilesDescriptionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FilesDescriptions model.
     * @param integer $id
     * @param integer $file_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $file_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $file_id),
        ]);
    }

    /**
     * Creates a new FilesDescriptions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FilesDescriptions();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'file_id' => $model->file_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FilesDescriptions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $file_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $file_id)
    {
        $model = $this->findModel($id, $file_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'file_id' => $model->file_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FilesDescriptions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $file_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $file_id)
    {
        $this->findModel($id, $file_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FilesDescriptions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $file_id
     * @return FilesDescriptions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $file_id)
    {
        if (($model = FilesDescriptions::findOne(['id' => $id, 'file_id' => $file_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
