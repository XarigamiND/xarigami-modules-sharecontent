<?php
/**
 * Xarigami Sharecontent Module
 *
 * @package modules
 * @copyright (C) 2010-2012 2skies.com
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @subpackage Sharecontent Module
 *
 * @link http://xarigami.com/sharecontent
 * @author - Jo Dalle Nogare
 */
 /* Include the base class */
sys::import('modules.dynamicdata.class.properties');
/*
 * This property has no input only output display. There is no 'value' as such but the validation holds an array containing valid values for display that are copied to the value attribute.
 **/
class Dynamic_Tweet_Property extends Dynamic_Property
{
    public $id         = 2102;
    public $name       = 'tweet';
    public $desc       = 'Twitter tweet';
    public $reqmodules = array('sharecontent');
    public $xv_sendbutton = FALSE;
    public $xv_showcount = 'none';
    public $xv_verbtext = '';
    public $xv_tweeturl = '';
    public $xv_counturl = '';
    public $xv_largebutton = FALSE;
    public $xv_hashtag = '';
    public $xv_recommend = '';
    public $xv_tweettext = '';
    public $xv_showname = FALSE;
    public $xv_tweetname = '';
    public $xv_tweettype = 'twitter-share-button';
    function __construct($args)
    {   //set this first
        $this->setDisplayStatus(Dynamic_Property_Master::DD_DISPLAYSTATE_IGNORED);
        //can be overridden
        parent::__construct($args);
        $this->tplmodule = 'sharecontent';
        $this->template = 'sharecontent';
        $this->filepath = 'modules/sharecontent/xarproperties';

    }
    /*
     * Dummy showinput - there is no input for this property
     */
    public function showInput(Array $data = array())
    {
        $data['value'] = '';
        return parent::showInput($data);
    }

    public function checkInput($name = '', $value = null)
    {
        return TRUE;
    }

   /**
     * Validate the value of this property
     *
     * @param $value value of the property (default is the current value)
     */
    public function validateValue($value = null)
    {
        $isvalid = true;

        if (!isset($value)) {
            $value = $this->validation();
        }else {
            $this->setValue($this->validation());
        }

        $thename = !empty($this->label)?$this->label:$this->name;


        return $isvalid;
    }

    public function showOutput(Array $data = array())
    {
        extract($data);

        //there is no actual value for this property
        //the information is held in the validation
        $validationargs = @unserialize($this->validation);

        if (!isset($validationargs['tweettype'])) $validationargs['tweettype'] = $this->xv_tweettype;
        if (!isset($validationargs['recommend'])) $validationargs['recommend'] = $this->xv_recommend;
       if (!isset($validationargs['tweetname'])) $validationargs['tweetname'] = $this->xv_tweetname;
        $data['tweettype'] = isset($tweettype) && !empty($tweettype)? $tweettype:$validationargs['tweettype'];
        $data['recommend'] = isset($recommend) && !empty($recommend)? $recommend:$validationargs['recommend'];

        $data['tweetname'] = isset($tweetname) && !empty($tweetname)? $tweetname:$validationargs['tweetname'];

        $data['largebutton'] = isset($largebutton) && !empty($largebutton)? 'large':(isset($validationargs['largebutton']) && !empty($validationargs['largebutton']) ? 'large':'medium');
        $data['showname'] = isset($showname) ? $showname:(isset($validationargs['showname']) ? $validationargs['showname']:FALSE);
        $data['hashtag'] = isset($hashtag) && !empty($hashtag)? $hashtag:(isset($validationargs['hashtag'])?$validationargs['hashtag']:'');
        $data['showcount'] = isset($showcount) && !empty($showcount)? $showcount:(isset($validationargs['showcount']) && !empty($validationargs['showcount']) ? $validationargs['showcount']:$this->xv_showcount);
        $data['tweettext'] = isset($tweettext) && !empty($tweettext)? $tweettext:(isset($validationargs['tweettext'])?$validationargs['tweettext']:$this->xv_tweettext);
        $data['tweeturl'] = isset($tweeturl) && !empty($tweeturl)? $tweeturl:(isset($validationargs['tweeturl']) && !empty($validationargs['tweeturl'])? $validationargs['tweeturl']: '');
        $data['counturl'] = isset($counturl) && !empty($counturl)? $counturl:(isset($validationargs['counturl']) && !empty($validationargs['counturl'])? $validationargs['counturl']: '');
        $data['showit'] = 'true';
        if (!isset($data['showcount']) ||  $data['showcount'] == 'none'  || $data['showcount'] == 'false') $data['showit'] = 'false';

        if (empty($data['tweeturl'])) $data['tweeturl'] = xarServerGetCurrentURL();
        if (empty($data['counturl'])) $data['counturl'] = $data['tweeturl'];
        list($module,$data['modtype'], $data['func']) = xarRequestGetInfo();
        $data['module'] = $module;
        $data['itemtype'] = xarRequestGetVar('itemtype');
        $data['itemid'] = xarRequestGetVar('itemid');
        $data['objectid'] = xarRequestGetVar('objectid');

        //jojo - well this is ugly, not usable for all modules, but what else are we going to do
        //unlike hooks we are not handed over the info and have to make many assumptions
        if (!isset($data['itemid']) || empty($data['itemid'])) {
            //try some specifics
            switch ($data['module'])
            {
                case 'articles':
                $data['itemid'] = xarRequestGetVar('aid');
                break;
                case 'xarpages':
                $data['itemid'] = xarRequestGetVar('pid');
                break;
                case 'comments':
                $data['itemid'] = xarRequestGetVar('cid');
                break;
                default:
                $data['itemid'] = xarRequestGetVar('id');
            }
        }
        $argslist = array();
        $info = array();
        if (isset($data['itemid']) && !empty($data['itemid'])) {
            $argslist = array('itemtype'=>$data['itemtype'],'itemids'=>array($data['itemid']));
            $info = xarModAPIFunc($data['module'],'user','getitemlinks',$argslist);
            if (is_array($info)) {
                $info= current($info);
            }
        }

        $data['info'] = $info;
        $info['label'] = isset($info['label']) ?$info['label']:xarML('Item');

        $title =  (!isset($vartitle) && empty($vartitle) && isset($info['label']))?$info['label']:$info['label'];
        $data['title'] = !empty($data['tweettext']) ?$data['tweettext']: $title;
        //$data['tweeturl'] = rawurlencode($data['tweeturl']);

        if (!isset($template)) {
            $template = 'tweet';
        }

        $data['template'] = $template;
        return parent::showOutput($data);
    }


    public function getBaseValidationInfo()
    {
        static $validationarray = array();
        if (empty($validationarray)) {
            $parentvalidation = parent::getBaseValidationInfo();
        $tweetoptions = array('options' =>array(
                                                    array('id'=>'twitter-share-button',  'name' =>xarML('Share a link')),
                                                    array('id'=>'twitter-follow-button',  'name' =>xarML('Follow')),
                                                    array('id'=>'button_hashtag',  'name' =>xarML('Hash tag')),
                                                     array('id'=>'screen_name',  'name' =>xarML('Mention')),
                                                      )
                                                      );
            $validations = array(
                                'xv_tweettype'    =>  array('label'=>xarML('Style of tweet button'),
                                                          'description'=>xarML('Show various styles of buttons'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => $tweetoptions,
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_tweetname'    =>  array('label'=>xarML('@follow/mention name'),
                                                          'description'=>xarML('Twitter name for mention'),
                                                          'propertyname'=>'textbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                           'configinfo'    => xarML('[Required for Follow button]'),
                                                           ),
                                    'xv_showname'    =>  array('label'=>xarML('Show the follow name '),
                                                          'description'=>xarML('Show the follow name in the Follow button'),
                                                          'propertyname'=>'checkbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                           'configinfo'    => xarML('[in Follow button]'),
                                                           ),
                                    'xv_recommend'    =>  array('label'=>xarML('Recommend/via @username'),
                                                          'description'=>xarML('Username in tweet'),
                                                          'propertyname'=>'textbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML('[Default: empty]'),
                                                           ),
                                     'xv_showcount'    =>  array('label'=>xarML('Show count?'),
                                                          'description'=>xarML('Show count.'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => array('options'=>array(
                                                                                            array('none'=> xarML('No count')),
                                                                                            array('horizontal' => xarML('Horizontal')),
                                                                                            array('vertical' => xarML('Vertical'))

                                                                                            )
                                                                            ),
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_largebutton'    =>  array('label'=>xarML('Use large button?'),
                                                          'description'=>xarML('Use large button or small.'),
                                                          'propertyname'=>'checkbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_tweettext'    =>  array('label'=>xarML('Tweet text'),
                                                          'description'=>xarML('Text to tweet.'),
                                                          'propertyname'=>'textbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML("[Default - item title]"),
                                                           ),
                                    'xv_hashtag'    =>  array('label'=>xarML('# Hashtag to use'),
                                                          'description'=>xarML('Use a hashtag in tweet.'),
                                                          'propertyname'=>'textbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML('[Default: empty] Share button only'),
                                                           ),
                                    'xv_tweeturl'    =>  array('label'=>xarML('URL to share'),
                                                          'description'=>xarML('Leave blank for page url'),
                                                          'propertyname'=>'url',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML('[Default if empty - page url]'),
                                                           ),
                                    'xv-counturl'    =>  array('label'=>xarML('URL to count'),
                                                          'description'=>xarML('Leave blank for default of tweet url'),
                                                          'propertyname'=>'url',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML('[Default if empty - the tweet url]'),
                                                           ),
                                         );

            $validationarray = array_merge($validations ,$parentvalidation);
        }
        return $validationarray;
    }
   /**
     * Get the base information for this property.
     *
     * @returns array
     * @return base information for this property
     **/
    function getBasePropertyInfo()
    {
        $baseInfo = array(
                          'id'         => 2102,
                          'name'       => 'tweet',
                          'label'      => 'Share - Twitter tweet',
                          'format'     => '2102',
                          'validation' => '',
                          'source'     => '',
                          'dependancies' => '',
                          'requiresmodule' => 'sharecontent',
                          'filepath' => 'modules/sharecontent/xarproperties',
                          'aliases' => '',
                          'args'         => '',
                          // ...
                         );
        return $baseInfo;
    }

}
?>