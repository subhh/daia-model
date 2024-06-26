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

final class Document
{
    use PropertiesTrait;

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

    public function __construct (UriInterface $id)
    {
        $this->id = $id;
    }

    public function getId () : ?UriInterface
    {
        return $this->id;
    }

    public function setHref (UriInterface $href) : void
    {
        $this->href = $href;
    }

    public function getHref () : ?UriInterface
    {
        return $this->href;
    }


    /** @param Item[] $items */
    public function setItems (array $items) : void
    {
        $this->items = array();
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /** @return Item[] */
    public function getItems () : array
    {
        return $this->items;
    }

    public function getItemById (string | UriInterface $id) : ?Item
    {
        $id = strval($id);
        foreach ($this->getItems() as $item) {
            if (strval($item->getId()) === $id) {
                return $item;
            }
        }
        return null;
    }

    public function addItem (Item $item) : void
    {
        $this->items[] = $item;
    }

    public function getAbout () : ?string
    {
        return $this->about;
    }

    public function setAbout (string $about) : void
    {
        $this->about = $about;
    }

    public function getRequested () : ?string
    {
        return $this->requested;
    }

    public function setRequested (string $requested) : void
    {
        $this->requested = $requested;
    }

    public function accept (Visitor $visitor) : void
    {
        if ($this->properties !== null) {
            $visitor->visitProperties($this->properties);
        }
        foreach ($this->getItems() as $item) {
            $visitor->visitItem($item);
        }
    }

    public function __clone () : void
    {
        $this->id = clone($this->id);
        if ($this->href) {
            $this->href = clone($this->href);
        }
        $items = array();
        foreach ($this->items as $item) {
            $items[] = clone($item);
        }
        $this->items = $items;
    }
}
