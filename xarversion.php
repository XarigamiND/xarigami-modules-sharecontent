<?php
/**
 * Xarigami Sharecontent Module
 *
 * @package modules
 * @copyright (C) 2002-2007 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @subpackage Sharecontent Module
 *
 * @copyright (C) 2010-2012 2skies.com
 * @link http://xarigami.com/sharecontent
 * @author - original Andrea Moro
 * @author - Jo Dalle Nogare
 */
$modversion['name']           = 'sharecontent';
$modversion['directory']      = 'sharecontent';
$modversion['id']             = '894';
$modversion['version']        = '1.1.1';
$modversion['displayname']    = 'Sharecontent';
$modversion['description']    = 'Social network content sharing';
$modversion['changelog']      = 'xardocs/changelog.txt';
$modversion['license']        = 'http://www.gnu.org/licenses/gpl.html';
$modversion['official']       = 0;
$modversion['author']         = 'Jo Dalle Nogare, Andrea Moro';
$modversion['contact']        = 'http:/xarigami.com';
$modversion['admin']          = 1;
$modversion['user']           = 0;
$modversion['class']          = 'Utility';
$modversion['category']       = 'Utilities';
$modversion['dependencyinfo'] = array(
                                    0 => array(
                                            'name' => 'core',
                                            'version_ge' => '1.4.0'
                                         ),
                                   182 => array(
                                            'name' => 'dynamicdata',
                                            'version_ge' => '1.4.0'
                                         )
                                );
if (false) { //Load and translate once
    xarML('Sharecontent');
    xarML('Social network content sharing');
}
?>