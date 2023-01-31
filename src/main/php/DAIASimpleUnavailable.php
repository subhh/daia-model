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

final class DAIASimpleUnavailable extends DAIASimple
{
    /** @var ?DateTimeImmutable */
    private $expected;

    /** @var ?bool */
    private $expectedUnknown;

    /** @var ?int */
    private $queue;

    public function __construct (string $service)
    {
        parent::__construct($service, false);
    }

    public function setExpected (DateTimeImmutable $expected) : void
    {
        $this->expectedUnknown = false;
        $this->expected = $expected;
    }

    public function setExpectedUnknown () : void
    {
        $this->expectedUnknown = true;
    }

    public function getExpected () : ?DateTimeImmutable
    {
        return $this->expected;
    }

    public function isExpectedUnknown () : bool
    {
        if ($this->expectedUnknown) {
            return true;
        }
        return false;
    }

    public function setQueue (int $queue) : void
    {
        $this->queue = $queue;
    }

    public function getQueue () : ?int
    {
        return $this->queue;
    }

    /** @return mixed */
    public function jsonSerialize ()
    {
        $data = parent::jsonSerialize();
        if (is_int($this->getQueue())) {
            $data['queue'] = $this->getQueue();
        }
        if ($expected = $this->getExpected()) {
            $data['expected'] = $expected->format('Y-m-dP');
        }
        return $data;
    }
}
