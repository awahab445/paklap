<?php
/**
 * Arpatech Software.
 *
 * @category  Arpatech
 * @package   Arpatech_NewsTicker
 * @author    Arpatech
 * @copyright Copyright (c) 2010-2016
 * @license
 */
namespace Arpatech\NewsTicker\Api\Data;

interface NewsInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID    = 'id';
    /**#@-*/

    /**
    * Get ID
    *
    * @return int|null
    */
    public function getId();

    /**
    * Set ID
    *
    * @param int $id
    * @return \Arpatech\NewsTicker\Api\Data\NewsInterface
    */
    public function setId($id);
}
