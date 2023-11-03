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

use DateTimeImmutable;

final class DAIA
{
    use ExtraPropertyTrait;

    /** @var Document[] */
    private $documents = array();

    /** @var ?Institution */
    private $institution;

    /** @var ?DateTimeImmutable */
    private $timestamp;

    /** @return Document[] */
    public function getDocuments () : array
    {
        return $this->documents;
    }

    public function addDocument (Document $document) : void
    {
        $this->documents[] = $document;
    }

    public function getInstitution () : ?Institution
    {
        return $this->institution;
    }

    public function setInstitution (Institution $institution) : void
    {
        $this->institution = $institution;
    }

    public function setTimestamp (DateTimeImmutable $timestamp) : void
    {
        $this->timestamp = $timestamp;
    }

    public function getTimestamp () : ?DateTimeImmutable
    {
        return $this->timestamp;
    }

    public function accept (Visitor $visitor) : void
    {
        if ($institution = $this->getInstitution()) {
            $visitor->visitInstitution($institution);
        }
        foreach ($this->getDocuments() as $document) {
            $visitor->visitDocument($document);
        }
    }
}
