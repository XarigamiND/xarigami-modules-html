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
 * Add a standard screen upon entry to the module.
 *
 * @public
 * @author John Cox
 * @return bool true on success of redirect
 */
function html_admin_main()
{
    // Security Check
    if(!xarSecurityCheck('EditHTML')) return;
    xarResponseRedirect(xarModURL('html', 'admin', 'set'));
    // Return the template variables defined in this function
    return true;
}

?>
