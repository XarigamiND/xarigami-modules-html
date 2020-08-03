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
 * Update an html tag
 *
 * @public
 * @author John Cox
 * @author Richard Cave
 * @param $args['cid'] the ID of the html tag
 * @param $args['allowed'] the flag for the html tag
 * @throws BAD_PARAM
 */
function html_adminapi_update($args)
{
    // Get arguments from argument array
    extract($args);

    // Argument check
    $invalid = array();
    if (!isset($cid) || !is_numeric($cid)) {
        $invalid[] = 'cid';
    }
    if (!isset($allowed) || !is_numeric($allowed)) {
        $invalid[] = 'allowed';
    }

    if (count($invalid) > 0) {
        $msg = xarML('Invalid Parameter #(1) for #(2) function #(3)() in module #(4)', join(', ',$invalid), 'adminapi', 'update', 'html');
        throw new BadParameterException(null,$msg);
    }

    // Security Check
    if(!xarSecurityCheck('EditHTML')) return;
    // Get datbase setup
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    $htmltable = $xartable['html'];

    // Update the html tag
    $query = "UPDATE $htmltable
              SET   xar_allowed = ?
              WHERE xar_cid = ?";
    $result = $dbconn->Execute($query,array($allowed, $cid));
    if (!$result) return;
    // Let any hooks know that we have deleted a html tag
    xarModCallHooks('item', 'update', $cid, '');
    // Let the calling process know that we have finished successfully
    return true;
}
?>