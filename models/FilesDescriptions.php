<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files_descriptions".
 *
 * @property int $id
 * @property int $file_id
 * @property string $created_at
 * @property int $status
 */
class FilesDescriptions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'files_descriptions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_id', 'status'], 'required'],
            [['file_id', 'status','unique_tags'], 'integer'],
            [['tags'],'safe'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID Записи',
            'file_id' => 'ID Файла',
            'unique_tags' => 'Кол-во уникальных тэгов',
            'tags' => 'Тэги',
            'created_at' => 'Дата загрузки',
            'status' => 'Активность',
        ];
    }
}
