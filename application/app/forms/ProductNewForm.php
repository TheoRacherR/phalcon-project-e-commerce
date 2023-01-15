<?php

namespace PhalconDemo\Forms;

use Category;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;

use Phalcon\Models\ProductTypes;

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;

class ProductNewForm extends Form
{
    /**
     * Initialize the product form
     *
     * @param mixed $entity
     * @param array $options
     */
    public function initialize()
    {


        $name = new Text("name");
        $name->setLabel("Name");
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([new PresenceOf(['message' => 'The name is required'])]);
        $this->add($name);

        $description = new Text("description");
        $description->setLabel("Description");
        $description->setFilters(['striptags', 'string']);
        $description->addValidators([new PresenceOf(['message' => 'The description is required'])]);
        $this->add($description);

        $picture_url = new Text("picture_url");
        $picture_url->setLabel("Picture URL");
        $picture_url->setFilters(['striptags', 'string']);
        $picture_url->addValidators([new PresenceOf(['message' => 'The picture url is required'])]);
        $this->add($picture_url);

        $subcat = new Select('name', Category::find(), [
            'using'      => ['id', 'name'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $subcat->setLabel('Sub Category');
        $this->add($subcat);

    }
}