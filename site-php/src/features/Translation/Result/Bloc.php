<?php

namespace WebtoonLike\Site\features\Translation\Result;

class Bloc
{

    private ?string $translatedText = null;

    public function __construct(
        private string   $originalText,
        private Position $start,
        private Position $end
    ) {}

    /**
     * @return string
     */
    public function getOriginalText(): string
    {
        return $this->originalText;
    }

    /**
     * @return string
     */
    public function getTranslatedText(): string
    {
        return $this->translatedText;
    }

    /**
     * @return Position
     */
    public function getStart(): Position
    {
        return $this->start;
    }

    /**
     * @return Position
     */
    public function getEnd(): Position
    {
        return $this->end;
    }

    /**
     * @param string $originalText
     */
    public function setOriginalText(string $originalText): void
    {
        $this->originalText = $originalText;
    }

    /**
     * @param string $translatedText
     */
    public function setTranslatedText(string $translatedText): void
    {
        $this->translatedText = $translatedText;
    }

    /**
     * @param int $value
     * @param BlocPositionOption $pos
     */
    public function setStart(int $value, BlocPositionOption $pos): void
    {
        switch ($pos) {
            case BlocPositionOption::X:
                $this->start->setX($value);
                break;
            case BlocPositionOption::Y:
                $this->start->setY($value);
                break;
        }
    }

    /**
     * @param int $value
     * @param BlocPositionOption $pos
     */
    public function setEnd(int $value, BlocPositionOption $pos): void
    {
        switch ($pos) {
            case BlocPositionOption::X:
                $this->end->setX($value);
                break;
            case BlocPositionOption::Y:
                $this->end->setY($value);
                break;
        }
    }

    public static function merge(Bloc $bloc1, Bloc $bloc2): Bloc {
        if ($bloc2->getStart()->getX() < $bloc1->getStart()->getX()) {
            $bloc1->setStart($bloc2->getStart()->getX(), BlocPositionOption::X);
        }
        if ($bloc2->getStart()->getY() < $bloc1->getStart()->getY()) {
            $bloc1->setStart($bloc2->getStart()->getY(), BlocPositionOption::Y);
        }

        if ($bloc2->getEnd()->getX() > $bloc1->getEnd()->getX()) {
            $bloc1->setEnd($bloc2->getEnd()->getX(), BlocPositionOption::X);
        }
        if ($bloc2->getEnd()->getY() > $bloc1->getEnd()->getY()) {
            $bloc1->setEnd($bloc2->getEnd()->getY(), BlocPositionOption::Y);
        }

        $bloc1->setOriginalText(
            $bloc1->getOriginalText() . ' ' . $bloc2->getOriginalText()
        );

        return $bloc1;
    }

}