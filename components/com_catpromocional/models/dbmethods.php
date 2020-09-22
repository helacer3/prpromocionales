<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_catpromocional
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');

/**
 * Quotation model for the Joomla CatPromocional component.
 *
 * @since  1.5
 */
class CatpromocionalModelDbmethods extends JModelLegacy
{
    ////////////////////////////////////////////////////////////////////////////
    // Create Record
    ////////////////////////////////////////////////////////////////////////////
    public function createRecord($db,$columns,$values,$table) {
        // Create a new query object.
        $query = $db->getQuery(true);
        // Prepare the insert query.
        $query
            ->insert($db->quoteName($table))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
        // Set the Query.
        $db->setQuery($query);
        // Execute Query.
        $db->execute();
        //echo "<br /><br />".$query."<br /><br />";
        // Return Id
        return $db->insertid();
    }
}