<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Cloumn_logining extends CI_Migration {

    public function up()
    {
       	$sql = "alter table user add login_status_id int";
       	$this->db->query($sql);
    }

    public function down()
    {
        
    }
}
?>