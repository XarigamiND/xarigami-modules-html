<?php
/**
 * @package modules
 * @copyright (C) 2002-2008 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage Xarigami HTML Module
 * @copyright (C) 2007-2011 2skies.com
 * @link http://xarigami.com/project/xarigami_html
 * @author HTML Module development Team
 */
/**
 * Modify configuration for a module - hook for ('module','modifyconfig','GUI')
 *
 * @param $args['objectid'] ID of the object
 * @param $args['extrainfo'] extra information
 * @return bool true on success, false on failure
 * @throws BAD_PARAM, NO_PERMISSION, DATABASE_ERROR
 */
function html_admin_modifyconfighook($args)
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

    $itemtype = 0;
    if (isset($extrainfo['itemtype'])) {
        //make sure it is int if we are checking isset later
        $itemtype = (int)$extrainfo['itemtype'];
    }

    $data = array();

    // Get default variable values from the module

    $data['dolinebreak'] = xarModGetVar('html', 'dolinebreak');
    $data['dobreak'] = xarModGetVar('html', 'dobreak');
    $data['transformtype'] = xarModGetVar('html', 'transformtype');
    $data['transformrefs'] = xarModGetVar('html', 'transformrefs');
    //reset with the itemtype modvar if one exisits
    if ($modname != 'html') {
        foreach ($data as $k=>$v) {
            if (isset($itemtype)) {
                $data[$k] = xarModGetVar($modname, $k.'.' . $itemtype);
            }
        }
    }

    $data['modname'] = $modname;

    return xarTplModule('html','admin','modifyconfighook', $data);
}
?>