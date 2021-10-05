<?php

namespace JWorkman\Gutenberg_Block_Manager;

class Factory
{
  public static function init(string $class, $options = [])
  {
    $invoked_class = self::getInvokedClassName(get_called_class(), $class);

    // Autoload the class if it hasn't already been loaded
    $loaded = self::loadClassByName($class);

    $fqcn = self::getFullyQualifiedClassName($class);
    return new $fqcn($options);
  }
  public static function getFullyQualifiedClassName(string $classname): string
  {
    if (strstr($class, __NAMESPACE__) === false) {
      return sprintf("\\%s\\%s", __NAMESPACE__, $classname);
    }
    return $classname;
  }
  public static function loadClassByName(string $class): bool
  {
    $fqcn = self::getFullyQualifiedClassName($class);
    // If the class doesn't exist then we need to load it in
    if (!class_exists($fqcn)) {
      $class_chunks = explode('\\', $fqcn);
      $class_name = end($class_chunks);
      $class_filepath = sprintf("%s%s.php", plugin_dir_path( __FILE__ ), $class_name);

      // If we can't load in the class file then throw an error.
      if (!file_exists($class_filepath)) {
        throw new \Exception(
          sprintf(
            "Could not load class name \"%s\" in runtime. Attempted to find class in file target: %s",
            $class_name, $class_filepath
          )
        );
      } else {
        require_once $class_filepath;
      }
    }

    // Returns true/false depending on if the auto load was successful
    return class_exists($fqcn);
  }
  /*
    This method either picks the invoked class by class name, or the
    class shortcut name based by string. Both of the following are
    correct ways to load the same thing. This function figures it out.
    $model = Factory::init('Model')->method(...arguments)
    $model = Model::init()->method(...arguments)
  */
  public static function getInvokedClassName(string $invoked_name, string $short_name)
  {
    return (preg_match("/.*Factory$/", $invoked_name) === 0) ? $invoked_name : $short_name;
  }
  public static function invokeStatic(string $class, string $method, array $options = [])
  {
    $invoked_class = self::getInvokedClassName(get_called_class(), $class);
    $fqcn = self::getFullyQualifiedClassName($class);

    // Autoload the class if it hasn't already been loaded
    self::loadClassByName($class);

    // Now we will return the result of the call
    return $fqcn::$method($options);
  }
}
