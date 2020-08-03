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
 * Utility function pass individual menu items to the main menu
 *
 * @access public
 * @author John Cox
 * @author Richard Cave
 * @author the HTML module development team
 * @return array containing the menulinks for the main menu items.
 */
function html_adminapi_getmenulinks()
{


    if (xarSecurityCheck('AddHTML',0)) {

        $menulinks[] = Array('url'   => xarModURL('html', 'admin', 'new'),
                              'title' => xarML('Add a new tag.'),
                              'label' => xarML('Add Tag'),
                              'active'=> array('new'));

        $menulinks[] = Array('url'   => xarModURL('html', 'admin', 'newtype'),
                              'title' => xarML('Add a new tag type for use on your site.'),
                              'label' => xarML('Add Tag Type'),
                              'active'=>array('newtype'));
    }
    if (xarSecurityCheck('ReadHTML',0)) {
        $menulinks[] = Array('url'   => xarModURL('html', 'admin', 'viewtypes'),
                              'title' => xarML('View and edit tag types.'),
                              'label' => xarML('Manage Tag Types'),
                              'active'=>array('viewtypes','edittype','deletetype'));
    }
    if (xarSecurityCheck('AdminHTML',0)) {
        $menulinks[] = Array('url'   => xarModURL('html', 'admin', 'set'),
                              'title' => xarML('Set and edit the allowed tags for use on your site'),
                              'label' => xarML('Manage Tags'),
                              'active'=> array('set','edit','delete'));

        $menulinks[] = Array('url'   => xarModURL('html', 'admin', 'modifyconfig'),
                              'title' => xarML('Modify the configuration of the HTML Module'),
                              'label' => xarML('Modify Config'),
                              'active' =>array('modifyconfig'));
    }
    if (empty($menulinks)){
        $menulinks = '';
    }
    return $menulinks;
}
?>
