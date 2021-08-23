<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clients extends Migration
{
	protected $name = 'clients';

	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'BIGINT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'name'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'surname'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'display'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
				'null'       => true
			],
			'phone1'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true
			],
			'phone2'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true
			],
			'email1'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true
			],
			'email2'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '150',
			],
			'ruc'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '150',
				'null'       => true
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addField("created_at DATETIME NULL DEFAULT NULL");
		$this->forge->addField("updated_at DATETIME NULL DEFAULT NULL");
		$this->forge->addField("deleted_at DATETIME NULL DEFAULT NULL");
		$this->forge->createTable($this->name);
	}

	public function down()
	{
		$this->forge->dropTable($this->name);
	}
}
