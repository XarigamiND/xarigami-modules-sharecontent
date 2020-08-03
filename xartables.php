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
 * specifies module tables namees
 *
 * @author  Andrea Moro
 * @access  public
 * @param   none
 * @return  $xartable array
 * @throws  no exceptions
 * @todo    nothing
*/
function sharecontent_xartables()
{
    // Initialise table array
    $xartable = array();
    // Name for sharecontent database entities
    $sharecontent = xarDBGetSiteTablePrefix() . '_sharecontent';
    // Table name
    $xartable['sharecontent'] = $sharecontent;
    // Return table information
    return $xartable;
}

?>
