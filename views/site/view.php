<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Просмотр информации о файле '.$modelFile->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">

        <h3>Описание файла: <?=$modelFile->name?></h3>

        <?= DetailView::widget([
            'model' => $modelDescription,
            'attributes' => [
                'id',
                'file_id',
                [
                    'attribute' => 'file_id',
                    'label' => 'Имя файла',
                    'value' => $modelFile->name,
                ],
                'unique_tags',
                [
                    'attribute' => 'tags',
                    'value' => $modelDescription->tags,
                ],

                'created_at',
                [
                    'attribute' => 'status',
                    'value' => $modelDescription->status ? 'Да' : 'Нет',
                ],

            ],
        ]) ?>

</div>
