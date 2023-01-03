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
use JsonSerializable;

final class Document implements JsonSerializable
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

    /** @return Item[] */
    public function getItems () : array
    {
        return $this->items;
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

    public function jsonSerialize () : mixed
    {
        $data = array();
        $data['id'] = (string)$this->getId();
        if ($href = $this->getHref()) {
            $data['href'] = (string)$href;
        }
        if ($about = $this->getAbout()) {
            $data['about'] = $about;
        }
        if ($requested = $this->getRequested()) {
            $data['requested'] = $requested;
        }
        if ($this->getItems()) {
            $data['items'] = array();
            foreach ($this->getItems() as $item) {
                $data['items'][] = $item->jsonSerialize();
            }
        }
        return $data;
    }
}
