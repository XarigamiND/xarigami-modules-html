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
 * Edit a tag type
 *
 * @author Richard Cave
 * @param $args['id'] ID of the tag type to change
 * @param $args['tagtype'] the tag type
 * @return bool true on success, false on failure
 * @throws BAD_PARAM, MISSING_DATA
 */
function html_adminapi_edittype($args)
{
    // Get arguments from argument array
    extract($args);

    // Argument check
    $invalid = array();
    if (!isset($id) || !is_numeric($id)) {
        $invalid[] = 'id';
    }
    if (!isset($tagtype) || !is_string($tagtype)) {
        $invalid[] = 'tag type';
    }

    if (count($invalid) > 0) {
        $msg = xarML('Invalid Parameter #(1) for #(2) function #(3)() in module #(4)', join(', ',$invalid), 'adminapi', 'edittype', 'html');
        throw new BadParameterException(null,$msg);
    }

    // The user API function is called
    $type = xarModAPIFunc('html',
                          'user',
                          'gettype',
                          array('id' => $id));

    if ($type == false) {
        $msg = xarML('No such tag  type present.');
        throw new DataNotFoundException(null,$msg);
    }

    // Security Check
    if(!xarSecurityCheck('EditHTML')) return;

    // Get datbase setup
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    $htmltypestable = $xartable['htmltypes'];

    // Make sure tag type is lowercase
    $tagtype = strtolower($tagtype);

    // Update the tag type
    $query = "UPDATE $htmltypestable
              SET xar_type = ?
              WHERE xar_id = ?";
    $result = $dbconn->Execute($query,array($tagtype, $id));
    if (!$result) return;
    // Let any hooks know that we have deleted a html
    xarModCallHooks('item', 'edittype', $id, '');
    // Let the calling process know that we have finished successfully
    return true;
}
?>