**UploadFileBehavior**

Позволяет использовать следующий синтаксис в моделях для автоматической загрузки файлов
~~~
[php]
public function uploadFiles()
{
    return array(
        'photo' => array('dir' => self::PHOTOS_DIR)
    );
}
~~~
