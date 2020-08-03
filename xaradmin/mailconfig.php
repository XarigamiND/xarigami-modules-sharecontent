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
 * Update the configuration parameters of the module based on data from the modification form
 *
 * @author Andrea Moro
 * @access public
 * @param no $ parameters
 * @return true on success or void on failure
 * @throws no exceptions
 * @todo nothing
 */
function sharecontent_admin_mailconfig()
{
    // Security Check
    if (!xarSecurityCheck('AdminSharecontent')) return;

    if (!$data['enablemail']=xarModGetVar('sharecontent','enablemail')) {
        $data['enablemail']=0;
    }
    if (!$data['maxemails']=xarModGetVar('sharecontent','maxemails')) {
        $data['maxemails']=0;
    }
    if (!$data['htmlmail']=xarModGetVar('sharecontent','htmlmail')) {
        $data['htmlmail']=0;
    }
    if (!$data['bcc']=xarModGetVar('sharecontent','bcc')) {
        $data['bcc']='';
    }
    $data['menulinks'] = xarModAPIFunc('sharecontent','admin','getmenulinks');
    $data['authid'] = xarSecGenAuthKey();
    return $data;
}

?>
