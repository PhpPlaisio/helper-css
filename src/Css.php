<?php
declare(strict_types=1);

namespace Plaisio\Helper;

use SetBased\Exception\FallenException;

/**
 * A utility class for generating proper escaped CSS string.
 */
class Css
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Use single quotes for quoting strings.
   */
  const SINGLE_QUOTE = 1;

  /**
   * Use double quotes for quoting strings.
   */
  const DOUBLE_QUOTE = 2;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Either ' or " for quoting strings.
   *
   * @var int
   */
  public static int $quote = self::SINGLE_QUOTE;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns a string with special characters escaped such that it can be safely used in CSS as a string.
   *
   * @param string|null $string The string with optionally special characters.
   *
   * @return string
   *
   * @since 1.0.0
   * @api
   */
  public static function txt2CssString(?string $string): string
  {
    $quote = self::quote();

    if ($string===null || $string==='') return $quote.$quote;

    $ret = $quote;

    $n = mb_strlen($string);
    for ($i = 0; $i<$n; $i++)
    {
      $char = mb_substr($string, $i, 1);
      switch ($char)
      {
        case "\n":
          $ret .= '\A ';
          break;

        case "\r":
          $ret .= '\D ';
          break;

        case "\f":
          $ret .= '\C ';
          break;

        case "\t":
          $ret .= '\9 ';
          break;

        case "\0":
          $ret .= '\0 ';
          break;

        case $quote:
          $ret .= '\\';
          $ret .= $quote;
          break;

        case '\\':
          $ret .= '\\';
          $ret .= $char;
          break;

        default:
          // According to the specifications all other characters can be used safely in a string. See
          // https://www.w3.org/TR/css-syntax-3/#consume-a-string-token and
          // https://www.w3.org/TR/css-syntax-3/#typedef-string-token.
          $ret .= $char;
      }
    }

    $ret .= $quote;

    return $ret;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns the desired character (i.e. a single or double quote) for quoting strings.
   *
   * @return string
   */
  private static function quote(): string
  {
    switch (self::$quote)
    {
      case self::SINGLE_QUOTE:
        return '\'';

      case self::DOUBLE_QUOTE:
        return '"';

      default:
        throw new FallenException('quote', self::$quote);
    }
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
