<?php

/*
 * This file is part of DAIA Model.
 *
 * DAIA Model is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * DAIA Model is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
 * for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DAIA Model. If not, see <https://www.gnu.org/licenses/>.
 *
 * @author    David Maus <david.maus@sub.uni-hamburg.de>
 * @copyright (c) 2023 by Staats- und Universitätsbibliothek Hamburg
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */

declare(strict_types=1);

namespace SUBHH\DAIA\Model;

use DateTimeImmutable;

final class Unavailable extends Availability
{
    /** @var ?DateTimeImmutable */
    private $expected;

    /** @var ?bool */
    private $expectedUnknown;

    /** @var int */
    private $queue;

    public function getQueue () : ?int
    {
        return $this->queue;
    }

    public function setQueue (int $queue) : void
    {
        $this->queue = $queue;
    }

    public function setExpected (DateTimeImmutable $expected) : void
    {
        $this->expectedUnknown = false;
        $this->expected = $expected;
    }

    public function getExpected () : ?DateTimeImmutable
    {
        return $this->expected;
    }

    public function setExpectedUnknown () : void
    {
        $this->expectedUnknown = true;
        $this->expected = null;
    }

    public function isExpectedUnknown () : ?bool
    {
        return $this->expectedUnknown;
    }

    public function __clone () : void
    {
        parent::__clone();
        if ($this->expected) {
            $this->expected = clone($this->expected);
        }
    }
}
