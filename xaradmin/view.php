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
 * view items
 */
function sharecontent_admin_view()
{
    //initialize the data array
    $data = array();

    //common admin menu
    $data['menulinks'] = xarModAPIFunc('sharecontent','admin','getmenulinks');

    if(!xarVarFetch('startnum', 'isset', $data['startnum'], NULL, XARVAR_DONT_SET)) {return;}
    if(!xarVarFetch('catid',    'isset', $data['catid'],    NULL, XARVAR_DONT_SET)) {return;}
    if(!xarVarFetch('sort',     'isset',  $data['sort'],     '', XARVAR_DONT_SET)) {return;}
    if(!xarVarFetch('sortorder', 'pre:trim:alpha:lower:enum:asc:desc',   $data['sortorder'], '', XARVAR_DONT_SET)) {return;}

    // Security check - important to do this as early as possible to avoid
    // potential security holes or just too much wasted processing
    if (!xarSecurityCheck('AdminSharecontent')) return;

    $data['itemsperpage'] = xarModGetVar('sharecontent','itemsperpage');

/* start APPROACH # 1 and # 2 : retrieve the items directly in the template */
    // Note: we don't retrieve any items here ourselves - we'll let the
    //       <xar:data-list ... /> tag do that in the template itself
/* end APPROACH # 1 and # 2 : retrieve the items directly in the template */

/* start APPROACH # 3 : getting the object list via API */
    $mylist = xarModAPIFunc('dynamicdata','user','getitems',
                             array('module'    => 'sharecontent',
                                   'itemtype'  => 0,
                                   'catid'     => $data['catid'],
                                   'numitems'  => $data['itemsperpage'],
                                   'startnum'  => $data['startnum'],
                                   'sort'   =>$data['sort'],
                                   'sortorder' =>    $data['sortorder'],
                                   'status'    => 1,      // only get the properties with status 1 = active
                                   'getobject' => 1));    // get back the object list
/* here we use a different variation than in xaruser.php */
    // pass along the whole object list to the template
    $data['mylist'] = & $mylist;
    // or pass along the properties and values instead of the object list (cfr. xaruser.php)
    //$data['properties'] =& $mylist->getProperties();
    //$data['values'] =& $mylist->items;
/* end APPROACH # 3 : getting the object list via API */

/* start APPROACH # 4 : getting only the raw item values via API */
    $values = xarModAPIFunc('dynamicdata','user','getitems',
                             array('module'   => 'sharecontent',
                                   'itemtype' => 0,
                                   'catid'    => $data['catid'],
                                   'numitems' => $data['itemsperpage'],
                                   'startnum' => $data['startnum'],
                                   'sort'   => $data['sort'],
                                   'sortorder' => $data['sortorder'],
                                   'status'   => 1));
    $data['labels'] = array();
    $data['items'] = array();
    foreach ($values as $itemid => $fields) {
        $data['items'][$itemid] = array();
        foreach ($fields as $name => $value) {
            $data['items'][$itemid][$name] = xarVarPrepForDisplay($value);
            // do some other processing here...
        }
        // define in some labels
        if (count($data['labels']) == 0) {
            foreach (array_keys($fields) as $name) {
                $data['labels'][$name] = xarML(ucfirst($name));
            }
            $data['labels']['options'] = xarML('Options');
        }
    }
/* end APPROACH # 4 : getting only the raw item values via API */

    // Return the template variables defined in this function
    return $data;
}

?>