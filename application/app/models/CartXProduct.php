<?php

use \Phalcon\Mvc\Model;

class CartXProduct extends Model
{

    /**
     *
     * @var integer
     */
    public $id_cart;

    /**
     *
     * @var integer
     */
    public $id_product;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_app");
        $this->setSource("cart_x_product");

        $this->belongsTo(
            'id_cart',
            Cart::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'cart'
            ]
        );

        $this->belongsTo(
            'id_product',
            Product::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'product'
            ]
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CartXProduct[]|CartXProduct|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CartXProduct|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
