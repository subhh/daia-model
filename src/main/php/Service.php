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

final class Service
{
    const PRESENTATION = "http://purl.org/ontology/dso#Presentation";
    const OPENACCESS = "http://purl.org/ontology/dso#Openaccess";
    const INTERLOAN = "http://purl.org/ontology/dso#Interloan";
    const REMOTE = "http://purl.org/ontology/dso#Remote";
    const LOAN = "http://purl.org/ontology/dso#Loan";

    private function __construct ()
    {}

    public static function unabbreviate (string $service) : string
    {
        if (in_array($service, ['presentation', 'loan', 'interloan', 'remote', 'openaccess'], true)) {
            return 'http://purl.org/ontology/dso#' . ucfirst($service);
        }
        return $service;
    }
}
