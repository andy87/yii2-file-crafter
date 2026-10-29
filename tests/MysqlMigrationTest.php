<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests;

use Yii;
use yii\db\Migration;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;
use andy87\yii2\file_crafter\tests\core\ApplicationTestCore;

/** Runs the data-loss regression against an explicitly configured disposable MySQL database. */
class MysqlMigrationTest extends ApplicationTestCore
{
    /** @var string[] Random table names created exclusively by this test. */
    private array $tables = [];

    /**
     * Configure MySQL only when an integration-test DSN is supplied.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $dsn = getenv('FILE_CRAFTER_TEST_MYSQL_DSN');
        if (!$dsn) $this->markTestSkipped('Set FILE_CRAFTER_TEST_MYSQL_DSN to enable MySQL integration tests.');

        Yii::$app->set('db', [
            'class' => \yii\db\Connection::class,
            'dsn' => $dsn,
            'username' => getenv('FILE_CRAFTER_TEST_MYSQL_USER') ?: 'root',
            'password' => getenv('FILE_CRAFTER_TEST_MYSQL_PASSWORD') ?: '',
            'charset' => 'utf8mb4',
        ]);
    }

    /** @return void Remove only the randomly named tables created by this test. */
    protected function tearDown(): void
    {
        try {
            foreach ($this->tables as $table) {
                Yii::$app->db->createCommand('DROP TABLE IF EXISTS ' . Yii::$app->db->quoteTableName($table))->execute();
            }
        } finally {
            parent::tearDown();
        }
    }

    /** @return void A conflicting migration preserves rows; a new migration supports quoted metadata and enum/set values. */
    public function testGeneratedMigrationPreservesRowsAndCreatesNewTable(): void
    {
        $existing = 'fc_existing_' . bin2hex(random_bytes(6));
        $new = 'fc_new_' . bin2hex(random_bytes(6));
        $this->tables = [$existing, $new];
        Yii::$app->db->createCommand()->createTable($existing, ['title' => 'varchar(64)'])->execute();
        Yii::$app->db->createCommand()->insert($existing, ['title' => 'keep this row'])->execute();

        $migration = $this->createMigration($existing);
        ob_start();
        try {
            $result = $migration->up();
        } finally {
            ob_end_clean();
        }
        $this->assertFalse($result);
        $this->assertSame(['keep this row'], Yii::$app->db->createCommand('SELECT title FROM ' . Yii::$app->db->quoteTableName($existing))->queryColumn());

        $this->assertNull($this->createMigration($new)->up());
        $table = Yii::$app->db->getTableSchema($new, true);
        $this->assertSame("Owner's name", $table->columns['title']->comment);
        Yii::$app->db->createCommand()->insert($new, ['title' => 'new row', 'choice' => "owner's", 'choices' => "owner's"])->execute();
        $this->assertSame("owner's", Yii::$app->db->createCommand('SELECT choice FROM ' . Yii::$app->db->quoteTableName($new))->queryScalar());
    }

    /**
     * Generate and load the actual package migration with no tableOptions override.
     * @param string $tableName Random table owned by this test.
     * @return Migration Generated migration ready for execution.
     */
    private function createMigration(string $tableName): Migration
    {
        $schema = (new SchemaProducer([]))->create([
            'name' => $tableName,
            'db_fields' => [
                'title' => ['name' => 'title', 'type' => 'string', 'size' => 64, 'comment' => "Owner's name"],
                'choice' => ['name' => 'choice', 'type' => 'enum', 'values' => ["owner's", 'other']],
                'choices' => ['name' => 'choices', 'type' => 'set', 'values' => ["owner's", 'other']],
            ],
        ]);
        $files = $this->createCrafter()->generate([$schema]);
        $path = $this->testRoot . '/' . basename($files[0]->path);
        file_put_contents($path, $files[0]->content);
        require $path;
        $class = pathinfo($path, PATHINFO_FILENAME);

        return new $class(['db' => Yii::$app->db, 'compact' => true]);
    }
}
