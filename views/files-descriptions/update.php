<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilesDescriptions */

$this->title = 'Update Files Descriptions: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Files Descriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'file_id' => $model->file_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="files-descriptions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
