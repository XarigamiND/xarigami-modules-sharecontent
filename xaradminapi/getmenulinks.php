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
 * utility function pass individual menu items to the main menu
 *
 * @author the Sharecontent module development team
 * @return array containing the menulinks for the main menu items.
 */
function sharecontent_adminapi_getmenulinks()
{
    // Security Check
    if (xarSecurityCheck('AdminSharecontent',0)) {
        $menulinks[] = Array('url'   => xarModURL('sharecontent', 'admin','webconfig'),
                              'title' => xarML('Enable sharecontent module web sites'),
                              'label' => xarML('Websites Quick Config'),
                              'active' => array('webconfig'));
        $menulinks[] = Array('url'   => xarModURL('sharecontent','admin','mailconfig'),
                              'title' => xarML('Modify sharecontent module mail configuration'),
                              'label' => xarML('Mail config'),
                              'active' => array('mailconfig'));
        $menulinks[] = Array('url'   => xarModURL('sharecontent','admin','view'),
                              'title' => xarML('Manage sharecontent sites'),
                              'label' => xarML('Manage sites'),
                              'active' => array('view','new','modify','delete','update'),
                              'activelabels'=> array('',xarML('Add site'), xarML('Modify site'), xarML('Delete site'), xarML('Preview'))
                              );
        $menulinks[] = Array('url'   => xarModURL('sharecontent','admin','modifyconfig'),
                              'title' => xarML('Modify general configuration'),
                              'label' => xarML('General config'),
                              'active' => array('modifyconfig'));

    }

    if (empty($menulinks)){
        $menulinks = '';
    }

    return $menulinks;
}
?>