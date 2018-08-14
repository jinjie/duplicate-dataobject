# SilverStripe 4 Duplicate DataObject

Adds a duplicate button to GridField in the CMS that enables duplicating of dataobjects

## Installation 

``composer require jinjie/ss4-duplicate-dataobject``

## Usage Example

```php
$fields->fieldByName('Root.Main.MyGridField')
    ->getConfig()
    ->addComponent(new GridFieldDuplicateAction());
```