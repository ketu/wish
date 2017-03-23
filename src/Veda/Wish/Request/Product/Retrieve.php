<?php
/**
 * User: ketu.lai <ketu.lai@gmail.com>
 * Date: 2017/3/22 16:59
 */

namespace Veda\Wish\Request\Product;

use Veda\Wish\Request\RequestAbstract;

class Retrieve extends RequestAbstract
{
    protected $endpoint = 'product';

    protected $method = parent::HTTP_METHOD_GET;


    /**
     * set item id
     * @param $id
     */
    public function setId($id)
    {
        $this->setParameter('id', $id);
    }

    /**
     * Set parent sku
     * @param $sku
     */
    public function setParentSku($sku)
    {
        $this->setParameter('parent_sku', $sku);
    }

}