<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	protected $name = 'users';

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
			'display_name'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'img'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
				'default'    => '/img/default/profile.jpg'
			],
			'email'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '150',
			],
			'username'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '75',
			],
			'password'	=> [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			]
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
