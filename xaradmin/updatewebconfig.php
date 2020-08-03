<?php
/**
 * Sharecontent Module
 *
 * @package modules
 * @copyright (C) 2002-2006 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @subpackage Sharecontent Module
 *
 * @copyright (C) 2010-2011 2skies.com
 * @link http://xarigami.com/sharecontent
 */
/**
 * Update configuration
 */
function sharecontent_admin_updatewebconfig()
{
    // Get parameters
    //if(!xarVarFetch('active', 'array', $active, array(), XARVAR_NOT_REQUIRED)) {return;}
   if(!xarVarFetch('weblist', 'array', $weblist, array(), XARVAR_NOT_REQUIRED)) {return;}


    // Confirm authorisation code
    if (!xarSecConfirmAuthKey()) return;
    // Security Check
    if (!xarSecurityCheck('AdminSharecontent')) return;

    if (!xarModAPIFunc('sharecontent','admin','update',array('active'=>$weblist))) {
       return;
    }

    xarResponseRedirect(xarModURL('sharecontent', 'admin', 'webconfig'));

    return true;
}

?>