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

abstract class Availability
{
    use PropertiesTrait;

    /** @var UriInterface */
    private $service;

    /** @var ?UriInterface */
    private $href;

    /** @var ?string */
    private $title;

    /** @var Limitation[] */
    private $limitations = array();

    final public function __construct (UriInterface $service)
    {
        $this->service = $service;
    }

    final public function getService () : UriInterface
    {
        return $this->service;
    }

    final public function setHref (UriInterface $href) : void
    {
        $this->href = $href;
    }

    final public function getHref () : ?UriInterface
    {
        return $this->href;
    }

    final public function setTitle (string $title) : void
    {
        $this->title = $title;
    }

    final public function getTitle () : ?string
    {
        return $this->title;
    }

    /** @return Limitation[] */
    final public function getLimitations () : array
    {
        return $this->limitations;
    }

    final public function addLimitation (Limitation $limitation) : void
    {
        $this->limitations[] = $limitation;
    }

    public function accept (Visitor $visitor) : void
    {
        if ($this->properties !== null) {
            $visitor->visitProperties($this->properties);
        }
        foreach ($this->getLimitations() as $limitation) {
            $visitor->visitLimitation($limitation);
        }
    }

    public function __clone () : void
    {
        $this->service = clone($this->service);
        if ($this->href) {
            $this->href = clone($this->href);
        }

        $limitations = array();
        foreach ($this->limitations as $limitation) {
            $limitations[] = clone($limitation);
        }
        $this->limitations = $limitations;
    }
}
