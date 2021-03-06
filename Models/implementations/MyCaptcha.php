<?php
/**
 * User: John
 * Date: 1.4.2017
 * Time: 4:26
 */

namespace MyCaptcha\Models;

require_once __DIR__ . "/../contracts/MyCaptchaInterface.php";

use MyCaptcha\Generators\ImageGeneratorInterface;
use MyCaptcha\Generators\PhraseGeneratorInterface;

class MyCaptcha implements MyCaptchaInterface
{

    private $image;
    private $phrase;

    private $phraseLength;
    private $widthPx;
    private $heightPx;
    private $backgroundImage;
    private $phraseGenerator;
    private $imageGenerator;

    /**
     * MyCaptcha constructor.
     * @param int $phraseLength
     * @param int $widthPx
     * @param int $heightPx
     * @param $backgroundImage
     * @param PhraseGeneratorInterface $phraseGenerator
     * @param ImageGeneratorInterface $imageGenerator
     */
    function __construct($phraseLength, $widthPx, $heightPx, $backgroundImage, PhraseGeneratorInterface $phraseGenerator, ImageGeneratorInterface $imageGenerator)
    {
        $this->phraseLength = $phraseLength;
        $this->widthPx = $widthPx;
        $this->heightPx = $heightPx;
        $this->backgroundImage = $backgroundImage;
        $this->phraseGenerator = $phraseGenerator;
        $this->imageGenerator = $imageGenerator;
    }

    /**
     * @return resource
     */
    public function getImage()
    {
        //TODO think about and implement better
        if ($this->heightPx <= 10 || $this->widthPx <= 10) {
            throw new \InvalidArgumentException("Min dimensions 10x10");
        }
        if (isset($this->image)) {
            return $this->image;
        }
        return $this->image = $this->imageGenerator->generate($this->widthPx, $this->heightPx, $this->getPhrase());
    }

    /**
     * @return string
     */
    public function getPhrase()
    {
        if (isset($this->phrase)) {
            return $this->phrase;
        }
        return $this->phrase = $this->phraseGenerator->generate();
    }

}