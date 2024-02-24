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

use Psr\Http\Message\UriInterface;

final class Item
{
    use PropertiesTrait;

    /** @var ?UriInterface */
    private $id;

    /** @var ?string */
    private $label;

    /** @var ?string */
    private $about;

    /** @var ?string */
    private $part;

    /** @var ?UriInterface */
    private $href;

    /** @var ?Department */
    private $department;

    /** @var ?Storage */
    private $storage;

    /** @var ?Chronology */
    private $chronology;

    /** @var AvailabilityInformation */
    private $availability;

    public function __construct ()
    {
        $this->availability = new AvailabilityInformation();
    }

    public function setId (UriInterface $id) : void
    {
        $this->id = $id;
    }

    public function getId () : ?UriInterface
    {
        return $this->id;
    }

    public function setLabel (string $label) : void
    {
        $this->label = $label;
    }

    public function getLabel () : ?string
    {
        return $this->label;
    }

    public function getHref () : ?UriInterface
    {
        return $this->href;
    }

    public function setHref (UriInterface $href) : void
    {
        $this->href = $href;
    }

    public function getAbout () : ?string
    {
        return $this->about;
    }

    public function setAbout (string $about) : void
    {
        $this->about = $about;
    }

    public function setChronology (Chronology $chronology) : void
    {
        $this->chronology = $chronology;
    }

    public function getChronology () : ?Chronology
    {
        return $this->chronology;
    }

    public function getAvailabilityInformation () : AvailabilityInformation
    {
        return $this->availability;
    }

    /** @return Available[] */
    public function getAvailable () : array
    {
        return $this->getAvailabilityInformation()->getAvailable();
    }

    /** @return Unavailable[] */
    public function getUnavailable () : array
    {
        return $this->getAvailabilityInformation()->getUnavailable();
    }

    public function setDepartment (Department $department) : void
    {
        $this->department = $department;
    }

    public function getDepartment () : ?Department
    {
        return $this->department;
    }

    public function setStorage (Storage $storage) : void
    {
        $this->storage = $storage;
    }

    public function getStorage () : ?Storage
    {
        return $this->storage;
    }

    public function getPart () : ?string
    {
        return $this->part;
    }

    public function setPart (string $part) : void
    {
        $this->part = $part;
    }

    public function accept (Visitor $visitor) : void
    {
        if ($this->department !== null) {
            $visitor->visitDepartment($this->department);
        }
        if ($this->storage !== null) {
            $visitor->visitStorage($this->storage);
        }
        if ($this->chronology !== null) {
            $visitor->visitChronology($this->chronology);
        }
        if ($this->properties !== null) {
            $visitor->visitProperties($this->properties);
        }
        foreach ($this->getAvailable() as $available) {
            $visitor->visitAvailable($available);
        }
        foreach ($this->getUnavailable() as $unavailable) {
            $visitor->visitUnavailable($unavailable);
        }
    }
}
