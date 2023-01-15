<?php

use \Phalcon\Mvc\Model;

class ProductXReturn extends odel
{

    /**
     *
     * @var integer
     */
    public $id_product;

    /**
     *
     * @var integer
     */
    public $id_return;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_app");
        $this->setSource("product_x_return");

        $this->belongsTo(
            'id_product',
            Product::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'product'
                ]
        );

        $this->belongsTo(
            'id_return',
            Returned::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'return'
            ]
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductXReturn[]|ProductXReturn|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductXReturn|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
