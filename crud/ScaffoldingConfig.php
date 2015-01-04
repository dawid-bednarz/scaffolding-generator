<?php

/**
 * Allow create and access/changes to config file
 *
 * @author daweb
 */

namespace daweb\crud;

class ScaffoldingConfig {

    private static $config;

    /**
     * defaults settings config file
     * @var array 
     */
    private $defaults = [
        'template_class' => 'daweb\crud\template\DefaultTemplate'
    ];

    const CONFIG_FILE = 'config.php';

    public function __construct() {

        if (!$this->exists()) {

            $this->create();
        }
        $this->load();
    }

    public static function get($key) {

        if (isset(self::$config[$key])) {
            return self::$config[$key];
        }
        return NULL;
    }

    /**
     * load config file to class
     */
    public function load() {

        if ($this->exists() && is_null(self::$config)) {

            self::$config = include self::CONFIG_FILE;
        }
    }

    public function create() {

        echo "You must create config file in next step \n";

        $user = readline("Username datebase: ");
        $password = readline("Password database: ");
        $host = readline("Host database: ");
        $driver = readline("Driver datebase: ");
        $dbname = readline("Datebase name: ");

        $templateClass = readline("Template class(default {$this->defaults['template_class']}):");

        $pathCRUD = readline("where to put crud files?(give absolute path): ");

        /** default settings * */
        !empty($templateClass) ? : $templateClass = $this->defaults['template_class'];

        $output = <<<EOT
            <?php return array(
                'db' => [
                  'dsn'=> '$driver:host=$host;dbname=$dbname',
                  'username' => '$user',
                  'password' => '$password',
                   ],
                 'path_crud' => '$pathCRUD',
                 'template_class' => '$templateClass'
                 );
EOT;
        if (!file_put_contents(self::CONFIG_FILE, $output)) {

            chmod(self::CONFIG_FILE, fileperms(self::CONFIG_FILE) | 128 + 16 + 2);

            throw new ScaffoldingException('failed create config file');
        }
    }

    /*
     * return absolute path to config file
     */

    public function change() {
        echo "\n" . 'the config file is located ' . dirname(__DIR__) . DIRECTORY_SEPARATOR . self::CONFIG_FILE . ' - use your favorite editor to edit him' . "\n\n";
    }

    public function exists() {

        return file_exists(self::CONFIG_FILE);
    }

}
