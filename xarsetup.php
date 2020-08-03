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

$websites4 = array(
   array('Twitter',
         'https://twitter.com/share',
         'https://twitter.com/share?url=#URL#&text=#TITLE#',
         '/modules/sharecontent/xarimages/tweet.gif',
         true),
      array('Facebook',
         'http://www.facebook.com/sharer.php',
         'http://www.facebook.com/sharer.php?u=#URL#&t=#TITLE#',
         '/modules/sharecontent/xarimages/facebook.png',
         true),
      array('Google +',
         'https://plusone.google.com/_/+1/confirm',
         'https://plusone.google.com/_/+1/confirm?hl=en&url=#URL#&text=#TITLE#',
         '/modules/sharecontent/xarimages/googleplus.gif',
         true)
         );
$websites3 = array(
   array('ZicZac',
         'http://ziczac.it/',
         'http://ziczac.it/a/segnala/?gurl=#URL#&gtit=#TITLE#',
         'http://ziczac.it/a/e/zzsmall.png',
         true)
         );
    // The list of currently supported websites
$websites2= array(
    array('OKNO',
          'http://oknotizie.alice.it',
          'http://oknotizie.alice.it/post?title=#TITLE#&url=#URL#',
          'modules/sharecontent/xarimages/okno.png',
          true),
    array('Segnalo',
          'http://segnalo.alice.it',
          'http://segnalo.alice.it/post.html.php?title=#TITLE#&url=#URL#',
          'modules/sharecontent/xarimages/segnalo.png',
          true)
);
$websites= array(
    array('del.icio.us',
          'http://del.icio.us',
          'http://del.icio.us/post?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/delicious.png',
          true),
    array('Blinklist',
          'http://www.blinklist.com',
          'http://www.blinklist.com/index.php?Action=Blink/addblink.php&Url=#URL#&Title=#TITLE#',
          'modules/sharecontent/xarimages/blink.png',
          true),
    array('Blinkbits',
          'http://www.blinkbits.com',
          'http://www.blinkbits.com/bookmarklets/save.php?v=1&source_url=#URL#&title=#TITLE#&body=#TITLE#',
          'modules/sharecontent/xarimages/blinkbits.png',
          true),
    array('Blogmarks',
          'http://blogmarks.net',
          'http://blogmarks.net/my/new.php?mini=1&simple=1&url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/blogmarks.png',
          true)
    ,array('BlogMemes',
          'http://www.blogmemes.net',
          'http://www.blogmemes.net/post.php?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/blogmemes.png',
          true),
    array('Blue Dot',
          'http://bluedot.us',
          'http://bluedot.us/Authoring.aspx?>u=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/bluedot.png',
          true),
    array('BuddyMarks',
          'http://buddymarks.com',
          'http://buddymarks.com/add_bookmark.php?bookmark_title=#TITLE#&bookmark_url=#URL#',
          'modules/sharecontent/xarimages/buddymarks.png',
          true),
    array('Bumpzee',
          'http://www.bumpzee.com',
          'http://www.bumpzee.com/bump.php?u=#URL#',
          'modules/sharecontent/xarimages/bumpzee.png',
          true),
    array('DotNetKicks',
          'http://www.dotnetkicks.com',
          'http://www.dotnetkicks.com/kick/?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/dotnetkicks.png',
          true),
    array('Connotea',
                'http://www.connotea.org',
          'http://www.connotea.org/addpopup?continue=confirm&uri=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/connotea.png',
          true),
    array('Del.irio.us',
          'http://de.lirio.us',
          'http://de.lirio.us/rubric/post?uri=#URL#;title=#TITLE#;when_done=go_back',
          'modules/sharecontent/xarimages/delirious.png',
          true)
    ,array('Digg',
          'http://digg.com',
          'http://digg.com/submit?phase=2&url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/digg.png',
          true),
    array('Diigo',
          'http://www.diigo.com',
          'http://www.diigo.com/post?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/diigo.png',
          true),
    array('DZone',
          'http://www.dzone.com',
          'http://www.dzone.com/links/add.html?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/dzone.png',
          true),
    array('Earthlink',
          'http://myfavorites.earthlink.net',
          'http://myfavorites.earthlink.net/my/add_favorite?v=1&url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/earthlink.png',
          true),
    array('Fark',
          'http://cgi.fark.com',
          'http://cgi.fark.com/cgi/fark/edit.pl?new_url=#URL#&new_comment=#TITLE#&new_comment=#TITLE#&linktype=Misc',
          'modules/sharecontent/xarimages/fark.png',
          true),
    array('FeedMeLinks',
          'http://feedmelinks.com',
          'http://feedmelinks.com/categorize?from=toolbar&op=submit&url=#URL#&name=#TITLE#',
          'modules/sharecontent/xarimages/feedmelinks.png',
          true),
    array('Furl',
          'http://www.furl.net',
          'http://www.furl.net/storeIt.jsp?u=#URL#&t=#TITLE#',
          'modules/sharecontent/xarimages/furl.png',
          true),
    array('givealink.org',
                'http://www.givealink.org/',
          'http://www.givealink.org/cgi-pub/bookmarklet/bookmarkletLogin.cgi?&uri=#URL#&title=#TITLE#&done=go_back',
          'modules/sharecontent/xarimages/givealink.png',
          true),
    array('Google bookmarks',
          'http://www.google.com/bookmarks',
          'http://www.google.com/bookmarks/mark?op=edit&bkmk=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/google.png',
          true),
    array('Igooi',
          'http://www.igooi.com',
          'http://www.igooi.com/addnewitem.aspx?self=1&noui=yes&jump=close&url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/igooi.png',
          true),
    array('Kick.ie',
                'http://kick.ie',
          'http://kick.ie/submit/?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/kickit.png',
          true),
    array('Lilisto',
          'http://lister.lilisto.com',
          'http://lister.lilisto.com/?t=#TITLE#&l=#URL#',
          'modules/sharecontent/xarimages/lilisto.png',
          true),
    array('LinkaGoGo',
          'http://www.linkagogo.com',
          'http://www.linkagogo.com/go/AddNoPopup?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/linkagogo.png',
          true),
    array('Windows Live',
                'https://favorites.live.com',
          'https://favorites.live.com/quickadd.aspx?marklet=1&mkt=en-us&url=#URL#&title=#TITLE#&top=1',
          'modules/sharecontent/xarimages/live.png',
          true),
    array('LookLater',
          'http://api.looklater.com',
          'http://api.looklater.com/bookmarks/save?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/looklater.png',
          true),
    array('Ma.gnolia',
          'http://ma.gnolia.com',
          'http://ma.gnolia.com/beta/bookmarklet/add?url=#URL#&title=#TITLE#&description=#TITLE#',
          'modules/sharecontent/xarimages/magnolia.png',
          true),
    array('Mr Wong',
                'hhtp://www.mister-wong.de',
          'http://www.mister-wong.de/index.php?action=addurl&bm_url=#URL#&bm_description=#TITLE#',
          'modules/sharecontent/xarimages/mrwong.png',
          true),
    array('Yahoo MyWeb',
          'http://myweb2.search.yahoo.com',
          'http://myweb2.search.yahoo.com/myresults/bookmarklet?u=#URL#&=#TITLE#',
          'modules/sharecontent/xarimages/myyahoo.png',
          true),
    array('Netscape',
          'http://www.netscape.com',
          'http://www.netscape.com/submit/?U=#URL#&T=#TITLE#',
          'modules/sharecontent/xarimages/netscape.png',
          true),
    array('Netvouz',
          'http://www.netvouz.com',
          'http://www.netvouz.com/action/submitBookmark?url=#URL#&title=#TITLE#&description=#TITLE#',
          'modules/sharecontent/xarimages/netvouz.png',
          true),
    array('Newsvine',
          'http://www.newsvine.com',
          'http://www.newsvine.com/_tools/seed&save?u=#URL#&h=#TITLE#',
          'modules/sharecontent/xarimages/newsvine.png',
          true),
    array('Onlywire',
          'http://www.onlywire.com',
          'http://www.onlywire.com/b/?u=#URL#&t=#TITLE#',
          'modules/sharecontent/xarimages/onlywire.png',
          true),
    array('PlugIM',
          'http://www.plugim.com',
          'http://www.plugim.com/submit?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/plugim.png',
          true),
    array('PopCurrent',
          'http://popcurrent.com',
          'http://popcurrent.com/submit?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/popcurrent.png',
          true),
    array('PPNow',
          'http://www.ppnow.net',
          'http://www.ppnow.net/submit.php?url=#URL#',
          'modules/sharecontent/xarimages/ppnow.png',
          true),
    array('RawSugar',
          'http://www.rawsugar.com',
          'http://www.rawsugar.com/tagger/?turl=#URL#&tttl=#TITLE#',
          'modules/sharecontent/xarimages/rawsugar.png',
          true),
    array('Recruiting',
          'http://www.recruiting.com',
          'http://www.recruiting.com/storylink/vote?edit[url]=#URL#&edit[title]=#TITLE#',
          'modules/sharecontent/xarimages/rplus.png',
          true),
    array('Reddit',
          'http://reddit.com',
          'http://reddit.com/submit?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/reddit.png',
          true),
    array('Rojo',
          'http://www.rojo.com',
          'http://www.rojo.com/submit/?url=#URL#&title=#TITLE#&summary=&ready=true',
          'modules/sharecontent/xarimages/rojo.png',
          true),
    array('Scoopeo',
          'http://www.scoopeo.com',
          'http://www.scoopeo.com/scoop/new?newurl=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/scoopeo.png',
          true),
    array('Scuttle',
          'http://www.scuttle.org',
          'http://www.scuttle.org/bookmarks.php/maxpower?action=add&address=#URL#&title=#TITLE#&description=#TITLE#',
          'modules/sharecontent/xarimages/scuttle.png',
          true),
    array('Shadows',
          'http://www.shadows.com',
          'http://www.shadows.com/features/tcr.htm?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/shadows.png',
          true),
    array('Simpy',
          'http://www.simpy.com',
          'http://www.simpy.com/simpy/LinkAdd.do?href=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/simpy.png',
          true),
    array('Slashdot',
          'http://www.slashdot.org',
          'http://slashdot.org/bookmark.pl?title=#TITLE#&url=#URL#',
          'modules/sharecontent/xarimages/slashdot.png',
          true),
    array('Smarking',
          'http://smarking.com',
          'http://smarking.com/editbookmark/?url=#URL#&description=#TITLE#',
          'modules/sharecontent/xarimages/smarking.png',
          true),
    array('SphereIt',
          'http://www.sphere.com',
          'http://www.sphere.com/search?q=sphereit:#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/sphere.png',
          true),
    array('Spurl',
          'http://www.spurl.net',
          'http://www.spurl.net/spurl.php?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/spurl.png',
          true),
    array('Squidoo',
          'http://www.squidoo.com',
          'http://www.squidoo.com/lensmaster/bookmark?#URL#',
          'modules/sharecontent/xarimages/squidoo.png',
          true),
    array('StumbleUpon',
          'http://www.stumbleupon.com',
          'http://www.stumbleupon.com/submit?url=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/stumbleupon.png',
          true),
    array('Taggly',
          'http://taggly.com',
          'http://taggly.com/bookmarks.php/pass?action=add&address=#URL#',
          'modules/sharecontent/xarimages/taggly.png',
          true),
    array('Tagtooga',
          'http://www.tagtooga.com',
          'http://www.tagtooga.com/tapp/db.exe?c=jsEntryForm&b=fx&title=#TITLE#&url=#URL#',
          'modules/sharecontent/xarimages/tagtooga.png',
          true),
    array('TailRank',
          'http://tailrank.com',
          'http://tailrank.com/share/?text=&link_href=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/tailrank.png',
          true),
    array('TalkDigger',
          'http://www.talkdigger.com',
          'http://www.talkdigger.com/index.php?surl=#URL#',
          'modules/sharecontent/xarimages/talkdigger.png',
          true),
    array('Technorati',
          'http://www.technorati.com',
          'http://www.technorati.com/faves?add=#URL#',
          'modules/sharecontent/xarimages/technorati.png',
          true),
    array('ThisNext',
          'http://www.thisnext.com',
          'http://www.thisnext.com/pick/new/submit/sociable/?url=#URL#&name=#TITLE#',
          'modules/sharecontent/xarimages/thisnext.png',
          true),
    array('WebRide',
          'http://webride.org',
          'http://webride.org/discuss/split.php?uri=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/webride.png',
          true),
    array('Wists',
          'http://wists.com/',
          'http://wists.com/s.php?c=&r=#URL#&title=#TITLE#',
          'modules/sharecontent/xarimages/wists.png',
            true),
     array('JeQQ',
           'http://jeqq.com',
           'http://jeqq.com/submit.php?phase=2&url=#URL#&title=#TITLE#&body=#TITLE#',
           'modules/sharecontent/xarimages/jeqq.png',
           true),
     array('co.mments',
           'http://co.mments.com',
           'http://co.mments.com/track?url=#URL#&title=#TITLE#',
           'modules/sharecontent/xarimages/co.mments.gif',
           true),
     array('Fleck',
        'http://fleck.com',
        'http://extension.fleck.com/?v=b.0.804&url=#URL#',
        'modules/sharecontent/xarimages/fleck.gif',
           true),
     array('Gwar',
           'http://www.gwar.pl',
           'http://www.gwar.pl/DodajGwar.html?u=#URL#',
           'modules/sharecontent/xarimages/gwar.gif',
           true) ,
     array('Hemidemi',
           'http://www.hemidemi.com',
        'http://www.hemidemi.com/user_bookmark/new?title=#TITLE#&url=#URL#',
        'modules/sharecontent/xarimages/hemidemi.png',
           true)
      ,array('IndiaGram',
        'http://www.indiagram.com',
        'http://www.indiagram.com/mock/bookmarks/desitrain?action=add&address=#URL#&title=#TITLE#',
        'modules/sharecontent/xarimages/indiagram.png',
           true)
       ,array('IndianPad',
        'http://www.indianpad.com',
        'http://www.indianpad.com/submite.php?url=#URL#',
        'modules/sharecontent/xarimages/indianpad.png',
           true)
       ,array('Linkter',
        'http://www.linkter.hu',
        'http://www.linkter.hu/index.php?action=suggest_link&url=#URL#&title=#TITLE#',
        'modules/sharecontent/xarimages/linkter.png',
           true) ,
       array('MyShare',
        'http://myshare.url.com.tw',
        'http://myshare.url.com.tw/index.php?func=newurl&url=#URL#&desc=#TITLE#',
        'modules/sharecontent/xarimages/myshare.png',
           true)
       ,array('Rec6',
        'http://www.syxt.com.br',
        'http://www.syxt.com.br/rec6/link.php?url=#URL#&=#TITLE#',
        'modules/sharecontent/xarimages/rec6.gif',
           true) ,
       array('Wykop',
        'http://www.wykop.pl',
        'http://www.wykop.pl/dodaj?url=#URL#',
        'modules/sharecontent/xarimages/wykop.gif',
           true)
   );
?>