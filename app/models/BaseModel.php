<?php
/**
 * Created by PhpStorm.
 * User: Kevin
 * Date: 16/8/21
 * Time: 下午10:31
 */

namespace Models;

class BaseModel extends  \Phalcon\Mvc\Model {
    // 数据表
    protected $table;

    public function initialize() {
        $this->setSource($this->table);
    }

    /** 解析查询条件 */
    protected function transWhere($where) {
        if(!is_array($where)) {
            return $where;
        }

        $query = [];
        foreach($where as $key => $val) {

            switch (strtolower($key)) {
                case '$in':

                    foreach($val as $aKey => $values) {
                        $query[] = $aKey . " IN ('" . join("', '", $values) . "')";
                    }
                    break;
                case '$like':
                    foreach($val as $aKey => $value) {
                        $query[] = $aKey . " LIKE '" . $value . "'";
                    }
                    break;
                case '$lte':
                    foreach($val as $aKey => $value) {
                        $query[] = $aKey . "<='" . $value . "'";
                    }
                    break;
                case '$lt':
                    foreach($val as $aKey => $value) {
                        $query[] = $aKey . "<'" . $value . "'";
                    }
                    break;
                case '$gte':
                    foreach($val as $aKey => $value) {
                        $query[] = $aKey . ">='" . $value . "'";
                    }
                    break;
                case '$gt':
                    foreach($val as $aKey => $value) {
                        $query[] = $aKey . ">'" . $value . "'";
                    }
                    break;
                case '$ne':
                    foreach($val as $aKey => $value) {
                        $query[] = $aKey . "<>'" . $value . "'";
                    }
                    break;
                case '$bt':
                    foreach($val as $aKey => $values) {
                        $query[] = $aKey . " BETWEEN ".$values[0]." AND ".$values[1];
                    }
                    break;
                default:
                    $query[] = $key . "='" . $val . "'";
            }
        }

        return join(' AND ', $query);
    }

    /** 执行 SQL 语句
     * @param  string  $sql     SQL 语句
     * @param  array   $bind    SQL 语句绑定的参数
     * @return array            结果对象数组
     *
     * Example:
     *      $mod = new Users();
     *      // simple query
     *      $sql = "SELECT * FROM `users`";
     *      $users = $mod->exec($sql);
     *
     *      // Binding paramters
     *      $sql = "SELECT * FROM `users` WHERE `id`=:uid";
     *      $users = $mod->exec($sql, array('uid' => $uid));
     */
    public function exec($sql, array $bind=null) {
        return $this->getReadConnection()->query($sql,$bind)->fetchAll();
    }


    public function exec_sql($sql) {
        return $this->getReadConnection()->query($sql);
    }

    public function getCount($where, $from, $groupBy = ''){
        $table = $from ? $from : $this->table;
        if ($where){
            $where = array($this->transWhere($where)) ;
        }else{
            $where = '1';
        }
        $sql='select count(1) as totalCount from '.$table .' where '.$where['0'];
        if($groupBy) {
            $sql .= " GROUP BY ".$groupBy;
        }
        $result = $this->exec($sql);
        return isset($result[0]) ? $result[0]['totalCount'] : 0;
    }
    /** Query the first record that match the specified conditions.
     * @params  array/string    $where   The conditions array or string.
     * @params  string  $order   排序, 如 "name DESC"
     * @return  object           The result record of Model object.
     *
     * Example:
     *      // Simple find one
     *      $user = Users::findOne();
     *
     *      // Fine one with query conditions.
     *      $user = users::findOne("name='Joe'");
     *      ／／$user = users::findOne(array("name" => 'Joe'));
     *
     *      // Find one order by age DESC.
     *      $user = users::findOne("name='Joe'", "age");
     *      // Similar as:
     *      $user = users::findOne("name='Joe'", "age DESC");
     *
     *      // Find one order by age ASC.
     *      $user = Users::findOne("age<=20", "age ASC");
     */
    public function findOne($where=null, $order=null) {
        $where = array($this->transWhere($where));

        if(!is_null($order)) {
            $where['order'] = $order;
        }

        return self::findFirst($where);
    }

    /** Query a set of records that match the specified conditions.
     * @params  string/array   $where   The conditions array.
     * @params  string  $order   排序, 如 "name DESC"
     * @params  int     $limit
     * @params  int     $offset
     * @return  array            The result records of Model objects.
     *
     * Example:
     *      // Simple find all.
     *      $users = Users::findAll();
     *
     *      // Find all with string conditions.
     *      $users = Users::findAll("gender='m' AND age<=20 AND id in [1, 2] AND name Like '%abc'");
     *
     *      // Find all with array conditions.
     *      $users = Users::findAll(array(
     *          "gender=> 'm',
     *          "$lte" => array('age' => 20),
     *          "$in" => array('id' => [1, 2]),
     *          "$like" => array('name' => '%abc'),
     *      ));
     *
     *      // Find all order by name ASC
     *      $users = Users::findAll("age<=20", "name ASC");
     *
     *      // Find all order by name ASC and limit 3
     *      $users = Users::findAll("age<=20", "name ASC", 3);
     *
     *      // Find all order by name ASC and limit 3, 3
     *      $users = Users::findAll("age<=20", "name ASC", 3, 3);
     *
     *  数组格式的查询条件不支持 OR 查询，若需要 OR 查询或查询条件较复杂，可选择字符串的where查询
     */
    public function findAll($where=null, $offset=0 , $limit=null, $order=null, $groupBy = null) {
        $where = array($this->transWhere($where));
        if(!is_null($order)) {
            $where['order'] = $order;
        }

        if(!is_null($limit)) {
            $where['limit'] = $limit;
        }

        if(!is_null($offset)) {
            $where['offset'] = $offset;
        }
        if(!is_null($groupBy)) {
            $where['group'] = $groupBy;
        }

        return self::find($where);
    }

    /** Inserts a model instance.
     * If the instance already exists it will throw an exception.
     *
     * @return  boolean     Returning true on success or false otherwise.
     *
     * Example:
     *      $user = new Users();
     *      $user->name = 'Joe';
     *      $user->gender = 'm';
     *      $user->age = 19;
     *      $user->create();
     */
    public function create($data=null, $whiteList=null) {
        return parent::create($data, $whiteList);
    }

    /** Updates a model instance.
     * If the instance doesn’t exist it will throw an exception.
     * @return  boolean     Returning true on success or false otherwise.
     *
     * Example:
     *
     *      $user = users::findOne(array("name='Joe'"));
     *      $user->name = 'Bob';
     *      $user->update();
     */
    public function update($data=null, $whiteList=null) {
        return parent::update($data, $whiteList);
    }

    /** Inserts or updates a model instance.
     * @return      boolean     Returning true on success or false otherwise.
     *
     * Example:
     *      //Creating a new user
     *      $user = new Users();
     *      $user->name = 'Joe';
     *      $user->gender = 'm';
     *      $user->age = 19;
     *      $user->save();
     *
     *      //Updating a user name
     *      $user = Users::findOne("id=100");
     *      $user->name = "Bob";
     *      $user->save();
     *
     *      //Giving array params
     *      $user->save(array('name'=>'Bob', 'age'=>10));
     */
    public function save($data=null, $whiteList=null) {
        return parent::save($data, $whiteList);
    }

    /** Deletes a model instance.
     * @return      boolean     Returning true on success or false otherwise.
     *
     * Example:
     *      $user = Users::findOne("id=100");
     *      $user->delete();
     */
    public function delete() {
        return parent::delete();
    }

    /** Returns all the validation messages.
     * @param   string  $type   错误类型(InvalidUpdateAttempt)
     *
     * Example:
     *      // 获取所有错误信息
     *      $mod->getErrorMessages();
     *
     *      // 获取更新数据时的错误信息
     *      $mod->getErrorMessage('InvalidUpdateAttempt');
     */
    public function getErrorMessages($type=null) {
        $msg = array();
        foreach($this->getMessages() as $message) {
            if(is_null($type) || ($message->getType() === $type)) {
                $msg[] = $message->getMessage();
            }
        }

        return join(PHP_EOL, $msg);
    }

    /** Serializes the object ignoring connections, services, related objects or static properties. */
    public function serialize() {
        return parent::serialize();
    }

    /** Unserializes the object from a serialized string.
     * @param   string  $data   the serialized string of object.
     */
    public function unserialize($data) {
        return parent::unserialize($data);
    }

    /** Returns the instance as an array representation
     * @param   array   $columns    返回的字段，默认返回全部字段
     *
     * Example:
     *      $user = Users::findOne(array("id=100"));
     *      $user->toArray(array("name", "age"));
     */
    public function toArray($columns=null) {
        return parent::toArray($columns);
    }

    /** Returns the object that can be used with var_dump.
     *
     * Example:
     *      $user = Users::findOne(array("id=100"));
     *      var_dump($user->dump());
     */
    public function dump() {
        return parent::dump();
    }
}