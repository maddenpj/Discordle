<?php

namespace Discordle\Model;

// use Discordle\Model\RankComparison;

enum LoLRank: int {
    case IRON = 1;
    case BRONZE = 2;
    case SILVER = 3;
    case GOLD = 4;
    case PLATINUM = 5;
    case DIAMOND = 6;
    case MASTER = 7;
    case GRANDMASTER = 8;
    case CHALLENGER = 9;

    public function compareTo(LoLRank $other): RankComparison {
        return match (true) {
            $this->value > $other->value => RankComparison::HIGHER,
            $this->value == $other->value => RankComparison::SAME_RANK,
            $this->value < $other->value => RankComparison::LOWER,
        };
    }

}
