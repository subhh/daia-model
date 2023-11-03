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

class Document
{
    /** @var UriInterface */
    private $id;

    /** @var ?UriInterface */
    private $href;

    /** @var Item[] */
    private $items = array();

    /** @var ?string */
    private $requested;

    /** @var ?string */
    private $about;

    final public function __construct (UriInterface $id)
    {
        $this->id = $id;
    }

    final public function getId () : ?UriInterface
    {
        return $this->id;
    }

    final public function setHref (UriInterface $href) : void
    {
        $this->href = $href;
    }

    final public function getHref () : ?UriInterface
    {
        return $this->href;
    }

    /** @return Item[] */
    final public function getItems () : array
    {
        return $this->items;
    }

    final public function addItem (Item $item) : void
    {
        $this->items[] = $item;
    }

    final public function getAbout () : ?string
    {
        return $this->about;
    }

    final public function setAbout (string $about) : void
    {
        $this->about = $about;
    }

    final public function getRequested () : ?string
    {
        return $this->requested;
    }

    final public function setRequested (string $requested) : void
    {
        $this->requested = $requested;
    }

    final public function accept (Visitor $visitor) : void
    {
        foreach ($this->getItems() as $item) {
            $visitor->visitItem($item);
        }
    }
}
