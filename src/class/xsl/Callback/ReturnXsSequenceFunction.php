<?php
namespace Genkgo\Xsl\Callback;

use DOMNode;
use Genkgo\Xsl\Xpath\Lexer;

/**
 * Class ReturnXsSequenceFunction
 * @package Genkgo\Xsl\Callback
 */
final class ReturnXsSequenceFunction implements ReplaceFunctionInterface
{
    /**
     * @var ReplaceFunctionInterface
     */
    private $parentFunction;

    /**
     * @param ReplaceFunctionInterface $parentFunction
     */
    public function __construct(ReplaceFunctionInterface $parentFunction)
    {
        $this->parentFunction = $parentFunction;
    }

    /**
     * @param Lexer $lexer
     * @param DOMNode $currentElement
     * @return array
     */
    public function replace(Lexer $lexer, DOMNode $currentElement)
    {
        $resultTokens = $this->parentFunction->replace($lexer, $currentElement);

        $currentKey = $lexer->key();
        $level = 1;

        while (true) {
            $item = $lexer->peek($currentKey + 1);

            if ($item === null) {
                break;
            }

            if ($item === '(') {
                $level++;
            }

            if ($item === ')') {
                $level--;

                if ($level === 0) {
                    $lexer->insert(['/', 'xs:sequence', '/', '*'], $currentKey + 2);
                    break;
                }
            }

            $currentKey++;
        }

        return $resultTokens;
    }
}
