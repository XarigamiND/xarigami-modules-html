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
 * modify configuration
 */
function html_admin_modifyconfig()
{
    // Security Check
    if (!xarSecurityCheck('AdminHTML')) return;

    if (!xarVarFetch('phase', 'str:1:100', $phase, 'modify', XARVAR_NOT_REQUIRED)) return;

    //Set Data Array
    $data                   = array();
    $data['menulinks'] = xarModAPIFunc('html','admin','getmenulinks');
    switch (strtolower($phase)) {
        case 'modify':
        default:

            $data['authid']         = xarSecGenAuthKey();
            $data['submitlabel']    = xarML('Submit');

            // Call Modify Config Hooks
            $hooks = xarModCallHooks('module', 'modifyconfig','html',
                                     array('module'     => 'html',
                                           'itemtype'   => 0));
            $data['dolinebreak'] = xarModGetVar('html', 'dolinebreak');
            $data['dobreak'] = xarModGetVar('html', 'dobreak');
            $data['allowhookoverrides'] = xarModGetVar('html', 'allowhookoverrides');
            $data['transformrefs'] = xarModGetVar('html', 'transformrefs');
            if (empty($hooks)) {
                $hooks = array();
            }
            $data['hooks'] = $hooks;
            break;

        case 'update':
            if (!xarVarFetch('dolinebreak', 'checkbox', $dolinebreak, false, XARVAR_NOT_REQUIRED)) return;
            if (!xarVarFetch('dobreak', 'checkbox', $dobreak, false, XARVAR_NOT_REQUIRED)) return;
            if (!xarVarFetch('transformrefs', 'checkbox', $transformrefs, false, XARVAR_NOT_REQUIRED)) return;
            if (!xarVarFetch('allowhookoverrides', 'checkbox', $allowhookoverrides, false, XARVAR_NOT_REQUIRED)) return;
            if (!xarVarFetch('transformtype', 'int', $transformtype, 1)) return;
            // Confirm authorisation code
            if (!xarSecConfirmAuthKey()) return;
            // Update module variables
            xarModSetVar('html', 'dolinebreak', $dolinebreak);
            xarModSetVar('html', 'dobreak', $dobreak);
            xarModSetVar('html', 'allowhookoverrides', $allowhookoverrides);
            xarModSetVar('html', 'transformtype', $transformtype);
            xarModSetVar('html', 'transformrefs', $transformrefs);
            // Call Update Config Hooks
            xarModCallHooks('module', 'updateconfig','html',
                            array('module'      => 'html',
                                  'itemtype'    => 0));
            $msg = xarML('HTML configuration settings successfully updated.');
            xarTplSetMessage($msg,'status');
            xarResponseRedirect(xarModURL('html', 'admin', 'modifyconfig'));
            // Return
            return true;
            break;
    }
    return $data;
}
?>