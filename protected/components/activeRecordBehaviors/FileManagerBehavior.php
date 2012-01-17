<?php

class FileManagerBehavior extends CActiveRecordBehavior
{
    public function afterSave($event)
    {
        $model = $this->getOwner();
        if ($model->isNewRecord)
        {
            $files = FileManager::model()->findAllByAttributes(array(
                'object_id' => 'tmp_' . Yii::app()->user->id,
                'model_id'  => get_class($model)
            ));

            foreach ($files as $file)
            {
                $file->object_id = $model->id;
                $file->save();
            }
        }

        return parent::beforeSave($event);
    }


    public function beforeDelete($event)
    {
        $model = $this->getOwner();

        $files = FileManager::model()->findAllByAttributes(array(
            'model_id'  => get_class($model),
            'object_id' => $model->id
        ));

        foreach ($files as $file)
        {
            $file->delete();
        }

        return parent::beforeDelete($event);
    }
}
