<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FilesDescriptions */

$this->title = 'Create Files Descriptions';
$this->params['breadcrumbs'][] = ['label' => 'Files Descriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="files-descriptions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
