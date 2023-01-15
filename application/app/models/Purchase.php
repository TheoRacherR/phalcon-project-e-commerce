<?php

use \Phalcon\Mvc\Model;

class Purchase extends Model
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
    public $id_account;

    /**
     *
     * @var integer
     */
    public $total_price;

    /**
     *
     * @var string
     */
    public $purchase_at;

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
        $this->setSource("purchase");

        $this->hasManyToMany(
            'id',
            ProductXPurchase::class,
            'id_product',
            'id_purchase',
            Purchase::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'product',
            ]
        );

        $this->hasMany(
            'id',
            ProductXPurchase::class,
            'id_product',
            [
                'reusable' => true,
                'alias'    => 'productxpurchase'
            ]
        );


        $this->belongsTo(
            'id_account',
            Account::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'account'
            ]
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Purchase[]|Purchase|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Purchase|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
