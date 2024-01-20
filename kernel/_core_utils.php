<?php

class PrivateConfig
{
  private static $instance = null;
  private $arr = [];
  private function set_array(array $arr) {
    $this->arr = $arr;
  }
  public static function set(array $arr) {
    self::$instance = new self();
    self::$instance->set_array($arr);
  }

  public static function get(string $key) {
    if (self::$instance == null) return null;
    if (!isset(self::$instance->arr[$key])) return null;
    return self::$instance->arr[$key];
  } 
}


/**
 * Load environment variables into a specified class using the provided configuration.
 *
 * This function calls the static method `load` on the specified class,
 * passing the 'env_path' value from the configuration array as an argument.
 *
 * @param string $class The name of the class to load environment variables into.
 * @param array  $config {
 *     An associative array containing configuration options.
 *
 *     @var string $env_path The path to the environment file to be loaded.
 * }
 * 
 * @return void
 */
function load_env(string $class, string $path) {
  $class::load($path);
}

/**
 * Set the root path constant (__ROOT__) based on the location of the project's composer.json file.
 *
 * If the __ROOT__ constant is already defined, the function does nothing.
 * The function searches for the composer.json file by traversing the directory tree
 * upward from the current script's directory (__DIR__). Once found, it sets __ROOT__
 * to the directory containing composer.json.
 *
 * @return void
 */
function set_root_path() {
  if (defined('__ROOT__')) return;

  $root = __DIR__;
  while ($root !== "/") {
      if (file_exists($root . "/composer.json")) break;
      $root = realpath($root . "/..");
  }

  define("__ROOT__", $root);
}

/**
* Define constants from an associative array.
*
* Given an associative array with keys and values, this function iterates through
* the array and defines constants using the key-value pairs.
*
* @param array $assocArray An associative array containing keys and values for constants.
* @return void
*/
function define_constants_from_array(array $assocArray) {
  foreach ($assocArray as $key => $value) {
      define($key, $value);
  }
}


/**
 * Get the base URL of the server, including the protocol and host.
 *
 * This function determines the protocol (HTTP or HTTPS) based on the server's
 * configuration and constructs the base URL using the HTTP host.
 *
 * @return string The server's base URL, including the protocol and host.
 */
function get_server_base_url() {
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' 
      ? "https" 
      : "http";

  return $protocol . "://" . $_SERVER['HTTP_HOST'];
}

function set_base_url_path() {
  define('__BASE_URL__', get_server_base_url());
} 

/**
 * Set CORS headers based on the provided configuration.
 *
 * @param array $config {
 *     An associative array containing CORS configuration options.
 *
 *     @var string $allowed_origin The allowed origin (default: '*').
 *     @var string $allowed_methods The allowed HTTP methods (default: 'GET, POST, OPTIONS').
 *     @var string $allowed_headers The allowed HTTP headers (default: 'Content-Type, Authorization').
 *     @var bool   $allow_credentials Whether to allow credentials (default: true).
 *     @var int    $max_age          The maximum age (in seconds) for caching preflight requests (default: 86400, 1 day).
 * }
 */
function set_cors_headers($config = []) {
  $allowed_origin = isset($config['allowed_origin']) 
    ? $config['allowed_origin'] : '*';
  $allowed_methods = isset($config['allowed_methods']) 
    ? $config['allowed_methods'] : 'GET, POST, OPTIONS';
  $allowed_headers = isset($config['allowed_headers']) 
    ? $config['allowed_headers'] : 'Content-Type, Authorization';
  $allow_credentials = isset($config['allow_credentials']) 
    ? $config['allow_credentials'] : true;
  $max_age = isset($config['max_age']) 
    ? $config['max_age'] : 86400;

  header('Access-Control-Allow-Origin: ' . $allowed_origin);
  header('Access-Control-Allow-Methods: ' . $allowed_methods);
  header('Access-Control-Allow-Headers: ' . $allowed_headers);
  header('Access-Control-Allow-Credentials: ' . (
    $allow_credentials ? 'true' : 'false'
  ));
  header('Access-Control-Max-Age: ' . $max_age);
}


/**
 * Requires all PHP files in a specified directory.
 *
 * @param string $directory The directory path where PHP files are located.
 * 
 * @return void
 * @throws \RuntimeException If an error occurs while reading files.
 */
function require_files_by_dir(string $directory) {
  $files = glob($directory . '/*.php');

  if ($files === false) {
      throw new \RuntimeException("Error while reading files");
  }

  foreach ($files as $file) {
      require_once $file;
  }
}
/**
 * Serve content based on a callback function and a file path.
 *
 * @param callable $cb A callback function to execute when the condition is met.
 * @param string   $file The file path to compare with the current PHP script's file name.
 * 
 * @return void
 */
function serve(callable $cb, string $file) {
  if (basename($file) == basename($_SERVER['PHP_SELF'])) {
      $cb();
  }
}

function load_configuration(string $app_config_path) {
  set_root_path();
  set_base_url_path();

  include $app_config_path;
  if (!isset($app_config)) return;

  load_env(
    $app_config['env']['loader'], 
    $app_config['env']['path']
  );

  include $app_config_path;

  PrivateConfig::set($app_config);
}

function get_app_config(string $key) {
  return PrivateConfig::get($key);
}