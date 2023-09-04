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

class JsonSerializer extends DefaultVisitor
{
    /** @var SplStack<ArrayObject<string, mixed>> */
    private $json;

    public function serialize (DAIA $daia) : mixed
    {
        $this->json = new SplStack();

        $daia->visitDAIA($daia);

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
}
