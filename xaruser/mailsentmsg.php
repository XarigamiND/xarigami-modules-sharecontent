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
 * display a splash screen on successful email sent and redirects to
 * original URL
 * @return output with confirmation message and redirect
 * @args['sentto'] array of addresses the mail was sent to
 * @args['returnurl'] url to return to
 * @return output with template information
 */
function sharecontent_user_mailsentmsg($args)
{

    extract($args);
    if (!xarVarFetch('returnurl', 'str', $returnurl,NULL, XARVAR_NOT_REQUIRED)) {return;}
    if (!xarVarFetch('sentto', 'array', $sentto,NULL, XARVAR_NOT_REQUIRED)) {return;}

    if (!isset($returnurl) || !isset($sentto)) {
        $data['notsent'] = 1;
        return $data;
    }

    $data['returnurl'] = $returnurl;
    $data['sentto']= $sentto;

    return $data;

}

?>
