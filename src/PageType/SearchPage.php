<?php

namespace Somar\Search\PageType;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use Somar\Search\Control\SearchPageController;

class SearchPage extends Page
{
    private static $table_name = 'SearchPage';

    private static $db = [
        'SearchType' => 'Varchar(255)'
    ];

    private static $icon_class = 'font-icon-p-search';
    private static $disable_indexing = true;

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $searchTypesConfig = $this->config()->get('searchTypes');

            if (!empty($searchTypesConfig)) {
                $searchTypes = array_map(fn ($type) => $type['name'], $searchTypesConfig);
                $fields->addFieldToTab(
                    'Root.Main',
                    DropdownField::create(
                        'SearchType',
                        $this->fieldLabel('SearchType'),
                        $searchTypes
                    )->setEmptyString('Default')
                );
            }
        });

        return parent::getCMSFields();
    }


    public function getControllerName()
    {
        return SearchPageController::class;
    }
}
