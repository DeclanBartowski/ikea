<?php
  /**
   * Created by PhpStorm.
   * User: 2qucick
   * Date: 04.01.2018
   * Time: 10:05
   */

namespace TQ\Tools\Handlers\Request;

use Bitrix\Main\Context;

abstract class EntityWrapper
{
    /**
     * $_SERVER
     * @var
     */
    private $server;

    public function __construct($params)
    {
      $this->server = Context::getCurrent()->getServer();
    }

    abstract protected function get();

    /**
     * Проверка, что метод запроса соответствует серверной переменной REQUEST_METHOD
     * @param null $method
     * @throws \Exception
     */
    protected function checkRequestMethod($method = null): void
    {
        if (empty($method)) {
            throw new \Exception("Null method isn't allowed");
        }

        if ($method != mb_strtolower($this->server['REQUEST_METHOD'])) {
            throw new \Exception("This method isn't allowed");
        }
    }

    /**
     * Проверка наличия всех обязательные параматеров в текущем запросе
     * @param array $def_params
     * @param array $datas
     * @throws \Exception
     */
    protected function checkDataParams(array $def_params = [], array $datas = []): void
    {
        if (count($datas) == 0) {
            throw new \Exception("There aren't any approved datas", 200);
        }

        foreach ($def_params as $param) {

            $keys = array_keys($datas);

            if (!in_array($param, $keys)) {
                throw new \Exception("Undefined required param: " . $param, 200);
            }
        }
    }
		/**
		 * Проверка авторизации пользователя
		 * @throws \Exception
		 */
		protected function checkAuthorization(): void
		{
			global $USER;
			if(!$USER->IsAuthorized()) {
				throw new \Exception("User is not authorized", 200);
			}
		}
}