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

use ArrayObject;
use SplStack;

class JsonSerializer implements Visitor
{
    /** @var SplStack<ArrayObject<string, mixed>> */
    private $json;

    /** @return mixed */
    public function serialize (DAIA $daia)
    {
        $this->json = new SplStack();

        $this->visitDAIA($daia);

        return json_encode($this->json->pop(), JSON_THROW_ON_ERROR);
    }

    public function visitDAIA (DAIA $daia) : void
    {
        $this->json->push(new ArrayObject());
        $daia->accept($this);
    }

    public function visitDepartment (Department $department) : void
    {
        if ($data = $this->serializeEntity($department)) {
            $this->json->top()['department'] = $data;
        }
    }

    public function visitChronology (Chronology $chronology) : void
    {
        if ($about = $chronology->getAbout()) {
            $this->json->top()['chronology'] = $about;
        }
    }

    public function visitAvailable (Available $available) : void
    {
        $data = $this->serializeAvailability($available);

        /** @var ArrayObject<string, string> */
        $jsonAvailable = new ArrayObject($data);
        if ($available->isDelayUnknown()) {
            $jsonAvailable['delay'] = 'unkown';
        }
        if ($delay = $available->getDelay()) {
            $jsonAvailable['delay'] = $delay->format('%rP%yY%mM%dDT%hH%iM%sS');
        }

        $this->json->top()['available'][] = $jsonAvailable;
        $this->json->push($jsonAvailable);
        $available->accept($this);
        $this->json->pop();
    }

    public function visitUnavailable (Unavailable $unavailable) : void
    {
        $data = $this->serializeAvailability($unavailable);

        /** @var ArrayObject<string, string> */
        $jsonUnavailable = new ArrayObject($data);
        if ($unavailable->isExpectedUnknown()) {
            $jsonUnavailable['expected'] = 'unkown';
        }
        if ($expected = $unavailable->getExpected()) {
            $jsonUnavailable['expected'] = $expected->format('Y-m-dP');
        }
        if (is_int($unavailable->getQueue())) {
            $jsonUnavailable['queue'] = sprintf('%d', (int)$unavailable->getQueue());
        }

        $this->json->top()['unavailable'][] = $jsonUnavailable;
        $this->json->push($jsonUnavailable);
        $unavailable->accept($this);
        $this->json->pop();
    }

    public function visitDocument (Document $document) : void
    {
        /** @var ArrayObject<string, string> */
        $jsonDocument = new ArrayObject();
        $jsonDocument['id'] = (string)$document->getId();
        if ($href = $document->getHref()) {
            $jsonDocument['href'] = (string)$href;
        }
        if ($about = $document->getAbout()) {
            $jsonDocument['about'] = $about;
        }
        if ($requested = $document->getRequested()) {
            $jsonDocument['requested'] = $requested;
        }

        $this->json->top()['document'][] = $jsonDocument;
        $this->json->push($jsonDocument);
        $document->accept($this);
        $this->json->pop();
    }

    public function visitItem (Item $item) : void
    {
        /** @var ArrayObject<string, string> */
        $jsonItem = new ArrayObject();
        if ($id = $item->getId()) {
            $jsonItem['id'] = (string)$id;
        }
        if ($href = $item->getHref()) {
            $jsonItem['href'] = (string)$href;
        }
        if ($label = $item->getLabel()) {
            $jsonItem['label'] = $label;
        }
        if ($about = $item->getAbout()) {
            $jsonItem['about'] = $about;
        }
        if ($part = $item->getPart()) {
            $jsonItem['part'] = $part;
        }

        $this->json->top()['item'][] = $jsonItem;
        $this->json->push($jsonItem);
        $item->accept($this);
        $this->json->pop();
    }

    public function visitInstitution (Institution $institution) : void
    {
        if ($data = $this->serializeEntity($institution)) {
            $this->json->top()['institution'] = $data;
        }
    }

    public function visitLimitation (Limitation $limitation) : void
    {
        if ($data = $this->serializeEntity($limitation)) {
            $this->json->top()['limitation'][] = $data;
        }
    }

    public function visitProperties (Properties $properties) : void
    {
        if ($properties->count() > 0) {
            $this->json->top()['properties'] = $properties;
        }
    }

    public function visitStorage (Storage $storage) : void
    {
        if ($data = $this->serializeEntity($storage)) {
            $this->json->top()['storage'] = $data;
        }
    }

    /** @return array<string, string> */
    private function serializeEntity (Entity $entity) : array
    {
        $data = array();
        if ($id = $entity->getId()) {
            $data['id'] = (string)$id;
        }
        if ($href = $entity->getHref()) {
            $data['href'] = (string)$href;
        }
        if ($content = $entity->getContent()) {
            $data['content'] = $content;
        }
        return $data;
    }

    /** @return array<string, string> */
    private function serializeAvailability (Availability $availability) : array
    {
        $data = array();
        $data['service'] = Service::abbreviate($availability->getService());
        if ($href = $availability->getHref()) {
            $data['href'] = (string)$href;
        }
        if ($title = $availability->getTitle()) {
            $data['title'] = $title;
        }
        return $data;
    }
}
