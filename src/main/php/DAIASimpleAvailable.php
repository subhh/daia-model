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

use InvalidArgumentException;
use DateInterval;

final class DAIASimpleAvailable extends DAIASimple
{
    /** @var ?DateInterval */
    private $delay;

    /** @var bool */
    private $delayUnknown;

    /** @param mixed $delay A DateInterval instance or the string 'unknown' */
    public function __construct (string $service, $delay = null)
    {
        if (!is_null($delay) && !$delay instanceof DateInterval && !is_string($delay)) {
            throw new InvalidArgumentException(
                sprintf('Invalid type of argument $delay: DateInterval|string, %s', gettype($delay))
            );
        }
        if (is_string($delay) && $delay !== 'unknown') {
            throw new InvalidArgumentException("Unknown delay string indicator: 'unknown', '{$delay}'");
        }

        parent::__construct($service, true);
        if ($delay instanceof DateInterval) {
            $this->delay = $delay;
            $this->delayUnknown = false;
        }
        if (is_string($delay)) {
            $this->delayUnknown = true;
        }
    }

    public function isDelayUnknown () : bool
    {
        return $this->delayUnknown;
    }

    public function getDelay () : ?DateInterval
    {
        return $this->delay;
    }

    /** @return mixed */
    public function jsonSerialize ()
    {
        $data = parent::jsonSerialize();
        if ($this->isDelayUnknown()) {
            $data['delay'] = 'unknown';
        }
        if ($delay = $this->getDelay()) {
            $data['delay'] = $delay->format('%rP%yY%mM%dDT%hH%iM%sS');
        }
        return $data;
    }
}
