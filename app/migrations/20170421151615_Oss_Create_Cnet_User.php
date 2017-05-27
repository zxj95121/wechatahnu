<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Oss_Create_Cnet_User extends CI_Migration {

    public function up()
    {
        $sql = 'create table cnet_user(
            id int unsigned not null auto_increment primary key,
            openid varchar(255) not null,
            username varchar(30) not null,
            password varchar(255) not null,
            status tinyint not null default "1" comment "1表示可用，0表示不可用",
            ep_time int not null default "1000" comment "上次修改密码的时间",
            time int not null
        )engine=innodb,charset=utf8';
        $this->db->query($sql);
    }

    public function down()
    {
        
    }
}
?>