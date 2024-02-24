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

use SplObjectStorage;

final class AvailabilityInformation
{
    /** @var SplObjectStorage<Availability, null> */
    private $availability;

    public function __construct ()
    {
        $this->availability = new SplObjectStorage();
    }

    public function add (Availability $availability) : void
    {
        $this->availability->attach($availability);
    }

    public function remove (Availability $availability) : void
    {
        $this->availability->detach($availability);
    }

    /** @return Available[] */
    public function getAvailable () : array
    {
        $available = array();
        foreach ($this->availability as $availability) {
            if ($availability instanceof Available) {
                $available[] = $availability;
            }
        }
        return $available;
    }

    /** @return Unavailable[] */
    public function getUnavailable () : array
    {
        $unavailable = array();
        foreach ($this->availability as $availability) {
            if ($availability instanceof Unavailable) {
                $unavailable[] = $availability;
            }
        }
        return $unavailable;
    }
}
