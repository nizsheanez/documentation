<?php
/**
 * Класс-ярлык для часто употребляемых выражений Yii framework
 *
 * @author Leonid Svyatov <leonid@svyatov.ru>
 * @copyright Copyright (c) 2010-2011, Leonid Svyatov
 * @license http://www.yiiframework.com/license/
 * @version 2.0.4 / 05.01.2011
 */
class Y extends CComponent
{
	const PUBLISHED = 1;
	const NOT_PUBLISHED = 0;
	
	public static $cat;
	
	private static $startSkipCount = 0;
	private static $skipCount = 0;

    public static function asset($alias, $hashByName = false)
    {
        return CHtml::asset(Yii::getPathOfAlias($alias), $hashByName);
    }
    
	/**
     * Возвращает относительный URL приложения
     * @return string
     */
    public static function baseUrl()
    {
        return Yii::app()->baseUrl;
    }
    
    public static function curBaseUrl()
    {
    	$baseUrl = '/';
		if (Y::module())
    		$baseUrl.=Y::module()->id.'/';
		$baseUrl .= Y::controller()->id;
	    return $baseUrl;
    }

	public static function curUrl()
    {
    	return Yii::app()->request->url;
    }
    
    /**
     * Удаляет кэш с тегом $tag
     * @param string $tag имя тега
     * @return boolean
     */
    public static function cacheClear($tag)
    {
        return Yii::app()->cache->clear($tag);
    }

    /**
     * Сохраняет значение $value в кэш с ключом $id на время $expire (в секундах)
     * @param string $id имя ключа
     * @param mixed $value значение ключа
     * @param integer $expire время хранения в секундах
     * @param ICacheDependency $dependency
     * @return boolean
     */
    public static function cache($id = false, $value = false)
    {
    	if ($value) {	//set
    		return Yii::app()->cache->set($id, $value, 0, new Tags(array_slice(func_get_args(), 2)));
    	} elseif ($id) {		//get
    		return Yii::app()->cache->get($id);
    	} else {
    		return Yii::app()->cache;
    	}
    }

    /**
     * Удаляет куку
     * @param string $name имя куки
     */
	public static function cookieDelete($name)
	{
	    if (isset(Yii::app()->request->cookies[$name])) {
	        unset(Yii::app()->request->cookies[$name]);
        }
	}

    /**
     * Устанавливает куку
     * @param string $name имя куки
     * @param string $value значение куки
     * @param integer $expire seconds время хранения (time() + ...) в секундах
     * @param string $path путь на сайте, для которого кука действительна
     * @param string $domain домен, для которого кука действительна
     */
	public static function cookie($name, $value = '', $expire = null, $path = '/', $domain = null)
	{
		if($value) {	//set
			$cookie = new CHttpCookie($name, $value);
		    $cookie->expire = $expire ? $expire : 0;
		    $cookie->path   = $path   ? $path   : '';
		    $cookie->domain = $domain ? $domain : '';
	        Yii::app()->request->cookies[$name] = $cookie;	
		} else { 		//get
			if (isset(Yii::app()->request->cookies[$name])) {
		        return Yii::app()->request->cookies[$name]->value;
	        }
			return null;	
		}
	}

    /**
     * Возвращает значение токена CSRF
     * @return string
     */
    public static function csrf()
    {
        return Yii::app()->request->csrfToken;
    }

    /**
     * Возвращает имя токена CSRF (по умолчанию YII_CSRF_TOKEN)
     * @return string
     */
    public static function csrfName()
    {
        return Yii::app()->request->csrfTokenName;
    }

    /**
     * Возвращает готовую строчку для передачи CSRF-параметра в ajax-запросе
     *
     * Пример с использованием jQuery:
     *      $.post('url', { param: 'blabla', <?=Y::csrfJsParam();?> }, ...)
     * будет соответственно заменено на:
     *      $.post('url', { param: 'blabla', [csrfName]: '[csrfToken]' }, ...)
     *
     * @return string
     */
    public static function csrfJsParam()
    {
        return Yii::app()->request->csrfTokenName.":'".Yii::app()->request->csrfToken."'";
    }

    /**
     * Ярлык для функции dump класса CVarDumper для отладки приложения
     * @param mixed $var переменная для вывода
     * @param boolean $toDie остановить ли дальнейшее выполнение приложения, по умолчанию - true
     */
    public static function dump($var, $skipCount = 0, $depth = 2)
    {
    	if (self::$startSkipCount == 0)
    		self::$startSkipCount = self::$skipCount = $skipCount;
    	else  
			self::$skipCount--;
    	
    	if (self::$skipCount == 0) {
    		self::$startSkipCount = 0;
    		
	        echo '<pre>';
	        CVarDumper::dump($var, $depth, true);
	        echo '</pre>';

//            Y::end(debug_backtrace());
            Y::end();
    	}
    }
    
    /**
     * Выводит текст и завершает приложение (применяется в ajax-действиях)
     * @param string $text текст для вывода
     */
    public static function end($data = '')
    {
    	if (is_array($data)) {
    		echo '<pre>';
    		print_r($data);
    		echo '</pre>';
    	} else {
    		echo $data;		
    	}
    	
        Yii::app()->end();
    }
	
    
    /**
     * Выводит данные в формате JSON и завершает приложение (применяется в ajax-действиях)
     * @param string $data данные для вывода
     */
    public static function endJson($data)
    {
        self::end(CJavaScript::jsonEncode($data));
    }

    /**
     * Устанавливает флэш-извещение для юзера
     * @param string $key ключ извещения
     * @param string $msg сообщение извещения
     */
    public static function flash($key, $msg = '')
    {
    	if($msg)
    		Yii::app()->user->setFlash($key, $msg);	
    	else
			return Yii::app()->user->getFlash($key);
    }
    
	public static function hasFlash($key)
    {
        return Yii::app()->user->hasFlash($key);
    }
    
    /**
     * Устанавливает флэш-извещение для юзера и редиректит по указанному роуту
     * @param string $key ключ извещения
     * @param string $msg сообщение извещения
     * @param string $route маршрут куда редиректить
     * @param array $params дополнительные параметры маршрута
     */
    public static function flashRedir($key, $msg, $route, $params = array())
    {
        Yii::app()->user->setFlash($key, $msg);
        Yii::app()->request->redirect(self::url($route, $params));
    }

    /**
     * Проверка наличия определенной роли у текущего пользователя
     * @param string $roleName имя роли
     * @return boolean
     * @since 2.0.2
     */
    public static function checkAccess($roleName)
    {
        return Yii::app()->user->checkAccess($roleName);
    }

    /**
     * Возвращает true, если пользователь авторизован, иначе - false
     * @return boolean
     */
    public static function isAuthed()
    {
        return !Yii::app()->user->isGuest;
    }
    
    /**
     * Возвращает true, если пользователь гость и неавторизован, иначе - false
     * @return boolean
     */
    public static function isGuest()
    {
        return Yii::app()->user->isGuest;
    }

    /**
     * Возвращает пользовательский параметр приложения с именем $key
     * @param string $key ключ параметра или ключи через точку вложенных параметров
     * 'Media.Foto.thumbsize' преобразуется в ['Media']['Foto']['thumbsize']
     * @return mixed
     */
    public static function param($key)
    {
        if (strpos($key, '.') === false) {
            return Yii::app()->params[$key];
        }

        $keys = explode('.', $key);
        $param = Yii::app()->params[$keys[0]];
        unset($keys[0]);

        foreach ($keys as $k) {
            if (!isset($param[$k])) {
                return null;
            }
            $param = $param[$k];
        }

        return $param;
    }

    /**
     * Редиректит по указанному маршруту
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     */
    public static function redir($route, $params = array())
    {
        Yii::app()->request->redirect(self::url($route, $params));
    }

    /**
     * Редиректит по указанному роуту, если юзер авторизован
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     */
    public static function redirAuthed($route, $params = array())
    {
        if (!self::isGuest()) {
            Yii::app()->request->redirect(self::url($route, $params));
        }
    }

    /**
     * Редиректит по указанному роуту, если юзер гость
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     */
    public static function redirGuest($route, $params = array())
    {
        if (self::isGuest()) {
            Yii::app()->request->redirect(self::url($route, $params));
        }
    }

    /**
     * Возвращает ссылку на request-компонент приложения
     * @return CHttpRequest
     */
    public static function request()
    {
        return Yii::app()->request;
    }

    /**
     * Выводит статистику использованных приложением ресурсов
     * @param boolean $return определяет возвращать результат или сразу выводить
     * @return string
     */
    public static function stats($return = false)
    {
        $stats = '';
        $db_stats = Yii::app()->db->getStats();

        if (is_array($db_stats)) {
            $stats = 'Выполнено запросов: '.$db_stats[0].' (за '.round($db_stats[1], 5).' сек.)<br />';
        }

        $memory = round(Yii::getLogger()->memoryUsage/1024/1024, 3);
        $time = round(Yii::getLogger()->executionTime, 3);

        $stats .= 'Использовано памяти: '.$memory.' Мб<br />';
        $stats .= 'Время выполнения: '.$time.' сек.';

        if ($return) {
            return $stats;
        }

        echo $stats;
    }

    /**
     * Возвращает URL, сформированный на основе указанного маршрута и параметров
     * @param string $route маршрут
     * @param array $params дополнительные параметры маршрута
     * @return string
     */
    public static function url($route, $params = array())
    {
    	//$params = array_merge($params); //for permanent params. example: language
        return Yii::app()->createUrl($route, $params);
    }
    
    public static function absUrl($route, $params = array()) 
    {
    	$params = array_merge($params);
    	return Yii::app()->createAbsoluteUrl($route, $params);
    }
    
    /**
     * Возвращает ссылку на user-компонент приложения
     * @return CWebUser
     */
    public static function user()
    {
        return Yii::app()->user;
    }

    /**
     * Возвращает Id текущего пользователя
     * @return mixed
     */
    public static function userId()
    {
        return Yii::app()->user->id;
    }
    
    public static function module($moduleId = '') 
    {
    	if ($moduleId)
    		return Yii::app()->getModule($moduleId);
    	else
    		return Yii::app()->controller->module;
    }
    
    public static function config($alias, $newValue = '') 
    {
    	if ($newValue)
    		return Yii::app()->config->set($alias, $newValue);
    	else 
    		return Yii::app()->config->get($alias);	
    }

    public static function controller($id = '') 
    {
    	if($id) { //ssory, it work only with controllers outside of a modules
    		return Yii::app()->createController($id);
    	}
    	else
    		return Yii::app()->controller;
    }
    
	public static function clientScript()
	{
		return Yii::app()->clientScript;
	}
	
	public static function regJs($url,$position=CClientScript::POS_HEAD)
	{
		self::clientScript()->registerScriptFile($url,$position); 	
	}

	public static function regCss($url)
	{
		self::clientScript()->registerCssFile($url);
	}
	
	public static function requestType() 
	{
		return Yii::app()->request->requestType;	
	}
	
	public static function isPostRequest() {
		return Yii::app()->request->isPostRequest;
	}
	
	public static function isPutRequest() {
		return Yii::app()->request->isPutRequest;
	}
	
	public static function isDeleteRequest() {
		return Yii::app()->request->isDeleteRequest;
	}
	
	public static function isAjaxRequest() {
		return Yii::app()->request->isAjaxRequest;
	}

	public static function years()
	{
		$res[0]= 'Все года';
		for ($i = 2000; $i <= (int)date('Y',time()); $i++)
			$res[$i]=$i;
		return $res;
	}
	
	public static function month($number = null)
	{
		$arr = array(
			0 => 'Выберите месяц',
			1 => 'Января',
			2 => 'Февраля',
			3 => 'Марта',
			4 => 'Апреля',
			5 => 'Мая',
			6 => 'Июня',
			7 => 'Июля',
			8 => 'Августа',
			9 => 'Сентября',
			10 => 'Октября',
			11 => 'Ноября',
			12 => 'Декабря',
		);
		
		if ($number)
			return $arr[$number];
			
		return $arr;
	}

	public static function rbac()
	{
		return Yii::app()->authManager;
	}
	
	public static function createRbac($name,$type,$description='',$bizRule=null,$data=null)
	{
		Y::rbac()->createAuthItem($name,$type,$description='',$bizRule,$data);
	}

	public static function cart()
	{
		return Yii::app()->shoppingCart;
	}

	public static function file($path)
	{
		return Yii::app()->file->set($path, false);
	}

	public static function obStart()  
	{
		ob_start();
		ob_implicit_flush(false);
	}
	
	public static function obEnd() 
	{
		$res = ob_get_contents();
		ob_end_clean();
		return $res;
	}


    public static $tabs = array();
    public static $curTabName;

    public function beginTab($tabName)
    {
        self::obStart();
        self::$curTabName = $tabName;
    }

    public function endTab()
    {
        self::$tabs[self::$curTabName] = array('content' => self::obEnd());
    }

    public function tab($tabName, $tabContent)
    {
        self::$tabs[$tabName] = $tabContent;
    }

    public function getTabs($id = null, $return = false)
    {
        $tabs = self::controller()->widget(
            'CollectionsTabs', array(
                'tabs'=>self::$tabs,
                'options'=>array(
                    'collapsible'=>false,
                ),
                'id' => $id,
                'htmlOptions' => array('class'=>''),
                'headerTemplate' => '<li class="block_list_header"><a href="{url}" class="white">{title}</a></li>',
                'headerHtmlOptions' => array('class'=>'block_list'),
                'cssFile' => '',
            ),
            true
        );

        //clear
        self::$tabs = array();
        self::$curTabName = '';

        //return
        if ($return)
            return $tabs;
        else
            echo $tabs;
    }

    public function getTabsWithScripts($id = null, $return = false)
    {
        $output = self::getTabs($id, true);
        self::controller()->render($output);

        if ($return)
            return $output;
        else
            echo $output;
    }

    public function hooks()
    {
        return Yii::app()->hooksManager;
    }

    public function resources()
    {
        return Yii::app()->resourceManager;
    }

    public function ajaxExclude($names)
    {

        if (Y::isAjaxRequest()) {
            $files = array();
            foreach ((array)$names as $name) {
                $files[$name] = false;
            }
            Y::clientScript()->scriptMap = CMap::mergeArray(
                Y::clientScript()->scriptMap,
                $files
            );
        }
    }
}