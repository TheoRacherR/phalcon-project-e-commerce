<?php

use \Phalcon\Mvc\Model;

class Product extends Model
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
    public $id_owner;

    /**
     *
     * @var integer
     */
    public $id_sub_category;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $stock;

    /**
     *
     * @var string
     */
    public $picture_url;

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
        $this->setSource("product");

        $this->hasManyToMany(
            'id',
            CartXProduct::class,
            'id_product',
            'id_cart',
            Cart::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'cart',
            ]
        );

        $this->hasMany(
            'id',
            CartXProduct::class,
            'id_product',
            [
                'reusable' => true,
                'alias'    => 'cartxproduct'
            ]
        );

        $this->hasManyToMany(
            'id',
            ProductXPurchase::class,
            'id_product',
            'id_purchase',
            Purchase::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'purchase',
            ]
        );

        $this->hasMany(
            'id',
            ProductXPurchase::class,
            'id_product',
            [
                'reusable' => true,
                'alias'    => 'productxcart'
            ]
        );

        $this->hasManyToMany(
            'id',
            ProductXReturn::class,
            'id_product',
            'id_return',
            Returned::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'return',
            ]
        );

        $this->hasMany(
            'id',
            ProductXReturn::class,
            'id_product',
            [
                'reusable' => true,
                'alias'    => 'productxreturn'
            ]
        );

        $this->belongsTo(
            'id_sub_category',
            Category::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'subcategory'
            ]
        );

        $this->belongsTo(
            'id_owner',
            Account::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'account'
            ]
        );

        $this->hasMany(
            'id',
            Review::class,
            'id_product',
            [
                'reusable' => true,
                'alias'    => 'review'
            ]
        );

    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product[]|Product|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
