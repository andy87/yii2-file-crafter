<?php declare(strict_types=1);

namespace app\common\components\enums;

/**
 * < Common > Class Action
 *
 * @package app\common\components
 *
 * @tag: #enum #action
 */
enum Action: string
{
    /** @var string $Index */
    case Index = 'index';

    /** @var string $View */
    case View = 'view';

    /** @var string $Create */
    case Create = 'create';

    /** @var string $Update */
    case Update = 'update';

    /** @var string $Delete */
    case Delete = 'delete';



    /** @var string $INDEX */
    public const INDEX = self::Index->value;

    /** @var string $VIEW */
    public const VIEW = self::View->value;

    /** @var string $CREATE */
    public const CREATE = self::Create->value;

    /** @var string $UPDATE */
    public const UPDATE = self::Update->value;

    /** @var string $DELETE */
    public const DELETE = self::Delete->value;



    /**
     * Список действий к которым устанавливается доступ по методам
     * для проверки в тестах
     *
     * @var array
     */
    const VERB = [
        self::INDEX,
        self::VIEW,
        self::CREATE,
        self::UPDATE,
        self::DELETE,
    ];
}