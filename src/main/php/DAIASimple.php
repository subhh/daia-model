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
use JsonSerializable;

use Psr\Http\Message\UriInterface;

abstract class DAIASimple implements JsonSerializable
{
    /** @var string[] */
    private static $services = [
        'openaccess',
        'loan',
        'remote',
        'presentation',
        'none'
    ];

    /** @var ?UriInterface */
    private $href;

    /** @var ?string */
    private $limitation;

    /** @var string */
    private $service;

    /** @var bool */
    private $available;

    public function __construct (string $service, bool $available)
    {
        if (!in_array($service, self::$services, true)) {
            throw new InvalidArgumentException(
                sprintf("Unknown service identifier: 'openaccess'|'loan'|'remote'|'presentation'|'none', '%s'", $service)
            );
        }
        $this->service = $service;
        $this->available = $available;
    }

    final public function isAvailable () : bool
    {
        return $this->available;
    }

    final public function getService () : string
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

    final public function setLimitation (string $limitation) : void
    {
        $this->limitation = $limitation;
    }

    final public function getLimitation () : ?string
    {
        return $this->limitation;
    }

    public function jsonSerialize () : mixed
    {
        $data = array();
        $data['available'] = $this->available;
        $data['service'] = $this->service;
        if ($limitation = $this->getLimitation()) {
            $data['limitation'] = $limitation;
        }
        if ($href = $this->getHref()) {
            $data['href'] = (string)$href;
        }

        return $data;
    }

    public function __clone () : void
    {
        if ($this->href) {
            $this->href = clone($this->href);
        }
    }
}
