<?php

namespace Discordle\Model;

enum NumberComparison {
    case HIGHER;
    case SAME;
    case LOWER;

    public static function make(int $correct, int $guess): NumberComparison {
        return match (true) {
            $correct > $guess => NumberComparison::HIGHER,
            $correct == $guess => NumberComparison::SAME,
            $correct < $guess => NumberComparison::LOWER,
        };
    }
}