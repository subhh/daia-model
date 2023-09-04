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
 * @author    David Maus <dmaus@dmaus.name>
 * @copyright (c) 2023 by Staats- und Universitätsbibliothek Hamburg
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */

declare(strict_types=1);

namespace SUBHH\DAIA\Model;

interface Visitor
{
    public function visitAvailable (Available $available) : void;
    public function visitChronology (Chronology $chronology) : void;
    public function visitDAIA (DAIA $daia) : void;
    public function visitDepartment (Department $department) : void;
    public function visitDocument (Document $document) : void;
    public function visitInstitution (Institution $institution) : void;
    public function visitItem (Item $item) : void;
    public function visitLimitation (Limitation $limitation) : void;
    public function visitService (Service $service) : void;
    public function visitStorage (Storage $storage) : void;
    public function visitUnavailable (Unavailable $available) : void;
}
