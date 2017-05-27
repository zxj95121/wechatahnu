<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Delete_Blog extends CI_Migration {

    public function up()
    {
      $this->dbforge->drop_table('blog');
        $this->dbforge->drop_table('students');
    }

    public function down()
    {
        
    }
}
?>