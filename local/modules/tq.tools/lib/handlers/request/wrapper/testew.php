<?php
  /**
   * Created by PhpStorm.
   * User: 2qucick
   * Date: 04.01.2018
   * Time: 10:05
   */

namespace TQ\Tools\Handlers\Request\Wrapper;

use TQ\Tools\Handlers\Request\EntityWrapper;

class TestEW extends EntityWrapper
{
    private $datas;
    private $def_params = [
        'type',
        'url',
    ];

    public function __construct($datas)
    {
        $this->datas = $datas;

        parent::__construct($this->datas);
        parent::checkRequestMethod('post');
        parent::checkDataParams($this->def_params, $this->datas);
    }

    public function get()
    {
        $result = ['ID'=>1,'MSG'=>'OK'];
        return $result;
    }
}