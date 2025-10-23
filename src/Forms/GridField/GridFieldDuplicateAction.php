<?php

namespace SwiftDevLabs\DuplicateDataObject\Forms\GridField;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;

class GridFieldDuplicateAction implements GridField_ColumnProvider,	GridField_ActionProvider
{

	#[\Override]
	public function augmentColumns($gridField, &$columns)
	{
		if (! in_array('Actions', $columns))
		{
			$columns[] = 'Actions';
		}
	}

	#[\Override]
	public function getColumnAttributes($gridField, $record, $columnNamme)
	{
		return ['class' => 'grid-field__col-compact'];
	}

	#[\Override]
	public function getColumnMetadata($gridField, $columnName)
	{
		if ($columnName == 'Actions')
		{
			return ['title' => ''];
		}
	}

	#[\Override]
	public function getColumnsHandled($gridField)
	{
		return ['Actions'];
	}

	#[\Override]
	public function getColumnContent($gridField, $record, $columnName)
	{
		if (!$record->canEdit()) return;

		$field = GridField_FormAction::create(
			$gridField,
			'DuplicateAction' . $record->ID,
			false,
			"duplicateobject",
			['RecordID' => $record->ID]
		)
			->addExtraClass('gridfield-button-duplicate btn--icon-md font-icon-page-multiple btn--no-text grid-field__icon-action')
			->setAttribute('title', 'Duplicate ' . $record->singular_name())
			->setDescription('Duplicate ' . $record->singular_name());

		return $field->Field();
	}

	#[\Override]
	public function getActions($gridField)
	{
		return ['duplicateobject'];
	}

	#[\Override]
	public function handleAction(GridField $gridField, $actionName, $arguments, $data)
	{
		if ($actionName == 'duplicateobject')
		{
			$item = $gridField->getList()->byID($arguments['RecordID']);

			$clone = $item->duplicate();

			Controller::curr()->getResponse()->setStatusCode(
				200,
				"{$item->Title} Duplicated"
			);
		}
	}
}
