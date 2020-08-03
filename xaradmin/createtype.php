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
 * Create a new HTML tag
 *
 * @public
 * @author Richard Cave
 * @param 'tagtype' the type of tag to be created
 * @throws MISSING_DATA
 */
function html_admin_createtype($args)
{
    // Get parameters from input
    if (!xarVarFetch('tagtype', 'str:1:', $tagtype, '')) return;

    // Confirm authorisation code.
    if (!xarSecConfirmAuthKey()) return;

    // Security Check
    if(!xarSecurityCheck('AddHTML')) return;

    // Check arguments
    if (empty($tagtype)) {
       throw new EmptyParameterException('tagtype');
    }

    // The API function is called
    $id = xarModAPIFunc('html',
                        'admin',
                        'createtype',
                        array('tagtype' => $tagtype));

    if (!$id) {
        return false; //throw back
    }
        $msg = xarML('New HTML tag type was successfully added.');
    xarTplSetMessage($msg,'status');

    xarResponseRedirect(xarModURL('html', 'admin', 'viewtypes'));

    // Return
    return true;
}

?>
