<?php

namespace WebtoonLike\Site\features\Translation\Result;

use WebtoonLike\Site\entities\Position;

class Bloc
{

    public function __construct(
        private string $text,
        private Position $start,
        private Position $end
    ) {}

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
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
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
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

        $bloc1->setText(
            $bloc1->getText() . ' ' . $bloc2->getText()
        );

        return $bloc1;
    }

}