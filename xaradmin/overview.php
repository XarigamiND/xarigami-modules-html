<?php
/**
 * Xaraya HTML Module
 *
 * @package modules
 * @copyright (C) 2002-2006 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage Xarigami HTML Module
 * @copyright (C) 2007-2010 2skies.com
 * @link http://xarigami.com/project/xarigami_html
 * @author HTML Module development Team
 */

/**
 * Overview displays standard Overview page
 *
 * Only used if you actually supply an overview link in your adminapi menulink function
 * and used to call the template that provides display of the overview
 *
 * @returns array xarTplModule with $data containing template data
 * @return array containing the menulinks for the overview item on the main manu
 * @since 2 Oct 2005
 */
function html_admin_overview()
{
   /* Security Check */
    if (!xarSecurityCheck('AdminHTML')) return;

    $data=array();
    $data['menulinks'] = xarModAPIFunc('html','admin','getmenulinks');
    /* if there is a separate overview function return data to it
     * else just call the main function that usually displays the overview
     */

    return xarTplModule('html', 'admin', 'main', $data, 'main');
}

?>