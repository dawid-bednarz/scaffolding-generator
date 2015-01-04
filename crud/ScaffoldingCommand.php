<?php

namespace daweb\crud;

/**
 * All public methods is used in command line. 
 * Convention in command "methodName/argument"
 *
 * @author daweb
 */
class ScaffoldingCommand {

    public $scaffolding;

    public function __call($name, $arguments) {

        throw new \Exception("Not found command '$name'");
    }

    public function __construct(Scaffolding $scaffolding) {
        $this->scaffoldin = $scaffolding;
    }

    public function change($type) {

        switch ($type) {
            case 'config': $this->scaffoldin->config->change();
                break;
            default: throw new \Exception("Not found command '$type'");
        }
    }

    /**
     * Delete last created file controller
     */
    public function back() {
        $history = $this->scaffoldin->helper
                ->getHistory();

        if ($history) {
            unlink($history);
        }
    }

    /**
     * Show allowed commands
     */
    public function help() {
        echo "\n Allowed commands:";
        echo "\n create/<name_table> - create scaffolding";
        echo "\n back - delete last created crud file";
        echo "\n change/config - change config file \n\n";
    }

    /**
     * Create crud file
     * @param string $table_name
     * @throws ScaffoldingException
     */
    public function create($table_name) {

        if (!DB::$pdo->query('select 1 from ' . $table_name)) {

            throw new \Exception("table '$table_name' not exists");
        }

        $columnsInfo = DB::$pdo->query('describe ' . $table_name);

        $absolutePath = $this->scaffoldin
                ->prepareTemplate()
                ->make($table_name, $columnsInfo); // if true return absolute path to crud file

        if ($absolutePath) {

            $this->scaffoldin->helper
                    ->saveToHistory($absolutePath);

            echo "\n Succesfully created crud file in $absolutePath\n\n";
        } else {

            throw new \Exception("failed to save file controller");
        }
    }

}
