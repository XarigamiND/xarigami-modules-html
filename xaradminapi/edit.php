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
 * Edit a tag
 *
 * @author Richard Cave
 * @param $args['cid'] ID of the tag
 * @param $args['tag'] the name of the tag
 * @return bool true on success, false on failure
 * @throws BAD_PARAM, MISSING_DATA
 */
function html_adminapi_edit($args)
{
    // Get arguments from argument array
    extract($args);

    // Argument check
    $invalid = array();
    if (!isset($cid) || !is_numeric($cid)) {
        $invalid[] = 'cid';
    }
    if (!isset($tag) || !is_string($tag)) {
        $invalid[] = 'tag';
    }

    if (count($invalid) > 0) {
        $msg = xarML('Invalid Parameter #(1) for #(2) function #(3)() in module #(4)', join(', ',$invalid), 'adminapi', 'edit', 'html');
         throw new BadParameterException(null,$msg);
    }

    // The user API function is called
    $html = xarModAPIFunc('html',
                          'user',
                          'gettag',
                          array('cid' => $cid));

    if ($html == false) {
        $msg = xarML('No such tag present');
         throw new DataNotFoundException(null,$msg);
    }

    // Security Check
    if(!xarSecurityCheck('EditHTML')) return;

    // Get datbase setup
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    $htmltable = $xartable['html'];

    // Make sure $tag is lowercase
    $tag = strtolower($tag);

    // Update the html
    $query = "UPDATE $htmltable
              SET xar_tag = ?
              WHERE xar_cid = ?";
    $result = $dbconn->Execute($query,array($tag, $cid));
    if (!$result) return;

    // If this is an html tag, then
    // also edit the item in the config vars
    $tagtype = xarModAPIFunc('html',
                             'user',
                             'gettype',
                             array('id' => $html['tid']));

    if ($tagtype['type'] == 'html') {
        $allowedhtml = array();
        // Get the current html tags from config vars
        foreach (xarConfigGetVar('Site.Core.AllowableHTML') as $key => $value) {
            // Update html tag from the config vars
            if ($key != $html['tag']) {
            $allowedhtml[$key] = $value;
            }
        }
        // Add the new html tag
        $allowedhtml[$tag] = $html['allowed'];
        // Set the config vars
        xarConfigSetVar('Site.Core.AllowableHTML', $allowedhtml);
    }
    // Let any hooks know that we have deleted a html
    xarModCallHooks('item', 'edit', $cid, '');
    // Let the calling process know that we have finished successfully
    return true;
}
?>