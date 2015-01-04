<?php

namespace daweb\crud\template;

use daweb\crud\ScaffoldingTemplate;

/**
 * Default template for scaffolding
 *
 * @author  daweb
 */
class DefaultTemplate extends ScaffoldingTemplate {

    /**
     * For after validate data in your file controller
     * @var array 
     */
    private $rules = '';

    /**
     * Create string multidimensional array with rules for post data in your controller
     * @param type $data
     */
    private function createRuleTable($data) {

        $this->rules .= "'" . $data['Field'] . "' =>[";

        if (is_null($data['Default'])) {
            $this->rules .= "'default' => '" . $data['Default'] . "', ";
        }
        $this->rules .="'null' => " . ($data['Null'] == 'YES' ? true : 0) . ", ";

        $type = explode('(', $data['Type']);

        if (count($type) == 2) {
            $this->rules .= "'type' => '" . $type[0] . "', "; // name type
            $this->rules .= "'length' => '" . str_replace(')', '', $type[1]) . "'], "; // length
        } else {
            $this->rules .= "'type' => '" . $data['Type'] . "'], ";
        }
    }

    /**
     * Callback in loop on the info table column
     * @param type $dataColumn
     */
    protected function getDataColumn($dataColumn) {
        
        $this->createRuleTable($dataColumn); // for after validate post data in your controller
    }

    /**
     * Default template for the created controller file
     * @param string $className
     * @return string
     */
    protected function template($className) {
        
        $dbDataConnect = \daweb\crud\ScaffoldingConfig::get('db');

        return <<<EOT
      <?php
        
        Class $className  {
                
                private \$db;
                
                public function __construct() {
                
                    /**rules for validate request data **/
                    \$rules = [$this->rules];
                
                    \$this->db = new \PDO('{$dbDataConnect['dsn']}','{$dbDataConnect['username']}','{$dbDataConnect['password']}');
                }
                 public function view() {
                   
                   return \$this->db
                       ->query('select * from `$this->tableName`')
                       ->fetchAll();                      
                }
                public function create() {
                   
                   return \$this->db
                       ->prepare('insert into `$this->tableName` value({$this->statement['query']['insert']})')
                       ->execute([{$this->statement['params']}]);
                }
                public function update(\$id) {
                       
                   return \$this->db->prepare('update `$this->tableName` set {$this->statement['query']['update']} where id = :where_id')
                         ->execute([{$this->statement['params']},':where_id' => \$id]);
                }
                public function delete(\$id) {
                         
                   return \$this->db->prepare('delete from `$this->tableName` where id = :where_id') 
                         ->execute([':where_id' => \$id]);
                }
        }
EOT;
    }

}
