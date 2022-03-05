<?php
  /**
   * Created by PhpStorm.
   * User: 2qucick
   * Date: 04.01.2018
   * Time: 10:05
   */

namespace TQ\Tools\Handlers\Request;

use Bitrix\Main\Context,
    Bitrix\Main\Web\Json;

class RequestHandlers
{
    private static $instance;

    /**
     * $_REQUEST
     * @var
     */
    private $request;

    /**
     * $_SERVER
     * @var
     */
    private $server;

    /**
     * Namespace классов wrapper
     * @var
     */
    private $defaultNamespace ='TQ\Tools\Handlers\Request\Wrapper\\';

    /**
     * массив типов запросов
     * @var array
     */
    private $actions = [
        'test',
        'tools',
        'basket',
	      'personal'
    ];

    private function __construct()
    {
        $this->request = Context::getCurrent()->getRequest();
        $this->server = Context::getCurrent()->getServer();
    }

    protected function __clone()
    {
    }

    public static function i()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * проверка, что даный тип запроса существует и обрабатывается
     * @throws \Exception
     */
    private function checkAction()
    {
        if (!in_array(htmlspecialchars($this->request['action']), $this->actions)) {
            throw new \Exception("Bad action param", 200);
        }
    }

    /**
     * проверка наличия параметров в запросе
     * @throws \Exception
     */
    private function checkData()
    {
        if (!isset($this->request['data'])) {
            throw new \Exception("Bad data param", 200);
        }
    }

    /**
     * Проверка на существование указанного запроса и на наличие параметров запроса
     * @throws \Exception
     */
    private function checkRequest()
    {
        $this->checkAction();
        $this->checkData();
    }

    /**
     * проверка, что запрос пришел от того же пользователя
     * @throws \Exception
     */
    private function checkToken()
    {
        if (!(bitrix_sessid() == $this->request['data']['token'])) {
            throw new \Exception("Bad token param");
        }
    }

    /**
     * обработка запроса и получение результата для вывода
     * TODO: check token
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function process()
    {
        $this->checkRequest();
        //$this->checkToken();

        $action = $this->request['action'];
        if(strpos($action, '_')) {
            $action_ex = explode('_', $action);
            foreach ($action_ex as $key => $action_part) {
                $action_ex[$key] = ucfirst($action_part);
            }
            $action_class = implode('',$action_ex) . 'EW';
        } else {
            $action_class = ucfirst($action) . 'EW';
        }

        $class_name = sprintf('%s%s',$this->defaultNamespace,$action_class);

        if (class_exists($class_name)) {

            $result = new $class_name($this->request['data']);

        } else {
            throw new \Exception("This class doesn't exist");
        }
        try {
          $result = $result->get();
          $result =['status'=>true,'result'=>$result];
        } catch (\Exception $e) {
          $result =['status'=>false,'msg'=>$e->getMessage()];
        } catch (\Throwable $t) {
          $result =['status'=>false,'msg'=>$t->getMessage()];
        }
        return Json::encode($result);
    }

}