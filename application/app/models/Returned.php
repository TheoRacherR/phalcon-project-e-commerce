<?php

use \Phalcon\Mvc\Model;

class Returned extends Model
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
        $this->setSource("returned");

        $this->hasManyToMany(
            'id',
            ProductXReturn::class,
            'id_product',
            'id_return',
            Returned::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'product',
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
     * @return Returned[]|Returned|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Returned|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
