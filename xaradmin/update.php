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
 * update an item
 */
function sharecontent_admin_update($args)
{
    if(!xarVarFetch('itemid',   'id', $itemid,   NULL, XARVAR_DONT_SET)) {return;}
    if(!xarVarFetch('objectid', 'id', $objectid, NULL, XARVAR_DONT_SET)) {return;}
    if(!xarVarFetch('preview', 'str', $preview,  NULL, XARVAR_DONT_SET)) {return;}
    extract($args);

    if (!empty($objectid)) {
        $itemid = $objectid;
    }

    if (empty($itemid)) {
        $msg = xarML('Invalid #(1) for #(2) function #(3)() in module #(4)',
                    'item id', 'admin', 'update', 'sharecontent');
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

    // check the input values for this object
    $isvalid = $object->checkInput();

    // if we're in preview mode, or if there is some invalid input, show the form again
    if (!empty($preview) || !$isvalid) {
        $data['menulinks'] = xarModAPIFunc('sharecontent','admin','getmenulinks');

        $data['object'] = & $object;
        $data['itemid'] = $itemid;

        $data['preview'] = $preview;

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

        return xarTplModule('sharecontent','admin','modify', $data);
    }

    // update the item
    $itemid = $object->updateItem();

    if (empty($itemid)) return; // throw back

    // let's go back to the admin view
    xarResponseRedirect(xarModURL('sharecontent', 'admin', 'view'));

    // Return
    return true;
}
?>
