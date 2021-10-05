<?php

namespace JWorkman\Gutenberg_Block_Manager;

class Manager extends Factory
{

  /*
    Class Globals
  */
  private $_model;
  private $_ui;
  private $_gutenberg;

  public function run()
  {
    $this->_model = Factory::init('Model');
    $this->_ui = Factory::init('UserInterface')->initHooks();
    $this->_gutenberg = Factory::init('Gutenberg', [ 'model' => $this->_model ])->initHooks();
    $this->_api = Factory::init('API')->initHooks();
    return $this;
  }
}
