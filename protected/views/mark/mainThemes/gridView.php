**Сортировка**

- Использовать класс GridView или производный с параметром sortable=>true
- Добавить в метод `search` модели `$criteria->order = $alias.'.order DESC';` - для упорядочивания
- Подключить поведение в модель:
~~~
[php]
    'sortable'    => array(
    'class'=> 'ext.sortable.SortableBehavior'
),
~~~

**Сортировка в отношении Many_Many**

Бывает нужно упорядочить товары в какой-либо конкретной категории, при том,
что товар может принадлежать нескольким категориям (Many_Many)

- Добавить в промежуточную таблицу полу order
- Добавить `scope`:
~~~
[php]
public function inCategory($category)
{
    $this->getDbCriteria()->mergeWith(array(
        'with'  => array(
            'categories'=> array(
                'on'      => 'categories.id=' . $category->id,
                'together'=> true,
                'joinType'=> 'INNER JOIN'
            )
        ),
        'order' => 'categories_categories.order'
    ));
    return $this;
}
//categories - Заменить на нужное отношение
~~~
- Добавить в метод `search` код для упорядочивания товаров в заданной категории:
`$criteria->mergeWith(self::model()->inCategory($category)->dbCriteria);`
- Использовать класс GridView или производный с параметрами:
~~~
[php]
'many_many_sortable' => true,
'cat_id'            => $category->id,
~~~
- Подключить поведение в модель:
~~~
[php]
    'manyManySortable'    => array(
    'class'=> 'ext.sortable.ManyManySortableBehavior'
),
~~~


**Массовое удаление**  

- Использовать класс `GridView` или производный с параметром `mass_removal=>true`

**Вывод даты**

Для вывода даты предусмотрена специальная колонка DateColumn. Она позволяет выводить даты в заданном формате,
а так же предоставляет возможность фильтрации записей по временному диапазону.

Использование:
~~~
[php]
array(
     'class'=>"DateColumn",
     'name'=>'date',
),
~~~


Отправляются данные на сервер в виде _{name}_start и _{name}_end где name - имя атрибута.
Для возможности фильтрации по временному диапазону, нужно добавить в метод search модели:
~~~
[php]
if (isset($_GET['_date_end']) && ($end = strtotime($_GET['_date_end'])))
{
    $criteria->addCondition("date<'" . date('Y-m-d 23:59:59', $end) . "'");
}
if (isset($_GET['_date_start']) && ($start = strtotime($_GET['_date_start'])))
{
    $criteria->addCondition("date>'" . date('Y-m-d 00:00:00', $start) . "'");
}
~~~
Пользовательский интерфейс не позволит быть начальной дате больше чем конечной.


**Создание своей колонки**

*javascript часть*

- Для создания колонки со сложным клиентским поведением существует базовый плагин
`/js/packages/adminBaseClasses/gridBase.js` подключается автоматически. Этот плагин берет
на себя работу по синхронизации с плагином `yiiGridView`, а так же предоставляет API
для реализации на его основе своих плагинов.

- Плагин изначально вызывает метод `_initHandlers` используйте его для инициализации своих скриптов.
После `ajaxUpdate(метод yiiGridView) _initHandlers` будет вызван повторно,
поэтому нет необходимости использовать `live` или `delegate`.

- На одну таблицу можо вешать неограниченное количество плагинов основанных на `CmsUI.gridBase`.

*php часть*

- т.к. мы зависим от `yiiGridView`, то инициализация наших плагинов, должна произойти после
инициализации `yiiGridView` Т.е.

> Если вы хотите подключить `javascript` из какой-либо колонки,
то для этого в компоненте `GridView` предусмотренно событие `onRegisterScript`.
В методе `init` колонки, используйте `$this->grid->onRegisterScript = array($this, 'registerScript');`
и в методе `registerScript` вашей колонки регистрируйте любые скрипты.

