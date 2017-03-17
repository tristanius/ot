<?php

namespace Box\Spout\Writer\XLSX\Helper;

class SizeCalculator
{
    /** @var SizeCollection */
    private $sizeCollection;

    /** @var array */
    private $characterSizes;

    /** @var SizeCalculator */
    private static $instance;

    /**
     * Singleton just because sizes should not be calculated over and over again.
     *
     * @return SizeCalculator
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self(new SizeCollection());
        }

        return self::$instance;
    }

    /**
     * SizeCalculator constructor.
     *
     * @param SizeCollection $sizeCollection
     */
    private function __construct(SizeCollection $sizeCollection)
    {
        $this->sizeCollection = $sizeCollection;
    }

    /**
     * Return the estimated width of a cell value.
     *
     * @param mixed $value
     * @param int   $fontSize
     * @return float
     */
    public function getCellWidth($value, $fontSize)
    {
        $width = 0.5;
        foreach ($this->getSingleCharacterArray($value) as $character) {
            if (isset($this->characterSizes[$character])) {
                $width += $this->characterSizes[$character] * 0.9;
            } elseif (strlen($character)) {
                $width += 0.06 * $fontSize;
            }
        }

        return $width;
    }

    /**
     * Set proper font sizes by font.
     *
     * @param string $fontName
     * @param string $fontSize
     */
    public function setFont($fontName, $fontSize)
    {
        $this->characterSizes = $this->sizeCollection->get($fontName, $fontSize);
    }
    /**
     * Split value into individual characters.
     *
     * @param mixed $value
     * @return array
     */
    private function getSingleCharacterArray($value)
    {
        if (mb_strlen($value) == strlen($value)) {
            return str_split($value);
        }

        return preg_split('~~u', $value, -1, PREG_SPLIT_NO_EMPTY);
    }
}