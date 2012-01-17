#ActiveRecordModel

**`Labels` для атрибутов**

`Labels` для атрибутов берется из комментариев к полям в БД

**Дополнительные функции**

Имеется набор scope'ов:
~~~
[php]
public function limit($num)
public function offset($num)
public function in($row, $values, $operator = 'AND')
public function notIn($row, $values, $operator = 'AND')
public function notEqual($param, $value)
public function last()
public function published()
public function ordered()
~~~


**Возможность использования "негорбатого" стиля**

Добавлена поддержка "негорбатого" написания полей класса,
т.е. для геттера вида `getUserInfo` вы можете писать $model->user_info, и геттер отработает.
Для сеттеров ситуация аналогичная.
