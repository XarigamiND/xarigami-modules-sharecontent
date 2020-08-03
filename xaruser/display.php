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
 * display sharecontent for a specific item, and request sharecontent
 * @param $args['objectid'] ID of the item this sharecontent is for
 * @param $args['extrainfo'] array of item information: module, returnurl, itemtype
 * @return output with sharecontent information
 */
function sharecontent_user_display($args)
{
    extract($args);
    $data = array();
    $data['objectid'] = $objectid;

    $itemtype = 0;
    if (isset($extrainfo) && is_array($extrainfo)) {
        if (isset($extrainfo['module']) && is_string($extrainfo['module'])) {
            $modname = $extrainfo['module'];
        }
        if (isset($extrainfo['returnurl']) && is_string($extrainfo['returnurl'])) {
            $data['returnurl'] = rawurlencode($extrainfo['returnurl']);
            unset($extrainfo['returnurl']);
        }
    } else {
        $data['returnurl'] = $extrainfo;
    }

    if (empty($modname)) {
        $modname = xarModGetName();
    }

    $extrainfo['modid'] = xarModGetIDFromName($modname);
    // get only enabled sites
    $args['active']=1;
    // Run API function
    if ($websites = xarModAPIFunc('sharecontent', 'user', 'get',$args)) {
        if (isset($websites)) {
            // Set the cached variable if requested
            if (xarVarIsCached('Hooks.sharecontent','save') &&
                xarVarGetCached('Hooks.sharecontent','save') == true) {
                xarVarSetCached('Hooks.sharecontent','value',$websites);
            }

            foreach($websites as $key=>$website) {
                $submiturl = $website['submiturl'];
                //$dataurl = preg_replace('/&amp;/','%2526',$data['returnurl']);
                $dataurl = $data['returnurl'];
                $submiturl = preg_replace('/#URL#/',$dataurl,$submiturl);
                if (isset($extrainfo['title'])) {
                    // needs to do it twice for some sites
                    $submiturl = preg_replace('/#TITLE#/',$extrainfo['title'],$submiturl);
                    $submiturl = preg_replace('/#TITLE#/',$extrainfo['title'],$submiturl);
                }
                $websites[$key]['submiturl']=$submiturl;
            }
        }
    }
    if (xarModGetVar('sharecontent','enablemail') and
        xarSecurityCheck('SendSharecontentMail', 0, 'Mail', $modname))
    {
        $data['authid'] = xarSecGenAuthKey('sharecontent');
        $data['usercansend'] = '1';
        $data['extrainfo'] = serialize($extrainfo);
    } else {
        $data['usercansend'] = '0';
    }
    $usejs = xarModGetVar('sharecontent','usejs');
    $data['usejs'] = isset($usejs)?$usejs: 0;
    $displayvertical = xarModGetVar('sharecontent','displayvertical');
    $data['displayvertical'] = isset($displayvertical)?$displayvertical: 0;
    $showname = xarModGetVar('sharecontent','showname');
    $data['showname'] = isset($showname)? $showname: 0;

    //setup js check for any js sites we know of eg twitter, facebook, google plus
    $data['twitterjs'] = 0;
    $data['facebookjs'] = 0;
    $data['gplusjs'] = 0;
    if ($data['usejs'] == 1) {
        foreach ($websites as $k=> $webinfo)
        {
            if (preg_match('/twitter/',strtolower($webinfo['title']),$match))
            {
           $data['twitterjs'] = 1;
            }
           if (preg_match('/facebook/',strtolower($webinfo['title']),$match))
           {
             $data['facebookjs'] = 1;
           }
           if (preg_match('/google/',strtolower($webinfo['title']),$match)) {
             $data['gplusjs'] = 1;
           }

        }
    }
    if (xarSecurityCheck('ReadSharecontentWeb', 0, 'All', $modname)) {
        $data['websites'] = $websites;
    }  else {
        $data['websites'] = array();
    }
    return $data;
}

?>
