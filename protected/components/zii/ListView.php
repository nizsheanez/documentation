<?php
Yii::import("zii.widgets.CListView");
class ListView extends CListView
{
    public $cssFile = '/css/yii/listview.css';
    public $pager = array(
        'class'   => 'LinkPager'
    );
    public $itemsHtmlOptions = array();
    
    public function renderItems()
    {
        $options = CMap::mergeArray($this->itemsHtmlOptions, array('class'=>$this->itemsCssClass));
        echo CHtml::openTag($this->itemsTagName,$options)."\n";
        $data=$this->dataProvider->getData();
        if(($n=count($data))>0)
        {
            $owner=$this->getOwner();
            $render=$owner instanceof CController ? 'renderPartial' : 'render';
            $j=0;
            foreach($data as $i=>$item)
            {
                $data=$this->viewData;
                $data['index']=$i;
                $data['data']=$item;
                $data['widget']=$this;
                $owner->$render($this->itemView,$data);
                if($j++ < $n-1)
                    echo $this->separator;
            }
        }
        else
            $this->renderEmptyText();
        echo CHtml::closeTag($this->itemsTagName);
    }
}