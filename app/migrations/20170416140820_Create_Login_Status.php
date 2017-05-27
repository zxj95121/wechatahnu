<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Login_Status extends CI_Migration {

    public function up()
    {
       	$sql = 'create table login_status(
            id int unsigned not null auto_increment primary key,
            name varchar(255) not null,
            status tinyint not null default "1" comment "1表示可用，2表示已用",
            time int not null
        )engine=innodb,charset=utf8';
        $this->db->query($sql);
    }

    public function down()
    {
        
    }
}
?>