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
 * Add a new tag
 *
 * @public
 * @author John Cox
 * @author Richard Cave
 */
function html_admin_new()
{
    // Security Check
    if(!xarSecurityCheck('AddHTML')) return;
    $data['menulinks'] = xarModAPIFunc('html','admin','getmenulinks');
    $data['authid'] = xarSecGenAuthKey();
    $data['createbutton'] = xarML('Create Tag');

    // Get tag types
    $types = xarModAPIFunc('html',
                           'user',
                           'getalltypes');

    // Check for exceptions
    if (!isset($types) && xarCurrentErrorType() != XAR_NO_EXCEPTION) return; // throw back

    $data['types'] = $types;

    // Include 'formcheck' JavaScript.
    // TODO: move this to a template widget when available.
    xarModAPIfunc(
        'base', 'javascript', 'modulefile',
        array('module'=>'base', 'filename'=>'formcheck.js')
    );

    // Return the output
    return $data;
}

?>
