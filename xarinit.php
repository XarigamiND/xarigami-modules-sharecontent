<?php
/**
 * Sharecontent Module
 *
 * @package modules
 * @copyright (C) 2002-2006 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @subpackage Sharecontent Module
 *
 * @copyright (C) 2010-2012 2skies.com
 * @link http://xarigami.com/sharecontent
 */
/**
 * initialise the sharecontent module
 */
function sharecontent_init()
{
    // Get database information
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    // Load Table Maintainance API
    xarDBLoadTableMaintenanceAPI();
    // Create table
    $fields = array('xar_id' => array('type' => 'integer', 'null' => false, 'increment' => true, 'primary_key' => true),
        'xar_title' => array('type' => 'varchar', 'size'=>64, 'null' => false),
        'xar_homeurl' => array('type' => 'varchar', 'size'=>128),
        'xar_submiturl' => array('type' => 'varchar', 'size'=>128,'null' => false),
        'xar_image' => array('type' => 'varchar', 'size' => 128),
        'xar_active' => array('type' => 'boolean', 'null'=>false, 'default' => '1')
        );

    // Create the Table - the function will return the SQL is successful or
    // raise an exception if it fails, in this case $query is empty
    $query = xarDBCreateTable($xartable['sharecontent'], $fields);
    if (empty($query)) return; // throw back

    // Pass the Table Create DDL to adodb to create the table and
    // send exception if unsuccessful
    $result = $dbconn->Execute($query);
    if (!$result) return;

    // Load the initial setup of the publication types
    //now done through dynamic data
    /*if (file_exists('modules/sharecontent/xarsetup.php')) {
        include 'modules/sharecontent/xarsetup.php';
    } else {
        // TODO: add some defaults here
        $websites= array();
    }*/
    //add object for managing site link data
        $filepath = sys::code().'modules/sharecontent/xardata/sharecontent_sites';
        $objectid = xarModAPIFunc('dynamicdata','util','import',
                          array('file' => $filepath.'-def.xml'));
        if (empty($objectid)) return;
        // save the object id for later
        xarModSetVar('sharecontent','objectid_sharecontent_sites',$objectid);
        //Load Dynamic Data object with data
        $objectid = xarModAPIFunc('dynamicdata','util','import',
                              array('file' => $filepath.'-dat.xml'));
        if (empty($objectid)) return;

    // Save  websites
   /* foreach ($websites as $website) {
        list($title,$homeurl,$submiturl,$image,$active) = $website;
        $nextId = $dbconn->GenId($xartable['sharecontent']);
        $query = "INSERT INTO $xartable[sharecontent] (xar_id,xar_title, xar_homeurl, xar_submiturl, xar_image,xar_active) VALUES (?,?,?,?,?,?)";
        $bindvars = array($nextId,$title,$homeurl,$submiturl,$image,$active);
        $result = $dbconn->Execute($query,$bindvars);
        if (!$result)  sharecontent_delete();
    }*/

    // Set up module variables
    xarModSetVar('sharecontent', 'enablemail', '0');
    xarModSetVar('sharecontent', 'maxemails', '1');
    xarModSetVar('sharecontent', 'htmlmail', '0');

    // Set up module hooks
    if (!xarModRegisterHook('item', 'display','GUI',
            'sharecontent',
            'user',
            'display')) {
        return false;
    }

    // define instances
    $query = "SELECT DISTINCT xar_smodule FROM $xartable[hooks] WHERE xar_tmodule='sharecontent'  ";
    $instances = array( array('header'=>'Hooked module','query'=>$query,'limit'=>20));
    xarDefineInstance('sharecontent', 'Web', $instances);
    xarDefineInstance('sharecontent', 'Mail', $instances);

    // Register the module components that are privileges objects
    // Format: xarregisterMask(Name,Realm,Module,Component,Instance,Level,Description)
    xarRegisterMask('ReadSharecontentWeb', 'All', 'sharecontent', 'Web', 'All', 'ACCESS_READ');
    xarRegisterMask('SendSharecontentMail', 'All', 'sharecontent', 'Mail', 'All', 'ACCESS_COMMENT');
    xarRegisterMask('AdminSharecontent', 'All', 'sharecontent', 'All', 'All', 'ACCESS_ADMIN');

    /* This init function brings our module to version 0.9.1, run the upgrades for the rest of the initialisation */
    return sharecontent_upgrade('0.9.2');
}

/**
 * upgrade the sharecontent module from an old version
 * @param string oldversion
 * @return bool true on success of upgrade
 */
function sharecontent_upgrade($oldversion)
{
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    // Load Table Maintainance API
    xarDBLoadTableMaintenanceAPI();

    // Upgrade dependent on old version number
    switch ($oldversion) {
        case '0.9.2':
            xarModSetVar('sharecontent', 'bcc', '');
        case '0.9.3': //jojo - DEPRECATE THIS STEP at Version 1.1.0
            //only carry this out if we have not already created an object in install
            $objectid = xarModGetVar('sharecontent','objectid_sharecontent_sites');
            if (isset($objectid) && !empty($objectid)) {
                //seems as tho already installed
            } else {
                // Pass the Table Create DDL to adodb to create the table and
                // send exception if unsuccessful
                $dbconn = xarDBGetConn();
                $xartable = xarDBGetTables();

                // Load the initial setup of the publication types
                if (file_exists(sys::code().'modules/sharecontent/xarsetup.php')) {
                    sys::import('modules.sharecontent.xarsetup');
                } else {
                    // TODO: add some defaults here
                    $websites= array();
                }
                // Save  websites
                foreach ($websites2 as $website) {
                    list($title,$homeurl,$submiturl,$image,$active) = $website;
                    $nextId = $dbconn->GenId($xartable['sharecontent']);
                    $query = "INSERT INTO $xartable[sharecontent] (xar_id,xar_title, xar_homeurl, xar_submiturl, xar_image,xar_active) VALUES (?,?,?,?,?,?)";
                    $bindvars = array($nextId,$title,$homeurl,$submiturl,$image,$active);
                    $result = $dbconn->Execute($query,$bindvars);
                    if (!$result)  sharecontent_delete();
                }
            }

        case '0.9.4': //jojo - DEPRECATE this step at Version 1.1.0

            $objectid = xarModGetVar('sharecontent','objectid_sharecontent_sites');
            if (isset($objectid) && !empty($objectid)) {
                //seems as tho already installed
            } else {
                $dbconn = xarDBGetConn();
                $xartable = xarDBGetTables();

                // Load the initial setup of the publication types
                if (file_exists(sys::code().'modules/sharecontent/xarsetup.php')) {
                    sys::import('modules.sharecontent.xarsetup');
                } else {
                    // TODO: add some defaults here
                    $websites= array();
                }

                // Save  websites
                foreach ($websites3 as $website) {
                    list($title,$homeurl,$submiturl,$image,$active) = $website;
                    $nextId = $dbconn->GenId($xartable['sharecontent']);
                    $query = "INSERT INTO $xartable[sharecontent] (xar_id,xar_title, xar_homeurl, xar_submiturl, xar_image,xar_active) VALUES (?,?,?,?,?,?)";
                    $bindvars = array($nextId,$title,$homeurl,$submiturl,$image,$active);
                    $result = $dbconn->Execute($query,$bindvars);
                    if (!$result)  sharecontent_delete();
                }
            }
        case '0.9.5':
        //fall through - update to signify template changes for jquery and xarigami
        case '0.9.6':
            //add object for managing site link data if not already added
            //let's check
            $objectid = xarModGetVar('sharecontent','objectid_sharecontent_sites');
            if (isset($objectid) && !empty($objectid)) {
                //seems as tho already installed
            } else {
                $objectid = xarModAPIFunc('dynamicdata','util','import',
                              array('file' => 'modules/sharecontent/xardata/sharecontent_sites-def.xml'));
                if (empty($objectid)) return;
                // save the object id for later
                xarModSetVar('sharecontent','objectid_sharecontent_sites',$objectid);
            }
        case '1.0.0':
            //update to reflect 1.4.0 core changes
        case '1.0.1':
        case '1.0.2': //current version
            xarModSetVar('sharecontent','showname',FALSE);
            xarModSetVar('sharecontent','displayvertical',FALSE);
            xarModSetVar('sharecontent','usejs',FALSE);
            // Load the setup of the publication types
            if (file_exists(sys::code().'modules/sharecontent/xarsetup.php')) {
                include sys::code().'modules/sharecontent/xarsetup.php';
            } else {
                // TODO: add some defaults here
                $websites4= array();
            }
            // Save  websites
                foreach ($websites4 as $website) {
                    list($title,$homeurl,$submiturl,$image,$active) = $website;
                    $nextId = $dbconn->GenId($xartable['sharecontent']);
                    $query = "INSERT INTO $xartable[sharecontent] (xar_id,xar_title, xar_homeurl, xar_submiturl, xar_image,xar_active) VALUES (?,?,?,?,?,?)";
                    $bindvars = array($nextId,$title,$homeurl,$submiturl,$image,$active);
                    $result = $dbconn->Execute($query,$bindvars);
                    if (!$result)  sharecontent_delete();
                }
       case '1.1.1': //update to signify some code changes as per change log
        case '1.1.0': //current version
    }

    return true;
}

/**
 * delete the sharecontent module
 * @return bool true on successfull deletion
 */
function sharecontent_delete()
{
    // Remove module hooks
    if (!xarModUnregisterHook('item', 'display','GUI','sharecontent', 'user','display')) return;

    if (!xarModUnregisterHook('module', 'remove', 'API', 'sharecontent', 'admin', 'deleteall')) {
        return;
    }
    //remove sharecontent object
     $objectid = xarModGetVar('sharecontent','objectid_sharecontent_sites');
        if (!empty($objectid)) {
            xarModAPIFunc('dynamicdata','admin','deleteobject',array('objectid' => $objectid));
        }

    // Delete module variables
    xarModDelAllVars('sharecontent');
    // Get database information
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();

    xarDBLoadTableMaintenanceAPI();
    // Delete tables
    // Generate the SQL to drop the table using the API
    $query = xarDBDropTable($xartable['sharecontent']);
    if (empty($query)) return; // throw back
    // Drop the table and send exception if returns false.
    $result = $dbconn->Execute($query);
    if (!$result) return;
    // Remove Masks and Instances
    xarRemoveMasks('sharecontent');
    xarRemoveInstances('sharecontent');
    // Deletion successful
    return true;
}

?>