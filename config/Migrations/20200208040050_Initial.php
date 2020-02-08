<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('results')
            ->addColumn('job_processing_uid', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('test_type_uid', 'integer', [
                'default' => null,
                'limit' => 5,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('test_counter', 'integer', [
                'default' => null,
                'limit' => 5,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['job_processing_uid', 'test_type_uid', 'test_counter'])
            ->addColumn('number', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('country', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('start_time', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('end_time', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('connect_time', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('score', 'float', [
                'default' => null,
                'null' => true,
                'precision' => 5,
                'scale' => 2,
                'signed' => false,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 1024,
                'null' => true,
            ])
            ->addColumn('added_by', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('added_on', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'tinyinteger', [
                'default' => '1',
                'limit' => 2,
                'null' => true,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'added_by',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 512,
                'null' => false,
            ])
            ->addColumn('admin', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('status', 'tinyinteger', [
                'default' => '0',
                'limit' => 2,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created_by', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created_on', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'email',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'created_by',
                ]
            )
            ->create();

        $this->table('results')
            ->addForeignKey(
                'added_by',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();

        $this->table('users')
            ->addForeignKey(
                'created_by',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('results')
            ->dropForeignKey(
                'added_by'
            )->save();

        $this->table('users')
            ->dropForeignKey(
                'created_by'
            )->save();

        $this->table('results')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
