<?php
/**
 * @see       https://github.com/zendframework/zend-barcode for the canonical source repository
 * @copyright Copyright (c) 2005-2019 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-barcode/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Barcode\ZendObject\TestAsset;

class Error extends \Zend\Barcode\ZendObject\Error
{
    public function getType()
    {
        return $this->type;
    }
}
