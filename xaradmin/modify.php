<?php
/**
 * Xarigami Sharecontent Module
 *
 * @package modules
 * @copyright (C) 2010-2011 2skies.com
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
  * @subpackage Sharecontent Module
 *
 * @copyright (C) 2010-2011 2skies.com
 * @link http://xarigami.com/sharecontent
 */
/**
 * modify an item
 *
 * This function shows a form in which the user can modify the item
 *
 * @param id itemid The id of the dynamic data item to modify
 */
function sharecontent_admin_modify($args)
{
    extract($args);

    if(!xarVarFetch('itemid',   'id', $itemid,   NULL, XARVAR_DONT_SET)) {return;}
    if(!xarVarFetch('objectid', 'id', $objectid, NULL, XARVAR_DONT_SET)) {return;}

    // See if we have to use the universal objectid
    if (!empty($objectid)) {
        $itemid = $objectid;
    }
    // Check if we still have no id of the item to modify.
    if (empty($itemid)) {
        $msg = xarML('Invalid #(1) for #(2) function #(3)() in module #(4)',
                    'item id', 'admin', 'modify', 'sharecontent');
        throw new EmptyParameterException(null,$msg);
    }

    // get the Dynamic Object defined for this module (and itemtype, if relevant)
    $object = xarModAPIFunc('dynamicdata','user','getobject',
                             array('module' => 'sharecontent',
                                   'itemid' => $itemid));
    if (!isset($object)) return;

    // get the values for this item
    $newid = $object->getItem();
    if (!isset($newid) || $newid != $itemid) return;

    // Check if the user can Edit in the sharecontent module, and then specifically for this item.
    // We pass the itemid to the SecurityCheck
    if (!xarSecurityCheck('AdminSharecontent',1)) return;

    // Add the admin menu
    $data['menulinks'] = xarModAPIFunc('sharecontent','admin','getmenulinks');
    $data['itemid'] = $itemid;
    $data['object'] =& $object;

    $item = array();
    $item['module'] = 'sharecontent';
    $hooks = xarModCallHooks('item','modify',$itemid,$item);
    if (empty($hooks)) {
        $data['hooks'] = '';
    } elseif (is_array($hooks)) {
        $data['hooks'] = join('',$hooks);
    } else {
        $data['hooks'] = $hooks;
    }

    // Return the template variables defined in this function
    return $data;
}

?>