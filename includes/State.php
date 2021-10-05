<?php

namespace JWorkman\Gutenberg_Block_Manager;

class State extends Factory
{
  /*
    This method sets up the GBM plugin and all of the requirements for it to work
  */
  public static function activate()
  {
    return true;
  }

  /*
    This method removes all of the GBM plugin and all of the requirements for it to work
  */
  public static function deactivate()
  {
    return true;
  }
}
