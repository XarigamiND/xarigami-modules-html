<?php
/**
 * Xaraya HTML Module
 *
 * @package modules
 * @copyright (C) 2002-2005 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage Xarigami HTML Module
 * @copyright (C) 2007-2011 2skies.com
 * @link http://xarigami.com/project/xarigami_html
 * @author HTML Module development Team
 */

/**
 * Create a new HTML tag
 *
 * @public
 * @author John Cox
 * @author Richard Cave
 * @param string 'tag' the tag to be created
 * @param strng 'tagtype' the type of tag to be created
 * @param int 'allowed' the state of the tag to be created
 * @throws MISSING_DATA
 */
function html_admin_create($args)
{
    // Get parameters from input
    if (!xarVarFetch('tag', 'str:1:', $tag, '')) return;
    if (!xarVarFetch('tagtype', 'str:1:', $tagtype, '')) return;
    if (!xarVarFetch('allowed', 'int:0:', $allowed, 0)) return;

    // Confirm authorisation code.
    if (!xarSecConfirmAuthKey()) return;

    // Security Check
    if(!xarSecurityCheck('AddHTML')) return;

    // Check arguments
    if (empty($tag)) {
        $msg = xarML('No tag Provided, Please provide a tag');
        throw new EmptyParameterException(null,$msg);
    }

    // The API function is called
    $cid = xarModAPIFunc('html', 'admin', 'create',
                         array('tag' => $tag,
                               'type' => $tagtype,
                               'allowed' => $allowed));
    $msg = xarML('New HTML tag was successfully added.');
    xarTplSetMessage($msg,'status');
    xarResponseRedirect(xarModURL('html', 'admin', 'set'));

    // Return
    return true;
}

?>
