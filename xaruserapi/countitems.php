<?php
/**
 * Xaraya HTML Module
 *
 * @package modules
 * @copyright (C) 2002-2005 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
  *
 * @subpackage Xarigami HTML Module
 * @copyright (C) 2007-2010 2skies.com
 * @link http://xarigami.com/project/xarigami_html
 * @author HTML Module development Team
 */

/**
 * Count the number of HTML tags in the database
 *
 * @public
 * @author John Cox
 * @author Richard Cave
 * @param none
 * @return int number of HTML tags in the database
 * @throws none
 */
function html_userapi_countitems()
{
    // Security Check
    if(!xarSecurityCheck('ReadHTML')) return;
    // Get database setup
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    $htmltable = $xartable['html'];
    // Count number of items in table
    $query = "SELECT COUNT(1)
              FROM $htmltable";
    $result = $dbconn->Execute($query);
    if (!$result) return;
    // Get number of items
    list($numitems) = $result->fields;
    // Close result set
    $result->Close();
    // Return number of items
    return $numitems;
}
?>