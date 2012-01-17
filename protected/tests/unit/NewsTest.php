<?php
class NewsTest extends CTestCase
{
    public function testGetContent()
    {
        Yii::app()->getModule('news');
        Yii::import('application.modules.news.models.*');
        $model = new News;
        $model->setAttributes(array(
            'text'=>'comment 1',
            'status'=>News::STATE_ACTIVE,
        ),false);

        
    }

    
}