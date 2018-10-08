<?php
namespace Genkgo\Xsl\Callback;

use Genkgo\Xsl\TransformationContext;

/**
 * Interface MethodCallInterface
 * @package Genkgo\Xsl\Callback
 */
interface MethodCallInterface
{
    /**
     * @param $arguments
     * @param TransformationContext $context
     * @return mixed
     */
    public function call($arguments, TransformationContext $context);
}
