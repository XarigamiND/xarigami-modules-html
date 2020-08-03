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
 * Add new html tag
 *
 * @public
 * @author Richard Cave
 */
function html_admin_newtype()
{
    // Security Check
    if(!xarSecurityCheck('AddHTML')) return;

    $data['authid'] = xarSecGenAuthKey();
    $data['createbutton'] = xarML('Create Tag Type');
    $data['menulinks'] = xarModAPIFunc('html','admin','getmenulinks');
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
