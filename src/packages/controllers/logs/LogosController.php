<?php
namespace PhalconMaterial\Controllers;

use PhalconMaterial\Library\Login;
use PhalconMaterial\Models\Logs;

class LogosController extends ControllerBase
{
  public function getModel()
  {
    return Logs;
  }

  public function addAction(){return;}
  public function editAction(){return;}
  public function deleteAction(){return;}
}

