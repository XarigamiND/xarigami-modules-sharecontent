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
 * add new item
 */
function sharecontent_admin_new()
{
    $data = array();
    // Add the admin menu

    $data['menulinks'] = xarModAPIFunc('sharecontent','admin','getmenulinks');
    // See if the current user has the privilege to add an item. We cannot pass any extra arguments here
    if (!xarSecurityCheck('AdminSharecontent')) return;

    // get the Dynamic Object defined for this module (and itemtype, if relevant)
    $data['object'] = xarModAPIFunc('dynamicdata','user','getobject',
                                     array('module' => 'sharecontent'));
    $data['authid'] = xarSecGenAuthKey('sharecontent');
    // Set the item as an array
    $item = array();

    // Call the hooks. We tell the hooked module here that we will create a new item
    // TODO: replace join()
    $item['module'] = 'sharecontent';
    $hooks = xarModCallHooks('item','new','',$item);
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