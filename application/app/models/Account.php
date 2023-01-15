<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use \Phalcon\Mvc\Model;

class Account extends Model
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
    public $id_cart;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var integer
     */
    public $role;

    /**
     *
     * @var string
     */
    public $address;

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
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Please enter a correct email address',
                ]
            )
        );

        return $this->validate($validator);
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon_app");
        $this->setSource("account");

        $this->belongsTo(
            'id_cart',
            Cart::class,
            'id',
            [
                'reusable' => true,
                'alias'    => 'cart'
            ]
        );

        $this->hasMany(
            'id',
            Product::class,
            'id_owner',
            [
                'reusable' => true,
                'alias'    => 'product'
            ]
        );

        $this->hasMany(
            'id',
            Review::class,
            'id_account',
            [
                'reusable' => true,
                'alias'    => 'review'
            ]
        );

        $this->hasMany(
            'id',
            Purchase::class,
            'id_account',
            [
                'reusable' => true,
                'alias'    => 'purchase'
            ]
        );

        $this->hasMany(
            'id',
            Delivery::class,
            'id_account',
            [
                'reusable' => true,
                'alias'    => 'delivery'
            ]
        );

        $this->hasMany(
            'id',
            Returned::class,
            'id_account',
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
     * @return Account[]|Account|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Account|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
