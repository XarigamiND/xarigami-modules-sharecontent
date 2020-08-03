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
function sharecontent_admin_updatemailconfig()
{
    // Get parameters
    xarVarFetch('enablemail', 'checkbox', $enablemail, false, XARVAR_NOT_REQUIRED);
    xarVarFetch('maxemails', 'int:0:128', $maxemails, 0, XARVAR_NOT_REQUIRED);
    xarVarFetch('htmlmail', 'checkbox', $htmlmail,  false,XARVAR_NOT_REQUIRED);
    xarVarFetch('bcc', 'str', $bcc,'',XARVAR_NOT_REQUIRED);

    if (!xarSecConfirmAuthKey()) return;
    // Security Check
    if (!xarSecurityCheck('AdminSharecontent')) return;

    if (isset($enablemail)) xarModSetVar('sharecontent','enablemail',$enablemail);
    if (isset($maxemails)) xarModSetVar('sharecontent','maxemails',$maxemails);
    if (isset($htmlmail)) xarModSetVar('sharecontent','htmlmail',$htmlmail);
    if (isset($bcc)) xarModSetVar('sharecontent','bcc',$bcc);

    xarResponseRedirect(xarModURL('sharecontent', 'admin', 'mailconfig'));

    return true;
}

?>