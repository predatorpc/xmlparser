<?php

namespace app\controllers;

use app\models\Files;
use app\models\FilesDescriptions;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadForm;
use yii\web\UploadedFile;
use app\models\FilesSearch;
use light\yii2\XmlParser;
use yii\helpers\VarDumper;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public static function getArrayKeysFlat($array) {
        if(!isset($keys) || !is_array($keys)) {
            $keys = array();
        }
        foreach($array as $key => $value) {
            $keys[] = $key;
            if(is_array($value)) {
                $keys = array_merge($keys,self::getArrayKeysFlat($value));
            }
        }
        return $keys;
    }


    public static function getOffNumericKeys($array)
    {
        $released = [];
        foreach ($array as $item)
        {
            if(!is_numeric($item))
                $released[] = $item;
        }
        return $released;
    }

    public static function foo($item, $key)
    {
        echo $item." - ".$key."<br>";
    }

    public function actionIndex()
    {
        $counter = FilesDescriptions::find()
            ->where('unique_tags >  20')
            ->count();

        $searchModel = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->xmlfile = UploadedFile::getInstance($model, 'xmlfile'); //получаем данные модели
            $path = $model->upload();
            if (!empty($path)) {
                //Вообщем тут надо доработать, не все теги считает

                $xml = new XmlParser(); // Создаем парсер
                $fileData = file_get_contents($path, true); // получаем данные из файла
                $outData = $xml->parse($fileData,''); // получаем данные от парсера

                //var_dump($outData);
                //array_walk_recursive($outData, 'self::foo');

                $flatKeys= self::getArrayKeysFlat($outData); // Делаем плоскими ключи массива ассоциативного
                $flatKeysWithoutNumbers = self::getOffNumericKeys($flatKeys); // убираем номера ключей
                $uniqueKeys = array_unique($flatKeysWithoutNumbers); //делаем уникальный массив для подсчета
                $finalCounters = []; // счетчики для тэгов, потом запишем в базу

                //считаем тэги
                foreach ($uniqueKeys as $key) {
                    foreach ($flatKeys as $item) {
                        if($key == $item) {
                            if(empty($finalCounters[$key])){ //если пустой элемент - создаем
                                $finalCounters[$key]=0;
                            }
                            $finalCounters[$key]++;
                        }
                    }
                }

                $fileToPutIntoDB = new Files(); // создаем новую модель
                $fileToPutIntoDB->name = $model->xmlfile->baseName . '.' . $model->xmlfile->extension; // имя файла
                $fileToPutIntoDB->status = 1; // статус активен
                if(!$fileToPutIntoDB->save()) { //сохраняем запись в базу
                    print_arr($fileToPutIntoDB->errors);die();
                }

                ksort($finalCounters,SORT_STRING); //сортируем по названию ключей в алфавитном порядке

                $fileDescription = new FilesDescriptions();
                $fileDescription->file_id =$fileToPutIntoDB->id;
                $fileDescription->unique_tags = count($finalCounters);
                $fileDescription->tags = VarDumper::export($finalCounters);
                $fileDescription->status = 1;

                if(!$fileDescription->save()) { //сохраняем запись в базу
                    print_arr($fileDescription->errors);die();
                }

                //удаляем после использования файл
                unlink($path);

                //рендерим наш экшен
                return $this->render('index', [
                    'model' => $model,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'counter' => $counter,
                ]);
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'counter' => $counter,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionView($id = 0)
    {
        $id = Yii::$app->request->get('id');

        if (!empty($id)){

            $modelDescription = FilesDescriptions::find()
                ->where([
                    'file_id' => $id,
                    'status' => 1
                ])
                ->one();

            $modelFile = Files::find()
                ->where([
                    'id' => $id,
                    'status' => 1
                ])
                ->one();

            if(!empty($modelFile) && !empty($modelDescription)) {
                return $this->render('view', [
                    'id' => $id,
                    'modelFile' => $modelFile,
                    'modelDescription' => $modelDescription,
                ]);
            }
            else
            {
                return $this->render('error', [
                    'name' => 'Ошибка',
                    'message' => 'Не могу найти описание с таким ID',
                ]);
            }
        }
        else{
            return $this->render('error', [
                'name' => 'Ошибка',
                'message' => 'Не могу найти описание с таким ID',
            ]);
        }
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
