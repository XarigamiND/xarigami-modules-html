<?php
/**
 * Xaraya HTML Module
 *
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
 * Update the allowed HTML
 *
 * @public
 * @author John Cox
 * @author Richard Cave
 * @author Jo Dalle Nogare
 * @param $args['tags'] an array of the cids and allowed value of the html tags
 * @throws MISSING_DATA
 */
function html_admin_updateset()
{
    // Confirm authorisation code.
    if (!xarSecConfirmAuthKey()) return;

    // Security Check
    if(!xarSecurityCheck('AdminHTML')) return;

    // Get parameters from the input
    if (!xarVarFetch('tags', 'array:1:', $tags)) {
        $msg = xarML('No HTML tags were selected.');
        throw new DataNotFoundException(null,$msg);
    }

    // Initialize array for config vars
    $allowedhtml = array();
    //Initialize array for modvars;
    $allowablehtml = array();
    $allowedtypes = xarModAPIFunc('html','user','getalltypes');
    // Update HTML tags
    foreach ($tags as $cid=>$allowed) {
        // Get the cid of the htmltag
        $thistag = xarModAPIFunc('html', 'user','gettag',
                                 array('cid' => $cid));

        if ($thistag) {
            $tag = $thistag['tag'];

            // Check if update is necessary
            if ($thistag['allowed'] != $allowed) {
                // Update
                if (!xarModAPIFunc('html', 'admin', 'update',
                                   array('cid' => $cid,
                                         'allowed' => $allowed)))
                    return false;
            }


            $tagtype = $thistag['type'];
            $allowablehtml[$tagtype][$tag] = $allowed;
            // If this is an html tag, then
            // also update the config vars array
            if ($thistag['type'] == 'html') {
                $allowedhtml[$tag] = $allowed;
            }
        }
    }

    if (!empty($allowablehtml)) {
        $typelist = array();
        foreach($allowedtypes as $allowedtype) {
            $typelist[]=$allowedtype['type'];
            if (isset($allowablehtml[$allowedtype['type']])) {
               $thistypehtml =$allowablehtml[$allowedtype['type']];
               $allowedHTML = array();
               foreach($thistypehtml as $k=>$v) {
                   if ($k == '!--') {
                       if ($v <> 0) {
                           $allowedHTML[] = "$k.*?--";
                       }
                   }else {
                       switch($v) {
                           case 0:
                               break;
                           case 1:
                                $allowedHTML[] = "/?$k\s*/?";
                                break;
                           case 2:
                                $allowedHTML[] = "/?$k(\s+[^>]*)?/?";
                                break;
                           }
                   }
               }
               if (count($allowedHTML) > 0) {
                   $allowedtags = '~<(' . join('|',$allowedHTML) . ')>~is';
               } else {
                  $allowedtags = '';
               }
            }
            xarModSetVar('html',$allowedtype['type'],$allowedtags);
        }
    }
    $typelist = serialize($typelist);
    xarModSetVar('html','typelist',$typelist);
    // Set config vars
    xarConfigSetVar('Site.Core.AllowableHTML', $allowedhtml);
        $msg = xarML('Allowed HTML was successfully updated.');
    xarTplSetMessage($msg,'status');
    // Redirect back to set
    xarResponseRedirect(xarModURL('html', 'admin', 'set'));

    return true;
}

?>