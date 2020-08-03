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
 * Delete an tag type
 *
 * @public
 * @author Richard Cave
 * @return array, or false on failure
 * @throws BAD_PARAM
 */
function html_admin_deletetype()
{
    // Security Check
    if(!xarSecurityCheck('DeleteHTML')) return;

    // Get parameters from input
    if (!xarVarFetch('id', 'int:0:', $id)) return;
    if (!xarVarFetch('confirm', 'int:0:1', $confirm, 0)) return;

    // Get the current html tag
    $type = xarModAPIFunc('html',
                          'user',
                          'gettype',
                          array('id' => $id));

    // Check for exceptions
    if (!isset($type) && xarCurrentErrorType() != XAR_NO_EXCEPTION)
        return; // throw back
    $data['menulinks'] = xarModAPIFunc('html','admin','getmenulinks');
    // Check for confirmation.
    if (!$confirm) {

        // Specify for which html tag you want confirmation
        $data['id'] = $id;

        // Data to display in the template
        $data['type'] = xarVarPrepForDisplay($type['type']);
        $data['submitlabel'] = xarML('Delete Type');

        // Generate a one-time authorisation code for this operation
        $data['authid'] = xarSecGenAuthKey();

        // Return the template variables defined in this function
        return $data;
    }

    // If we get here it means that the user has confirmed the action

    // Confirm authorisation code
    if (!xarSecConfirmAuthKey()) {
        $msg = xarML('Invalid authorization key for deleting #(1) HTML tag #(2)',
                    'HTML', xarVarPrepForDisplay($cid));
        throw new ForbiddenOperationException(null,$msg);
    }

    // Remove the html tag
    if (!xarModAPIFunc('html',
                       'admin',
                       'deletetype',
                       array('id' => $id))) {
        return; // throw back
    }

     $msg = xarML('HTML tag  type was successfully deleted.');
    xarTplSetMessage($msg,'status');

    // Redirect
    xarResponseRedirect(xarModURL('html', 'admin', 'viewtypes'));

    // Return
    return true;
}

?>
