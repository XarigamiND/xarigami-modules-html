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
 * Transform text
 *
 * @public
 * @author John Cox
 * @param $args['extrainfo'] string or array of text items
 * @return mixed string or array of transformed text items
 * @throws BAD_PARAM
 */
function html_userapi_transforminput($args)
{
    // Get arguments from argument array
    extract($args);

    // Argument check
    if (!isset($extrainfo)) {
        return;
    }

    if (is_array($extrainfo)) {
        if (isset($extrainfo['transform']) && is_array($extrainfo['transform'])) {
            foreach ($extrainfo['transform'] as $key) {
                if (isset($extrainfo[$key])) {
                    $extrainfo[$key] = html_userapitransforminput($extrainfo[$key]);
                }
            }
            return $extrainfo;
        }
        $transformed = array();
        foreach($extrainfo as $text) {
            $transformed[] = html_userapitransforminput($text);
        }
    } else {
        $transformed = html_userapitransforminput($text);
    }

    return $transformed;
}

/**
 * Transform text api
 *
 * @private
 * @author John Cox
 */
function html_userapitransforminput($text)
{
    $validxhtml     = xarModGetVar('html', 'validxhtml');
    $addparagraphs  = xarModGetVar('html', 'addparagraphs');

    // Step 1 look for valid xhtml -> html transforms.
    // Credit to Rabbitt for fixing
    // hexey's (http://www.evilwalrus.com/viewcode.php?codeEx=482)
    // stuff that didn't work - THIS WAS A PITA !!!

    /* Let's comment this out for release and dig back into it later.
    $search  = array ("'(<\/?)(br|hr)([^>]*)( />)'ie",
                      "'(<\/?)(br|hr)([^>]*)(/>)'ie",
                      "'(\w+=)\"([A-Za-z0-9%:;_ -]+)\"'ie",
                      "'(<\/?)(br|hr)([^>]*)(>)'ie",
                      "'(\w+=)(\w+)'ie",
                      "'(\w+=)([|])([A-Za-z0-9%:;_ -]+)([|])'ie"
                     );
    $replace = array ("'<$2$3>'",
                      "'<$2$3>'",
                      "strtolower('$1').'|$2|'",
                      "'<'.strtolower('$2').'$3'.' />'",
                      "strtolower('$1').'\"$2\"'",
                      "strtolower('$1').'\"$3\"'"
                     );

    $text = preg_replace($search, $replace, $text);
    */
    return $text;
}

?>