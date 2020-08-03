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
 * Get subscribed sharecontent sites
 * @param @args['active'] if true get active websites
 * @return array of subscribed sites, or void
 */
function sharecontent_userapi_get($args)
{

    // Security Check
    if(!xarSecurityCheck('ReadSharecontentWeb',0)) {
        return;
    }

    extract($args);
    if (!isset($active)) $active = 0;
    if ($active) {
        $where='WHERE xar_active= TRUE ';
    } else {
        $where='';
    }

    // Database information
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    $sharecontenttable = $xartable['sharecontent'];
    // Get items
    $query = "SELECT xar_id,xar_title,xar_homeurl,xar_submiturl,xar_image,xar_active
              FROM $sharecontenttable
              $where
              ORDER BY xar_title
              ";
    $result = $dbconn->Execute($query);
    if (!$result) return;
    $websites= array();
    while (!$result->EOF) {
        list($id,$title,$homeurl,$submiturl,$image,$xar_active) = $result->fields;
        $websites[$id] = array('title' => $title
                               ,'homeurl' => $homeurl
                               ,'submiturl' => $submiturl
                               ,'image' => $image
                               ,'active' => $xar_active
                               );
        $result->MoveNext();
    }
    $result->close();

    return $websites;
}
?>