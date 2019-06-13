<?php
namespace Test\Helpers;

use PHPUnit\Framework\TestCase;
use App\Helpers\Text;

class TextTest extends TestCase
{

    public function testExcerptDefault()
    {
        $text = "Mauris sit amet leo dui. Phasellus id ex vitae diam gravidaa eleifend integer gravida, est tincidunt consectetur viverra, ante nibh posuere tortor, non interdum est velit eget dui.";
        $this->assertEquals('Mauris sit amet leo dui. Phasellus id ex vitae diam gravidaa...', Text::excerpt($text)); // 60 default
    }

    public function testExcerptLimit50()
    {
        $text = "Mauris sit amet leo dui. Phasellus id ex vitae diam gravida eleifend integer gravida, est tincidunt consectetur viverra, ante nibh posuere tortor, non interdum est velit eget dui.";
        $this->assertEquals('Mauris sit amet leo dui. Phasellus id ex vitae diam...', Text::excerpt($text, 50));
    }

    public function testExcerptShortTextLimit()
    {
        $text = "Mauris sit";
        $this->assertEquals('Mauris sit', Text::excerpt($text, 100));
    }

    public function testExcerptDefaultWithWhiteSpace()
    {
        $text = "Mauris sit amet leo dui. Phasellus id ex vitae diam gravida eleifend integer gravida, est tincidunt consectetur viverra, ante nibh posuere tortor, non interdum est velit eget dui.";
        $this->assertEquals('Mauris sit amet leo dui. Phasellus id ex vitae diam gravida...', Text::excerpt($text));
    }

    public function testExcerpt50NoSpace()
    {
        $text = "MaurissitametleoduixPhasellusidexvitaegravidaeleifendintegergravideesttinciduntconsecteturviverraeantenibhposueretortorenoninterdumestvelitegetduie";
        $this->assertEquals('MaurissitametleoduixPhasellusidexvitaegravidaeleif...', Text::excerpt($text, 50));
    }

    public function testExcerptDefaultWithHtml()
    {
        $text = "<h1>Mauris sit</h1> amet leo dui. <p>Phasellus id ex vitae diam</p> gravidaa eleifend <section>integer gravidaa est tincidunt consectetur viverra, ante nibh posuere tortor, non interdum est velit eget dui.</section>";
        $this->assertEquals('Mauris sit amet leo dui. Phasellus id ex vitae diam gravidaa...', Text::excerpt($text));
    }

}