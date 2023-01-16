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

abstract class Entity implements JsonSerializable
{
    /** @var ?UriInterface */
    private $id;

    /** @var ?UriInterface */
    private $href;

    /** @var ?string */
    private $content;

    /** @return mixed */
    public function jsonSerialize ()
    {
        $data = array();
        if ($id = $this->getId()) {
            $data['id'] = (string)$id;
        }
        if ($href = $this->getHref()) {
            $data['href'] = (string)$href;
        }
        if ($content = $this->getContent()) {
            $data['content'] = $content;
        }
        return $data;
    }

    final public function setId (UriInterface $id) : void
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

    final public function setContent (string $content) : void
    {
        $this->content = $content;
    }

    final public function getContent () : ?string
    {
        return $this->content;
    }
}
