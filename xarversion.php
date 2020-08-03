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
$modversion['name']         = 'HTML';
$modversion['id']           = '779';
$modversion['directory']    = 'html';
$modversion['version']      = '1.5.0';
$modversion['displayname']  = 'HTML';
$modversion['description']  = 'Configure the allowed HTML or your site';
$modversion['credits']      = 'xardocs/credits.txt';
$modversion['help']         = 'xardocs/help.txt';
$modversion['changelog']    = 'xardocs/changelog.txt';
$modversion['license']      = 'xardocs/license.txt';
$modversion['coding']       = 'xardocs/coding.txt';
$modversion['official']     = 1;
$modversion['author']       = 'John Cox, Jo Dalle Nogare';
$modversion['contact']      = 'xarigami@2skies.com';
$modversion['homepage']      = 'http://xarigami.com/project/xarigami_html';
$modversion['admin']        = 1;
$modversion['user']         = 0;
$modversion['class']        = 'Admin';
$modversion['category']     = 'Global';
$modversion['dependencyinfo']   = array(
                                    0 => array(
                                            'name' => 'core',
                                            'version_ge' => '1.4.0'
                                         )
                                      );
if (false) { //Load and translate once
    xarML('HTML');
    xarML('HTML');
}
?>
