<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeysToCartTable extends Migration
{
    public function up()
    {
        $this->db->query('ALTER TABLE cart ADD CONSTRAINT cart_user_id_foreign FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE cart ADD CONSTRAINT cart_product_id_foreign FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('cart', 'cart_user_id_foreign');
        $this->forge->dropForeignKey('cart', 'cart_product_id_foreign');
    }
}
