<?php

use \Phalcon\Mvc\Model;

class Category extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $child_category;

    /**
     *
     * @var integer
     */
    public $parent_category;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $create_at;

    /**
     *
     * @var string
     */
    public $update_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_app");
        $this->setSource("category");


        $this->belongsTo(
            'parent_category',
            Category::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'parentcategory'
            ]
        );

        $this->hasMany(
            'id',
            Product::class,
            'child_category',
            [
                'reusable' => true,
                'alias'    => 'childcategory'
            ]
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category[]|Category|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Category|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
