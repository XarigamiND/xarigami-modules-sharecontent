<?php
/**
 * Sharecontent module
 *
 * @package modules
 * @copyright (C) 2002-2007 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @subpackage Sharecontent Module
 *
 * @copyright (C) 2010-2011 2skies.com
 * @link http://xarigami.com/sharecontent
 * @author Andrea Moro
 */

/**
 * Upgrades for sharecontent from version 1.0.2
 */

$websites2 = array(
   array('Twitter',
         'https://twitter.com/share',
         'https://twitter.com/share?url=#URL#&text=#TITLE#',
         '/modules/sharecontent/xarimages/tweet.gif',
         true),
      array('Facebook',
         'https://www.facebook.com/sharer.php',
         'https://www.facebook.com/sharer.php?u=#URL#&t=#TITLE#',
         '/modules/sharecontent/xarimages/facebook.png',
         true),
         );
    // The list of currently supported websites
$websites= array(
    array('Blogmarks',
          'https://blogmarks.net',
          'https://blogmarks.net/my/new.php?mini=1&simple=1&url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/blogmarks.png',
          false),
    array('DotNetKicks',
          'https://www.dotnetkicks.com',
          'https://www.dotnetkicks.com/kick/?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/dotnetkicks.png',
          false),
    array('Diigo',
          'https://www.diigo.com',
          'https://www.diigo.com/post?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/diigo.png',
          false),
    array('DZone',
          'https://www.dzone.com',
          'https://www.dzone.com/links/add.html?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/dzone.png',
          false),
    array('Fark',
          'https://www.fark.com',
          'https://www.fark.com/cgi/fark/edit.pl?new_url=#URL#&new_comment=#TITLE#&new_comment=#TITLE#&linktype=Misc',
          'modules/sharecontent/xarimages/fark.png',
          false),
    array('LinkaGoGo',
          'https://www.linkagogo.com',
          'https://www.linkagogo.com/go/AddNoPopup?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/linkagogo.png',
          false),
    array('Windows Live',
          'https://favorites.live.com',
          'https://favorites.live.com/quickadd.aspx?marklet=1&mkt=en-us&url=#URL#&title=#TITLE#&top=1',
          'modules/sharecontent/xarimages/live.png',
          false),
    array('Netvouz',
          'https://netvouz.com',
          'https://netvouz.com/action/submitBookmark?url=#URL#&title=#TITLE#&description=#TITLE#',
          'modules/sharecontent/xarimages/netvouz.png',
          false),
    array('Reddit',
          'https://reddit.com',
          'https://reddit.com/submit?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/reddit.png',
          true),
    array('Slashdot',
          'https://www.slashdot.org',
          'https://slashdot.org/bookmark.pl?title=#TITLE#&url=#URL#',
          'modules/sharecontent/xarimages/slashdot.png',
          true),
   );
?>
