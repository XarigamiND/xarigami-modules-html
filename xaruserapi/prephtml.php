<?php
/**
 * Xaraya HTML Module
 *
 * @package modules
 * @copyright (C) 2008 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage Xarigami HTML Module
 * @copyright (C) 2007-2010 2skies.com
 * @link http://xarigami.com/project/xarigami_html
 * @author HTML Module development Team
 */

/* Prepare text for allowable HTML tags
 * @author Jo dalle Nogare <icedlava@2skies.com>
 * @public
 * @param string $tagtype name of tag type to process (as defined in HTML module GUI)
 * @param string $fields textarea fields to process
 * @return string prepared HTML for output
 */
function html_userapi_prephtml($args)
{
   extract($args);
   static $allowabletags = NULL;

   $alltags = xarModGetVar('html','typelist');

   if (isset($alltags) && !empty($alltags)) {
       $alltags = unserialize($alltags);
   } else {
       $alltags = array('html');
   }
   if (isset($tagtype) && in_array($tagtype,$alltags)) {
        $allowabletags = xarModGetVar('html',$tagtype);
   }
   if (!isset($allowabletags)) {
   // revert to global html
        $allowedHTML = array();
        foreach(xarConfigVars::get(null, 'Site.Core.AllowableHTML', array()) as $k=>$v) {
            if ($k == '!--') {
                if ($v <> 0) {
                    $allowedHTML[] = "$k.*?--";
                }
            } else {
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
            $allowabletags = '~<(' . join('|',$allowedHTML) . ')>~is';
        } else {
            $allowabletags = '';
        }
    }

    $resarray = array();
    $arglist = func_get_args();
    $arglist = $arglist[0];
    $fieldnum = count($arglist);
    unset($arglist['tagtype']);

      foreach ($arglist as $var) {
        // Preparse var to mark the HTML that we want
        if (!empty($allowabletags))
            $var = preg_replace($allowabletags, "\022\\1\024", $var);

        // Prepare var
        $var = htmlspecialchars($var);

        // Fix the HTML that we want
        $var = preg_replace_callback('/\022([^\024]*)\024/',
                                     'xarVarPrepHTMLDisplay__callback',
                                     $var);

        // Fix entities if required
        if (xarConfigVars::get(null, 'Site.Core.FixHTMLEntities', true)) {
            $var = preg_replace('/&amp;([a-z#0-9]+);/i', "&\\1;", $var);
        }

        // Add to array
        array_push($resarray, $var);
    }

    // Return vars
    if (func_num_args() >0) {
        return $resarray[0];
    } else {
        return $resarray;
    }
}

?>