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
 * create an item
 *
 * @param str preview When this parameter is set, a preview of the new item is shown.
 */
function sharecontent_admin_create($args)
{
    // we only retrieve 'preview' from the input here - the rest is handled by checkInput()
    if(!xarVarFetch('preview', 'str', $preview,  NULL, XARVAR_DONT_SET)) {return;}

    extract($args);

    // check the authorisation key
    if (!xarSecConfirmAuthKey()) return; // throw back

    // get the Dynamic Object defined for this module (and itemtype, if relevant)
    $object = xarModAPIFunc('dynamicdata','user','getobject',
                             array('module' => 'sharecontent'));
    if (!isset($object)) return;  // throw back

    // check the input values for this object
    $isvalid = $object->checkInput();

    // if we're in preview mode, or if there is some invalid input, show the form again
    if (!empty($preview) || !$isvalid) {
        //common menu links
        $data['menulinks'] = xarModAPIFunc('sharecontent','admin','getmenulinks');

        $data['object'] = & $object;
        $data['authid'] = xarSecGenAuthKey('sharecontent');
        $data['preview'] = $preview;
        $item = array();
        $item['module'] = 'sharecontent';
        $hooks = xarModCallHooks('item','new','',$item);
        if (empty($hooks)) {
            $data['hooks'] = '';
        } elseif (is_array($hooks)) {
            $data['hooks'] = join('',$hooks);
        } else {
            $data['hooks'] = $hooks;
        }
        return xarTplModule('sharecontent','admin','new', $data);
    }

    // create the item here
    // For this function, we use the dynamic data function
    $itemid = $object->createItem();
    if (empty($itemid)) return; // throw back

    // let's go back to the admin view
    xarResponseRedirect(xarModURL('sharecontent', 'admin', 'view'));

    // Return
    return true;
}

?>