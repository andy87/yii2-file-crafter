<?php

namespace andy87\yii2\dnk_file_crafter\params;

use andy87\yii2\dnk_file_crafter\core\CoreParams;

/**
 * 
 */
class CrudParams extends CoreParams
{
    public const MODEL_CLASS = 'modelClass';
    public const SEARCH_MODEL_CLASS = 'searchModelClass';
    public const CONTROLLER_CLASS = 'controllerClass';
    public const VIEW_PATH = 'viewPath';
    public const BASE_CONTROLLER_CLASS = 'baseControllerClass';
    public const VIEW_WIDGET = 'viewWidget';
    public const ENABLE_I18N = 'enableI18n';
    public const ENABLE_PJAX = 'enablePjax';
    public const CODE_TEMPLATE = 'codeTemplate';


    const VIEW_WIDGET_GRID_VIEW = 'grid';
    const VIEW_WIDGET_LIST_VIEW = 'list';


    private string $modelClass;
    private string $searchModelClass;
    private string $controllerClass;
    private string $viewPath;
    private string $baseControllerClass;
    private string $viewWidget;
    private bool $enableI18n;
    private bool $enablePjax;
    private string $codeTemplate;


    public function getParams(): array
    {
        return [
            self::MODEL_CLASS => $this->modelClass,
            self::SEARCH_MODEL_CLASS => $this->searchModelClass,
            self::CONTROLLER_CLASS => $this->controllerClass,
            self::VIEW_PATH => $this->viewPath,
            self::BASE_CONTROLLER_CLASS => $this->baseControllerClass,
            self::VIEW_WIDGET => $this->viewWidget,
            self::ENABLE_I18N => $this->enableI18n,
            self::ENABLE_PJAX => $this->enablePjax,
            self::CODE_TEMPLATE => $this->codeTemplate,
        ];
    }
}