<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\components\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;

/**
 * SchemaDto
 *
 * @package andy87\yii2\file_crafter\models
 *
 * @tag: #model #table #info
 */
class Schema extends Model
{
    // Scenarios
    /** @var string */
    public const SCENARIO_DEFAULT = self::SCENARIO_CREATE;

    /** @var string */
    public const SCENARIO_CREATE = 'create';

    /** @var string */
    public const SCENARIO_UPDATE = 'update';

    /** @var string */
    public const SCENARIO_REMOVE = 'remove';

    /** @var string */
    public const SCENARIO_PARSE_DB = 'parse_db';


    /** @var string */
    public const NAME = 'name';

    /** @var string */
    public const TABLE_NAME = 'table_name';

    /** @var string */
    public const CUSTOM_FIELDS = 'custom_fields';

    /** @var string */
    public const DB_FIELDS = 'db_fields';

    const TEMPLATE = 'template';


    /** @var string */
    public string $scenario = self::SCENARIO_DEFAULT;

    /** @var string */
    public string $name = '';

    /** @var string */
    public string $table_name = '';

    /** @var Field[] */
    public array $db_fields = [];

    /** @var string Для вывода ошибок по шаблонам */
    public string $template = '';

    private array $autoCompleteData = [
        Schema::NAME => [
            'account',
            'activity',
            'admin',
            'affiliate',
            'answer',
            'article',
            'attendance',
            'attendee',
            'audit',
            'award',
            'backup',
            'bank',
            'billing',
            'blog',
            'bonus',
            'budget',
            'call',
            'card',
            'cart',
            'category',
            'charity',
            'chat',
            'city',
            'claim',
            'comment',
            'commission',
            'config',
            'conference',
            'contract',
            'country',
            'coupon',
            'cron',
            'currency',
            'customer',
            'document',
            'donation',
            'district',
            'employee',
            'estimate',
            'event',
            'exchange',
            'expense',
            'facility',
            'faq',
            'feedback',
            'file',
            'fundraiser',
            'gift',
            'goal',
            'group',
            'help',
            'holiday',
            'image',
            'inventory',
            'invoice',
            'issue',
            'knowledge',
            'leaderboard',
            'leave',
            'live',
            'location',
            'log',
            'login',
            'logout',
            'media',
            'meeting',
            'member',
            'message',
            'milestone',
            'module',
            'news',
            'newsletter',
            'notification',
            'objective',
            'order',
            'page',
            'payroll',
            'payment',
            'permission',
            'post',
            'presentation',
            'product',
            'project',
            'provider',
            'purchase',
            'quiz',
            'rate',
            'rating',
            'receipt',
            'refund',
            'region',
            'report',
            'resource',
            'review',
            'role',
            'salary',
            'sales',
            'schedule',
            'score',
            'security',
            'seat',
            'session',
            'setting',
            'shipment',
            'shipping',
            'shift',
            'solution',
            'speaker',
            'sponsor',
            'state',
            'subscription',
            'subscriber',
            'support',
            'survey',
            'tag',
            'task',
            'tax',
            'team',
            'ticket',
            'timesheet',
            'topic',
            'transaction',
            'user',
            'user_permission',
            'user_role',
            'venue',
            'video',
            'visitor',
            'volunteer',
            'voucher',
            'wallet',
            'warehouse',
            'warranty',
            'webinar',
            'work',
        ]
    ];


    /**
     * Custom fields, setup on config:
     * ```
     *      $config['modules']['gii'] = [
     *          'class' => yii\gii\Module::class,
     *          'generators' => [
     *              'fileCrafter' => [
     *                  'class' => Crafter::class,
     *                  'params' => [
     *                      'custom_fields' => [
     *                          'key_1' => 'label #1',
     *                          'keyTwo' => 'header 2',
     *                      ],
     *                  ],
     *             ],
     *          ]
     *      ];
     * ```
     * use on template:
     * ```
     *
     * <?= $generator->custom_fields['key_1']; ?>
     *
     * ```
     * @var array
     */
    public array $custom_fields = [];




    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [ [self::NAME], 'required' ],
            [ [self::TABLE_NAME,self::NAME], 'string', 'max' => 255 ],
            [ [self::CUSTOM_FIELDS, self::DB_FIELDS ], 'safe'],
            [ [self::CUSTOM_FIELDS, self::DB_FIELDS], 'each', 'rule' => ['safe'] ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            self::NAME => 'Schema name',
            self::TABLE_NAME => 'table name',
            self::CUSTOM_FIELDS => 'Custom fields',
            self::DB_FIELDS => 'Fields database',
        ];
    }

    /**
     * Set auto complete data
     *
     * @param string $field
     * @param array $data
     *
     * @return void
     */
    public function setAutoCompleteData(string $field, array $data): void
    {
        $this->autoCompleteData[ $field ] = $data;
    }

    /**
     * Return template for form
     *
     * @return string
     */
    public function getTemplate(): string
    {
        $template = '{label}<br>{svg}{input}{error}{list}';

        if (empty($this->autoCompleteData[Schema::NAME])) {
            $template = str_replace('{list}', '', $template);
        }

        return $template;
    }

    /**
     * @return string
     */
    public function getUpdateHref(): string
    {
        return sprintf(
            '?%s=%s',
            self::SCENARIO_UPDATE,
            $this->getTableName()
        );
    }

    /**
     * @return bool
     */
    public function isCreate(): bool
    {
        return $this->scenario === self::SCENARIO_CREATE;
    }

    /**
     * @return array
     */
    public function getDbFields(): array
    {
        return $this->db_fields;
    }

    /**
     * @param array $generateList
     *
     * @return bool
     */
    public function isPreviewGenerate(array $generateList): bool
    {
        return isset($generateList[$this->getTableName()]);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Endpoint for get table_name
     *
     * @return string
     */
    public function getTableName(): string
    {
        return $this->table_name;
    }

    /**
     * @return array
     */
    public function getCustomFields(): array
    {
        return $this->custom_fields;
    }

    /**
     * Check on coppy
     *
     * @param string $tableName
     *
     * @return bool
     */
    public function itIs(string $tableName): bool
    {
        return $this->table_name === $tableName && empty($R->schema->errors);
    }


    /**
     * Save schema to cache file
     *
     * @param string $fileName
     *
     * @return bool
     */
    public function save(string $fileName): bool
    {
        $this->prepareCheckboxItems();

        $params = $this->attributes;

        unset($params['scenario']);

        $content = json_encode( $params, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

        return (bool) file_put_contents( Yii::getAlias($fileName), $content );
    }

    /**
     * Prepare checkbox values
     *
     * @return void
     */
    public function prepareCheckboxItems(): void
    {
        foreach ($this->db_fields as $index => $dbField)
        {
            if (isset($dbField[Field::FOREIGN_KEYS])) $this->db_fields[$index][Field::FOREIGN_KEYS] = 'checked';

            if (isset($dbField[Field::UNIQUE])) $this->db_fields[$index][Field::UNIQUE] = 'checked';

            if (isset($dbField[Field::NOT_NULL])) $this->db_fields[$index][Field::NOT_NULL] = 'checked';
        }
    }

    /**
     * @return void
     */
    public function prepareNaming(): void
    {
        $this->name = trim($this->name);

        $table_name = preg_replace('/[^a-zA-Z0-9\_\s]/', '', $this->name);
        $table_name = str_replace(' ', '_', $table_name);
        $table_name = trim($table_name, '_');

        $this->table_name = strtolower($table_name);
    }

    /**
     * Sticky attributes
     *
     * @return array
     */
    public function stickyAttributes(): array
    {
        return [
            self::NAME,
        ];
    }

    /**
     * Hints for schema
     *
     * @return array
     */
    public function hints(): array
    {
        return [
            Schema::NAME => 'Module generate filed <code>table_name</code> from this field.<br>
Example:
<pre>
{
    "name": "User ME#GA Roles LIST !!!",
    "table_name": "user_mega_roles_list",
    "custom_fields": {
        "custom_filed_key_1": "value 1",
        "custom_filed_key_2": "value 2"
    },
    "db_fields": []
}
</pre>
',
        ];
    }

    /**
     * Auto complete data
     *
     * @return array[]
     */
    public function autoCompleteData(): array
    {
        return $this->autoCompleteData;
    }

    /**
     * Get content for preview
     *
     * @return string
     */
    public function getContent(): string
    {
        $params = [ 'schema' => $this ];

        if ($this->scenario === self::SCENARIO_PARSE_DB)
        {
          try {

              $params = [
                  'table_name' => $this->table_name,
                  'fields' => $this->getSchemaTableFields($this->table_name)
              ];

          } catch (\Exception $e) {

              Yii::error([ __METHOD__,
                  'message' => $e->getMessage(),
                  'position' => $e->getFile() . ':' . $e->getLine(),
                  'trace' => $e->getTraceAsString()
              ]);
          }
        }

        return Yii::$app->view->renderFile('@vendor/andy87/yii2-file-crafter/src/views/__preview.php', $params );
    }

    /**
     * Check on can delete
     *
     * @param Options $options
     *
     * @return bool
     */
    public function canDelete(Options $options): bool
    {
        return  ( $options->canDelete && $this->scenario !== self::SCENARIO_PARSE_DB );
    }

    /**
     * Check on show preview
     *
     * @param Options $options
     *
     * @return bool
     */
    public function isShowPreview(Options $options): bool
    {
        return ($options->previewStatus);
    }

    /**
     * @param string $tableName
     *
     * @return array
     *
     * @throws Exception
     */
    private function getSchemaTableFields( string $tableName ): array
    {
        $fields = Yii::$app->db->createCommand('SHOW FULL COLUMNS FROM ' . $tableName)->queryAll();

        $result = [];

        foreach ($fields as $field) {
            $result[] = [
                Field::NAME => $field['Field'],
                Field::COMMENT => $field['Comment'],
                Field::TYPE => $field['Type'],
                Field::SIZE => $field['Type'],
                Field::FOREIGN_KEYS => $field['Key'] === 'MUL',
                Field::UNIQUE => $field['Key'] === 'UNI',
                Field::NOT_NULL => $field['Null'] === 'NO',
            ];
        }

        return $result;
    }
}