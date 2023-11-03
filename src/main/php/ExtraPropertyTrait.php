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

trait ExtraPropertyTrait
{
    /** @var array<string, mixed> */
    private $properties = array();

    /**
     * @param mixed $defaultValue
     * @return mixed
     */
    final public function getExtraProperty (string $name, $defaultValue = null)
    {
        return $this->properties[$name] ?? $defaultValue;
    }

    /** @param mixed $value */
    final public function setExtraProperty (string $name, $value) : void
    {
        $this->properties[$name] = $value;
    }
}
