<?php
/**
 * Sharecontent Module
 *
 * @package modules
 * @subpackage Sharecontent Module
 * @copyright (C) 2011-2011 2skies.com
 * @link http://xarigami.com/sharecontent
 */
/**
 * Update configuration
 */
function sharecontent_admin_updateconfig()
{
    // Get parameters

    xarVarFetch('showname', 'checkbox', $showname, FALSE, XARVAR_NOT_REQUIRED);
    xarVarFetch('displayvertical', 'checkbox', $displayvertical, FALSE, XARVAR_NOT_REQUIRED);
    xarVarFetch('usejs', 'checkbox', $usejs, FALSE, XARVAR_NOT_REQUIRED);


    // Confirm authorisation code
    if (!xarSecConfirmAuthKey()) return;
    // Security Check
    if (!xarSecurityCheck('AdminSharecontent')) return;
    xarModSetVar('sharecontent','showname',$showname);
    xarModSetVar('sharecontent','displayvertical',$displayvertical);
    xarModSetVar('sharecontent','usejs',$usejs);
    xarResponseRedirect(xarModURL('sharecontent', 'admin', 'modifyconfig'));

    return true;
}

?>