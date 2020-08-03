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
 * Delete a tag type
 *
 * @public
 * @author Richard Cave
 * @param $args['id'] ID of the tag type
 * @return bool true on success, false on failure
 * @throws BAD_PARAM, MISSING_DATA
 */
function html_adminapi_deletetype($args)
{
    // Get arguments from argument array
    extract($args);

    // Argument check
    if (!isset($id) || !is_numeric($id)) {
        $msg = xarML('Invalid Parameter #(1) for #(2) function #(3)() in module #(4)', 'id', 'adminapi', 'deletetype', 'html');
         throw new BadParameterException(null,$msg);
    }

    // The user API function is called
    $type = xarModAPIFunc('html',
                          'user',
                          'gettype',
                          array('id' => $id));

    if ($type == false) {
        $msg = xarML('No Such tag type present');
         throw new DataNotFoundException(null,$msg);
    }

    // Security Check
    if(!xarSecurityCheck('DeleteHTML')) return;

    // Get datbase setup
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();

    // Set table name
    $htmltable = $xartable['html'];
    $htmltypestable = $xartable['htmltypes'];

    // Delete the tag type
    $query = "DELETE FROM $htmltypestable WHERE xar_id = ?";
    $result = $dbconn->Execute($query,array($id));
    if (!$result) return;

    // Also delete the associated tags from the xar_html table
    $query = "DELETE FROM $htmltable WHERE xar_tid = ?";
    $result = $dbconn->Execute($query,array($id));
    if (!$result) return;


    // If this is a tag type HTML, then
    // also delete the tags from the config vars
    if ($type['type'] == 'html') {
        $allowedhtml = array();
        // Set the config vars to an empty array
        xarConfigSetVar('Site.Core.AllowableHTML', $allowedhtml);
    }
    // Let any hooks know that we have deleted a tag type
    xarModCallHooks('item', 'deletetype', $id, '');
    // Let the calling process know that we have finished successfully
    return true;
}
?>