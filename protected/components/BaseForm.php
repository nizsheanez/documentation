<?php
 
class BaseForm extends CForm
{
    public $model;

    private $_clear = false;

    
    public function __construct($path, $model)
    {
        $this->model = $model;

        list($module, $form) = explode(".", $path, 2);

        $form_path = "application.modules.{$module}.forms.{$form}";


        parent::__construct($form_path, $model);
    }


    public function __ToString()
    {
        if (Yii::app()->controller instanceof AdminController)
        {
            $tpl = '_adminForm';

            if (!$this->buttons->itemAt('back'))
            {
                $this->buttons->add("back", array(
                    'type'  => 'button',
                    'value' => 'Отмена',
                    'url'   => Yii::app()->controller->createUrl('manage'), 'class' => 'back_button')
                );
            }
        }
        else
        {
            $tpl = '_form';
        }

        if ($this->_clear)
        {
            Yii::app()->clientScript->registerScript(
                'clearForm',
                '$(function()
                {
                    $(":input","#' . $this->activeForm['id'] . '")
                        .not(":button, :submit, :reset, :hidden")
                        .val("")
                        .removeAttr("checked")
                        .removeAttr("selected");
                })'
            );
        }

        try
        {
            return Yii::app()->controller->renderPartial(
                'application.views.layouts.' . $tpl,
                array('form' => $this),
                true
            );
        }
        catch (CException $e)
        {
            die($e->getMessage());
        }

        return "";
    }


    public function clear()
    {
        $this->_clear = true;
    }
}
