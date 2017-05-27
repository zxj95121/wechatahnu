<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Blog extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'blog_id' => array(
                'type' => 'INT',//类型
                'constraint' => 5,//长度
                'unsigned' => TRUE,//无符号
                'auto_increment' => TRUE,//自增
                'unique' => TRUE,//主键
                'comment' => '主键'//注释说明
            ),
            'blog_title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'blog_description' => array(
                'type' => 'TEXT',
                'null' => TRUE,//TRUE表示允许为空，不为空不需要写此项
            )
        ));
        
        $this->dbforge->create_table('blog');
        $sql = 'create table students
          (
              id int unsigned not null auto_increment primary key,
              name char(8) not null,
              sex char(4) not null,
              age tinyint unsigned not null,
              tel char(13) null default "-"
          )engine=innodb,charset=utf8';
        $this->db->query($sql);
    }

    public function down()
    {
        
    }
}
?>