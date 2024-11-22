<?php

namespace app\common\components;

/**
 * < Common > Class Action
 *
 * @package app\common\components
 *
 * @tag: #action
 */
class Action
{
    /** @var string $INDEX */
    public const INDEX = 'index';

    /** @var string $VIEW */
    public const VIEW = 'view';

    /** @var string $CREATE */
    public const CREATE = 'create';

    /** @var string $UPDATE */
    public const UPDATE = 'update';

    /** @var string $DELETE */
    public const DELETE = 'delete';

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