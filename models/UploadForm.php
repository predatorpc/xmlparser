<?php
/**
 * Created by PhpStorm.
 * User: MerzlyakovTestPC
 * Date: 02.10.2018
 * Time: 13:24
 */

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $xmlfile;

    public function rules()
    {
        return [
            [['xmlfile'], 'file',
                'skipOnEmpty' => false,
                'checkExtensionByMimeType' => true,
                'extensions' => 'xml',
                ],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->xmlfile->saveAs('uploads/' . $this->xmlfile->baseName . '.' . $this->xmlfile->extension);
            $path = 'uploads/' . $this->xmlfile->baseName . '.' . $this->xmlfile->extension;
            return $path;
        } else {
            return false;
        }
    }
}