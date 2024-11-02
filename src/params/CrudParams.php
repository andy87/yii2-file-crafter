<?php

namespace andy87\yii2\dnk_file_crafter\params;

use andy87\yii2\dnk_file_crafter\core\Params;

/**
 * 
 */
class CrudParams extends Params
{
    const VIEW_WIDGET_GRID_VIEW = 'grid';
    const VIEW_WIDGET_LIST_VIEW = 'list';


    private string $modelClass;
    private string $searchModelClass;
    private string $controllerClass;
    private string $viewPath;
    private string $baseControllerClass;
    private string $viewWidget = self::VIEW_WIDGET_GRID_VIEW;
    private bool $enableI18n = false;
    private bool $enablePjax = false;
    private string $codeTemplate;


    /**
     * @return array
     */
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