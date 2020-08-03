<?php
/**
 * @package modules
 * @copyright (C) 2002-2008 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
  *
 * @subpackage Xarigami HTML Module
 * @copyright (C) 2007-2010 2skies.com
 * @link http://xarigami.com/project/xarigami_html
 * @author HTML Module development Team
 */
/**
 * update configuration for a module - hook for ('module','updateconfig','API')
 *
 * @param $args['objectid'] ID of the object
 * @param $args['extrainfo'] extra information
 * @return bool
 * @throws BAD_PARAM, NO_PERMISSION, DATABASE_ERROR
 */

function html_adminapi_updateconfighook($args)
{
    extract($args);

    if (!isset($extrainfo)) {
        $extrainfo = array();
    }

    // When called via hooks, the module name may be empty, so we get it from
    // the current module
    if (empty($extrainfo['module'])) {
        $modname = xarModGetName();
    } else {
        $modname = $extrainfo['module'];
    }

    $modid = xarModGetIDFromName($modname);
    if (empty($modid)) {
        throw new EmptyParameterException('modid');
    }


    if (!xarVarFetch('dolinebreak', 'checkbox', $settings['dolinebreak'], false, XARVAR_NOT_REQUIRED)) return;
    if (!xarVarFetch('dobreak', 'checkbox',  $settings['dobreak'], false, XARVAR_NOT_REQUIRED)) return;
    if (!xarVarFetch('transformtype', 'int', $settings['transformtype'], 1)) return;
    if (!xarVarFetch('transformrefs', 'checkbox',  $settings['transformrefs'], false, XARVAR_NOT_REQUIRED)) return;

    $itemtype = 0;
    if (isset($extrainfo['itemtype'])) {
        $itemtype = (int)$extrainfo['itemtype'];
    }

    foreach ($settings as $k=>$v) {
        if (($modname =="html") || !isset($itemtype)) {
            xarModSetVar('html', $k,  $settings[$k]);
        } else {
            xarModSetVar($modname, $k.'.' . $itemtype, $settings[$k]);
        }
    }
    return $extrainfo;
}
?>