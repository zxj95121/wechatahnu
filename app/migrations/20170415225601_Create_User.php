<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_User extends CI_Migration {

    public function up()
    {
        $sql = 'create table user(
          id int unsigned not null auto_increment primary key,
              openid varchar(255) not null,
              password varchar(255) not null,
              power_id int unsigned not null default "0",
              status tinyint not null default "1",
              created_time datetime not null
          )engine=innodb,charset=utf8';
        $this->db->query($sql);
    }

    public function down()
    {
        
    }
}
?>