#Виджеты для форм:

##Список алиасов

Алиас используемый в форме | Реальный виджет
---------------------------|---------------------------------------------
`checkbox`                 | `main.components.IphoneCheckbox`
`multi_select`             | `ext.emultiselect.EMultiSelect`
`multi_autocomplete`       | `main.components.MultiAutocomplete`
`alias`                    | `main.components.AliasField`
`chosen`                   | `dropdownlist`
`date`                     | `ext.jui.FJuiDatePicker`
`editor`                   | `ext.tiny_mce.TinyMCE`
`autocomplete`             | `CAutoComplete`
`file_manager`             | `fileManager.portlets.Uploader`

##Общий список виджетов

Виджет                              | Зачем нужен
------------------------------------|---------------------------------------------------------------------------
`checkbox`                          | Красивый чекбокс. [источник](http://awardwinningfjords.com/2009/06/16/iphone-style-checkboxes.html)
`multi_select`                      | Функциональный мультиселект. [источник](http://quasipartikel.at/multiselect/)
`multi_autocomplete`                | Автокомплит с возможностью выбора нескольких вариантов, мультиселект для большого объема данных
`alias`                             | Автогенерация `url` и алиасов
`chosen`                            | Украшение выпадающего списка
`date`                              | `jQuery.UI.DatePicker` с возможностью задания диапазона дат.
`editor`                            | Редактор текста
`autocomplete`                      | `jQuery.UI.Autocomplete`
`file_manager`                      | Загрузка серии файлов
`main.components.AllInOneInput`     | Редактирование текстовой информации с разделителями(например ';')
`main.portlets.MetaTags`            | Добавление метатегов к записям


##Основные виджеты

- **alias**

Добавляет `disabled` поле в форму, автоматически заполняемую текстом из поля `source`, транслитерируя
перед этим текст из поля `source`. Нетекстовые символы и прочий мусор удаляются

Обязательный параметр `source` - имя атрибута источника

Скрытое поле выводится для того, что бы сохранить валидацию, т.к. `jquery.serialize и гнорирует `disabled` поля

Пример использования:

~~~
[php]
'title' => array('type' => 'text'),
'url'   => array('type' => 'alias', 'source' => 'title'),
~~~

- **file_manager**

Подробное описание находится в модуле [fileManager](/index.php/fileManager)

- **chosen**

Это просто украшение, настройки абсолютно такие же, как и при использование `dropdownlist`

- **main.components.AllInOneInput**

Используется для редактирования текста с разделителями. Вместо строки выводит набор элементов
которым можно удалять, сортировать, добавлять новые. При этом на сервер отправляется всегда
собранная из элементов строка через заданный разделитель.

- **multi_autocomplete**

Функциональный мультиселект для работы с большими объемами данных. Работает на базе jQuery.UI.Autocomplete

~~~
[php]
'categories' => array(
    'type'     => 'multi_select',
    'selected'     => 'all_relevant_products',
    'url'          => '/products/productAdmin/productsAsJson'
),
~~~

- **multi_select**

Функциональный мультиселект: поддерживает сортировку, фильтрацию, массовое добавление/удаление

~~~
[php]
'categories' => array(
    'type'     => 'multi_select',
    'items'    => CHtml::listData(Category::getRoot()->descendants()->findAll(), 'id', 'nbspTitle'),
    'onchange' => "js:function() { alert(3); }",
    'hint'     => 'Список категорий к которым будет принадлежать товар. <br/>Внимание! Дополнительные свойства товара, зависят от того в какой категории он находится, поэтому при изменении этого параметра форма автоматически будет перестроена в соответствии с новыми настройками. По этой причине, при изменении данного параметра он будет сохранен автоматически и кнопка "Отмена" не вернет данный параметр к исходному состоянию.'
),
~~~

- **main.portlets.MetaTags**

Добавляет 3 `input'а` в форму редактирования для того что бы ввести ключевые слова, описание и тайтл.

