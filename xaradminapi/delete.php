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
 * Delete an html tag
 *
 * @public
 * @author John Cox
 * @author Richard Cave
 * @param $args['cid'] ID of the html
 * @return bool true on success, false on failure
 * @throws BAD_PARAM, MISSING_DATA
 */
function html_adminapi_delete($args)
{
    // Get arguments from argument array
    extract($args);

    // Argument check
    if (!isset($cid) || !is_numeric($cid)) {
        $msg = xarML('Invalid Parameter #(1) for #(2) function #(3)() in module #(4)', 'cid', 'adminapi', 'delete', 'html');
         throw new BadParameterException(null,$msg);
    }

    // The user API function is called
    $html = xarModAPIFunc('html',
                          'user',
                          'gettag',
                          array('cid' => $cid));

    if ($html == false) {
        $msg = xarML('No Such HTML tag Present', 'html');
        throw new BadParameterException(null,$msg);
    }

    // Security Check
    if(!xarSecurityCheck('DeleteHTML')) return;
    // Get datbase setup
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    $htmltable = $xartable['html'];

    // Delete the tag
    $query = "DELETE FROM $htmltable WHERE xar_cid = ?";
    $result = $dbconn->Execute($query,array($cid));
    if (!$result) return;

    // If this is an html tag, then
    // also delete the tag from the config vars
    $tagtype = xarModAPIFunc('html',
                             'user',
                             'gettype',
                             array('id' => $html['tid']));

    if ($tagtype['type'] == 'html') {
        $allowedhtml = array();
        // Get the current tags from config vars
        foreach (xarConfigGetVar('Site.Core.AllowableHTML') as $key => $value) {
            // Remove the deleted html tag from the config vars
            if ($key != $html['tag']) {
                $allowedhtml[$key] = $value;
            }
        }
        // Set the config vars
        xarConfigSetVar('Site.Core.AllowableHTML', $allowedhtml);
    }
    // Let any hooks know that we have deleted a html
    xarModCallHooks('item', 'delete', $cid, '');
    // Let the calling process know that we have finished successfully
    return true;
}
?>