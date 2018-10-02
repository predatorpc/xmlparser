<?php

use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */

$this->title = 'XML Parser';
?>
<div class="site-index">
    <div class="body-content">

    <table width="100%" height="100%">
        <tr>
            <td>

                <h3>Пожалуйста выберите файл и нажмите загрузить</h3>

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

                <?= $form->field($model, 'xmlfile')->fileInput()->label('') ?>

                <button>Submit</button>

                <?php ActiveForm::end() ?>


             </td>
        </tr>
        <tr>
            <td>
                <h3>Список ранее загруженных файлов</h3>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,

                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        [
                            'attribute'=>'name',
                            'label' => 'Имя файла',
                            'format'=>'raw',
                            'value' => function ($data, $url, $model) {
                                return Html::a($data['name'], "/site/view/".$data['id']);
                            },
                        ],

                        'created_at',
                        [
                            'attribute'=>'status',
                            'label' => 'Активность',
                            'format'=>'raw',
                            'value' => function ($data, $url, $model) {
                                return $data['status'] ? 'Да' : 'Нет';
                            },
                        ],

                    ],
                ]);
                ?>

                <h5>Файлов с количеством уникальных тэгов более 20 = <?=$counter?> шт.</h5>
            </td>
        </tr>
    </table>

    </div>
</div>


