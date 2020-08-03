<?php
/**
 * Sharecontent Module
 *
 * @package modules
 * @copyright (C) 2002-2007 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
  * @subpackage Sharecontent Module
 *
 * @copyright (C) 2010-2011 2skies.com
 * @link http://xarigami.com/sharecontent
 */
function sharecontent_admin_modifyconfig()
{
     // Security Check
    if (!xarSecurityCheck('AdminSharecontent')) return;
    $showname = xarModGetVar('sharecontent','showname');
    $data['showname'] = $showname;
    $displayvertical = xarModGetVar('sharecontent','displayvertical');
    $data['displayvertical'] = $displayvertical;
    $usejs  = xarModGetVar('sharecontent','usejs');
    $data['usejs'] = $usejs;
    $data['menulinks'] = xarModAPIFunc('sharecontent','admin','getmenulinks');
    $data['authid'] = xarSecGenAuthKey();
    return $data;
}

?>
