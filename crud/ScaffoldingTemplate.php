<?php

namespace daweb\crud;

/**
 * template uses in cereate crud scaffolding. Maybe be overwrite - check readme file
 *
 * @author daweb
 */
abstract class ScaffoldingTemplate {

    /**
     * name template
     * @var string
     */
    protected $tableName;

    /**
     * string save, update, delete query and params
     * @var array 
     */
    protected $statement = [
        'query' => ['insert' => '', 'update' => ''],
        'params' => ''
    ];

    /**
     * create crud file 
     * @param string $table_name
     * @param \PDOStatement $data_info
     */
    public final function make($table_name, \PDOStatement $data_info) {

        $this->tableName = $table_name;

        while ($dataColumn = $data_info->fetch(\PDO::FETCH_ASSOC)) {

            $this->prepareQuery($dataColumn);

            /* callback for hereditary */
            if (method_exists($this, 'getDataColumn')) {
                $this->getDataColumn($dataColumn);
            }
        }
        return $this->save();
    }

    abstract protected function template($className);

    /**
     * Save your generated template
     * @return string
     * @throws ScaffoldingException
     */
    protected final function save() {

        $className = $this->tableName;
        $className = str_replace(['_', '-'], [' '], $className);
        $className = ucwords($className);
        $className = str_replace(' ', '', $className);

        $path = ScaffoldingConfig::get('path_crud');

        if (!file_exists($path)) {
            throw new \Exception("path_crud incorrect");
        }
        if (!is_writable($path)) {
            throw new \Exception("path_crud is not writable");
        }
        $path .= $path[strlen($path) - 1] == DIRECTORY_SEPARATOR ? : DIRECTORY_SEPARATOR;

        $absolutePath = $path . $className . '.php';

        if (file_exists($absolutePath)) {
            readline("\n The file $className.php is exists - overwrite?[Y/N]: ") !== 'N' ? : exit;
        }
        if (file_put_contents($absolutePath, $this->template($className))) {
            chmod($absolutePath, fileperms($absolutePath) | 128 + 16 + 2);
            return $absolutePath;
        }
        return false;
    }

    /**
     * prepare CRUD query this method is used in loop 
     * @param array $dataColumn
     */
    protected function prepareQuery($dataColumn) {

        $addComma = function(&$statement) {

            if (strlen($statement) > 0)
                $statement .=',';
        };
        $addComma($this->statement['query']['insert']);
        $addComma($this->statement['query']['update']);
        $addComma($this->statement['params']);

        $this->statement['query']['insert'] .= ':' . $dataColumn['Field'];
        $this->statement['query']['update'] .= $dataColumn['Field'] . '=:' . $dataColumn['Field'];
        $this->statement['params'] .= '\':' . $dataColumn['Field'] . '\'=> $_POST[\'' . $this->tableName . '\'][\'' . $dataColumn['Field'] . '\']';
    }

}
