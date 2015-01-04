      <?php
        /**
         * Exemplary generated crud file
         */
        Class User  {
                
                private $db;
                
                public function __construct() {
                
                    /**rules for validate request data **/
                    $rules = ['id' =>['default' => '', 'null' => 0, 'type' => 'int', 'length' => '11'], 'username' =>['default' => '', 'null' => 0, 'type' => 'varchar', 'length' => '255'], 'auth_key' =>['default' => '', 'null' => 0, 'type' => 'varchar', 'length' => '32'], 'password_hash' =>['default' => '', 'null' => 0, 'type' => 'varchar', 'length' => '255'], 'password_reset_token' =>['default' => '', 'null' => 1, 'type' => 'varchar', 'length' => '255'], 'email' =>['default' => '', 'null' => 0, 'type' => 'varchar', 'length' => '255'], 'role' =>['null' => 0, 'type' => 'smallint', 'length' => '6'], 'status' =>['null' => 0, 'type' => 'smallint', 'length' => '6'], 'created_at' =>['default' => '', 'null' => 0, 'type' => 'int', 'length' => '11'], 'updated_at' =>['default' => '', 'null' => 0, 'type' => 'int', 'length' => '11'], ];
                
                    $this->db = new \PDO('mysql:host=localhost;dbname=test','root','asc');
                }
                 public function view() {
                   
                   return $this->db
                       ->query('select * from `user`')
                       ->fetchAll();                      
                }
                public function create() {
                   
                   return $this->db
                       ->prepare('insert into `user` value(:id,:username,:auth_key,:password_hash,:password_reset_token,:email,:role,:status,:created_at,:updated_at)')
                       ->execute([':id'=> $_POST['user']['id'],':username'=> $_POST['user']['username'],':auth_key'=> $_POST['user']['auth_key'],':password_hash'=> $_POST['user']['password_hash'],':password_reset_token'=> $_POST['user']['password_reset_token'],':email'=> $_POST['user']['email'],':role'=> $_POST['user']['role'],':status'=> $_POST['user']['status'],':created_at'=> $_POST['user']['created_at'],':updated_at'=> $_POST['user']['updated_at']]);
                }
                public function update($id) {
                       
                   return $this->db->prepare('update `user` set id=:id,username=:username,auth_key=:auth_key,password_hash=:password_hash,password_reset_token=:password_reset_token,email=:email,role=:role,status=:status,created_at=:created_at,updated_at=:updated_at where id = :where_id')
                         ->execute([':id'=> $_POST['user']['id'],':username'=> $_POST['user']['username'],':auth_key'=> $_POST['user']['auth_key'],':password_hash'=> $_POST['user']['password_hash'],':password_reset_token'=> $_POST['user']['password_reset_token'],':email'=> $_POST['user']['email'],':role'=> $_POST['user']['role'],':status'=> $_POST['user']['status'],':created_at'=> $_POST['user']['created_at'],':updated_at'=> $_POST['user']['updated_at'],':where_id' => $id]);
                }
                public function delete($id) {
                         
                   return $this->db->prepare('delete from `user` where id = :where_id') 
                         ->execute([':where_id' => $id]);
                }
        }