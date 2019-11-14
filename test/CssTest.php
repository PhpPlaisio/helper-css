<?php
declare(strict_types=1);

namespace Plaisio\Helper\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\Helper\Css;
use SetBased\Exception\FallenException;

/**
 * Test cases for class Css.
 */
class CssTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns test cases for method txt2CssString with single quotes.
   *
   * @return array
   */
  public function cases1(): array
  {
    $cases = [];

    // Test for white space.
    $cases[] = ['string'   => "\n\r\f\t\0",
                'expected' => "'\A \D \C \9 \\0 '"];

    // Test for white space.
    $cases[] = ['string'   => "The backslash (\) is a typographical mark used mainly in computing and is the mirror image of the common slash (/)",
                'expected' => "'The backslash (\\\\) is a typographical mark used mainly in computing and is the mirror image of the common slash (/)'"];

    // Test with single quotes.
    $cases[] = ['string'   => "Didn't she say 'I like red best' when I asked her wine preferences?",
                'expected' => "'Didn\'t she say \'I like red best\' when I asked her wine preferences?'"];

    // Test with double quotes.
    $cases[] = ['string'   => 'The "fresh" apples were full of worms.',
                'expected' => "'The \"fresh\" apples were full of worms.'"];

    // Don't changes other non ASCII characters,
    $cases[] = ['string'   => 'Апостроф',
                'expected' => "'Апостроф'"];

    return $cases;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns test cases for method txt2CssString with double quotes.
   *
   * @return array
   */
  public function cases2(): array
  {
    $cases = [];

    // Test for white space.
    $cases[] = ['string'   => "\n\r\f\t\0",
                'expected' => "\"\A \D \C \9 \\0 \""];

    // Test for white space.
    $cases[] = ['string'   => "The backslash (\) is a typographical mark used mainly in computing and is the mirror image of the common slash (/)",
                'expected' => "\"The backslash (\\\\) is a typographical mark used mainly in computing and is the mirror image of the common slash (/)\""];

    // Test with single quotes.
    $cases[] = ['string'   => "Didn't she say 'I like red best' when I asked her wine preferences?",
                'expected' => "\"Didn't she say 'I like red best' when I asked her wine preferences?\""];

    // Test with double quotes.
    $cases[] = ['string'   => 'The "fresh" apples were full of worms.',
                'expected' => "\"The \\\"fresh\\\" apples were full of worms.\""];

    // Don't changes other non ASCII characters,
    $cases[] = ['string'   => 'Апостроф',
                'expected' => "\"Апостроф\""];

    return $cases;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test with illegal quotation constant.
   */
  public function testIllegalQuotation()
  {
    Css::$quote = 3;

    $this->expectException(FallenException::class);
    Css::txt2CssString('Hello, world.');
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method txt2CssString with single quote.
   *
   * @param string|null $text     The text to be escaped.
   * @param string      $expected The expected value.
   *
   * @dataProvider cases1
   */
  public function testTxt2CssString1(?string $text, string $expected): void
  {
    Css::$quote = Css::SINGLE_QUOTE;

    $string = Css::txt2CssString($text);
    self::assertSame($expected, $string);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method txt2CssString with double quotes.
   *
   * @param string|null $text     The text to be escaped.
   * @param string      $expected The expected value.
   *
   * @dataProvider cases2
   */
  public function testTxt2CssString2(?string $text, string $expected): void
  {
    Css::$quote = Css::DOUBLE_QUOTE;

    $string = Css::txt2CssString($text);
    self::assertSame($expected, $string);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
