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
/**
 * Overview function that displays the standard Overview page
 *
 */
function sharecontent_admin_overview()
{
   /* Security Check */
    if (!xarSecurityCheck('AdminSharecontent',0)) return;

    $data=array();

    /* if there is a separate overview function return data to it
     * else just call the main function that displays the overview
     */
    $data['menulinks'] = xarModAPIFunc('sharecontent','admin','getmenulinks');
    return xarTplModule('sharecontent', 'admin', 'main', $data,'main');
}

?>
