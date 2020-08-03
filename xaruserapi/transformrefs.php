<?php
/**
 * @package modules
 * @copyright (C) 2002-2008 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage Xarigami HTML Module
 * @copyright (C) 2007-2012 2skies.com
 * @link http://xarigami.com/project/xarigami_html
 * @author HTML Module development Team
 */
/**
 * Transform hook function for converting internal references
 * @author Jason Judge - for xarpages module
 * @author Jo Dalle Nogare - adapted for xaraya wide implementation
 */
function html_userapi_transformrefs($args)
{
    extract($args);
    // if we have itemtypes and allow hook overrides
    // - We need to check itemtype modvar equivalents

    if (!isset($extrainfo)) {
        return;
    }
    if (!isset($itemtype) && isset($extrainfo['itemtype'])) {
       $itemtype = (int)$extrainfo['itemtype'];
    } else {
       $itemtype = 0;
    }
    if (empty($extrainfo['module'])) {
        $modname = xarModGetName();
    } else {
        $modname = $extrainfo['module'];
    }

    $allowoverrides = (int)xarModGetVar('html','allowhookoverrides');
    //we only use the itemtype modvar if we allow hook overrides
    if (isset($itemtype) &&  $allowoverrides && isset($modname)){
        $transformrefs = xarModGetVar($modname, 'transformrefs.'.$itemtype);
    } else {
        $transformrefs = xarModGetVar('html', 'transformrefs');
    }

    if (empty($transformrefs)) {
        $transformrefs = 0;
    }
    
    // From xarServer::getCurrentUrl())
    $request = xarRequest::getClientURI();
    if (empty($request)) $request = xarRequest::getServerURI(true);
    if (strpos($request, '#') > 0) $request = substr($request, 0, strpos($request, '#'));
    
    if (is_array($extrainfo)) {
        // If the 'transform' array is set, then it lists the elements that
        // should be transformed.
        if (isset($extrainfo['transform']) && is_array($extrainfo['transform'])) {
            $keys = array_flip($extrainfo['transform']);
        } else {
            $keys = array();
        }

        // Loop through elements to transform.
        foreach($extrainfo as $key => $text) {
            if (empty($keys) || isset($keys[$key])) {

                if ($transformrefs) {
                    $extrainfo[$key] = preg_replace('/(<a[^>]+href=")#/i', '$1'.$request.'#', $extrainfo[$key]);
                }
            }
        }
    } else {
        if ($transformrefs) {
            $extrainfo = preg_replace('/(<a[^>]+href=")#/i', '$1'.$request.'#', $extrainfo);
        }
    }

    return $extrainfo;
}

?>