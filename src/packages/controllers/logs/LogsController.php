<?php
namespace PhalconMaterial\Controllers;

use PhalconMaterial\Library\Login;
use PhalconMaterial\Models\Logs;

class LogsController extends ControllerBase
{
  public function getModel()
  {
    return new Logs;
  }

  public function addAction(){return;}
  public function editAction($id){return;}
  public function deleteAction($id){return;}
}

