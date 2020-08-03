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
class Dynamic_Facebooklike_Property extends Dynamic_Property
{
    public $id         = 2101;
    public $name       = 'facebooklike';
    public $desc       = 'Facebook Like';
    public $reqmodules = array('sharecontent');
    public $xv_layoutstyle = 'standard';
    public $xv_sendbutton = FALSE;
    public $xv_displaywidth = 450; //px
    public $xv_showfaces = FALSE;
    public $xv_verbtext = 'like';
     public $xv_likeurl = '';
    public $xv_scheme ='light';
    function __construct($args)
    {   //set this first
        $this->setDisplayStatus(Dynamic_Property_Master::DD_DISPLAYSTATE_IGNORED);
        //can be overridden
        parent::__construct($args);
        $this->tplmodule = 'sharecontent';
        $this->template = 'sharecontent';
        $this->filepath = 'modules/sharecontent/xarproperties';
        if (!isset($verbtext) || empty($verbtext) || empty($this->xv_verbtext)) $this->xv_verbtext= xarML('like');
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

        if (!isset($validationargs['layoutstyle'])) $validationargs['layoutstyle'] = $this->xv_layoutstyle;
        if (!isset($validationargs['scheme'])) $validationargs['scheme'] = $this->xv_scheme;
        if (!isset($validationargs['sendbutton'])) $validationargs['sendbutton'] = $this->xv_sendbutton;
        if (!isset($validationargs['displaywidth'])) $validationargs['displaywidth'] = $this->xv_displaywidth;
        if (!isset($validationargs['showfaces'])) $validationargs['showfaces'] = $this->xv_showfaces;
        if (!isset($validationargs['verbtext'])) $validationargs['verbtext'] = $this->xv_verbtext;
        if (!isset($validationargs['likeurl'])) $validationargs['likeurl'] = $this->xv_likeurl;

        $data['layoutstyle'] = isset($layoutstyle) && !empty($layoutstyle)? $layoutstyle:$validationargs['layoutstyle'];
        $data['scheme'] = isset($scheme) && !empty($scheme)? $scheme:$validationargs['scheme'];
        $data['sendbutton'] = isset($sendbutton) && !empty($sendbutton)? 'true':(isset($validationargs['sendbutton']) && !empty($validationargs['sendbutton']) ? 'true':'false');
        $data['displaywidth'] = isset($displaywidth) && !empty($displaywidth)? $displaywidth:$validationargs['displaywidth'];
        $data['showfaces'] = isset($showfaces) && !empty($showfaces)? 'true':(isset($validationargs['showfaces']) && !empty($validationargs['showfaces']) ? 'true':'false');
        $data['verbtext'] = isset($verbtext) && !empty($verbtext)? $verbtext:$validationargs['verbtext'];
        $data['likeurl'] = isset($likeurl) && !empty($likeurl)? $likeurl:$validationargs['likeurl'];
        if (empty($data['likeurl'])) $data['likeurl'] = xarServerGetCurrentURL();

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
        $returnurl = isset($info['url'])?$info['url']:xarServerGetCurrentURL(array(),true);
        $title =  (!isset($vartitle) && empty($vartitle) && isset($info['label']))?$info['label']:$info['label'];
        $data['title'] = $title;

        if (!isset($template)) {
            $template = 'facebooklike';
        }
        $data['template'] = $template;
        return parent::showOutput($data);
    }


    public function getBaseValidationInfo()
    {
        static $validationarray = array();
        if (empty($validationarray)) {
            $parentvalidation = parent::getBaseValidationInfo();
            $schemeoptions = array('options' =>array(
                                                    array('id'=>'light',  'name' =>xarML('Light')),
                                                    array('id'=>'dark',  'name' =>xarML('Dark'))
                                                      )
                                                      );
            $layoutoptions = array('options' =>array(
                                                    array('id'=>'standard',  'name' =>xarML('Standard')),
                                                    array('id'=>'button_count',  'name' =>xarML('Button count')),
                                                    array('id'=>'box_count',  'name' =>xarML('Box count'))
                                                      )
                                                      );
            $validations = array(
                                    'xv_layoutstyle'    =>  array('label'=>xarML('Style of like button'),
                                                          'description'=>xarML('Show various styles of buttons'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => $layoutoptions,
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_scheme'    =>  array('label'=>xarML('Color scheme'),
                                                          'description'=>xarML('Color scheme of the button'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => $schemeoptions,
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                     'xv_sendbutton'    =>  array('label'=>xarML('Sent button?'),
                                                          'description'=>xarML('Display sent button.'),
                                                          'propertyname'=>'checkbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_showfaces'    =>  array('label'=>xarML('Show faces?'),
                                                          'description'=>xarML('Show profile picture below button.'),
                                                          'propertyname'=>'checkbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_verbtext'    =>  array('label'=>xarML('Text display'),
                                                          'description'=>xarML('Verb to display as text.'),
                                                          'propertyname'=>'textbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML("[Default - 'Like']"),
                                                           ),
                                    'xv_displaywidth'    =>  array('label'=>xarML('Display width?'),
                                                          'description'=>xarML('Display width of the plugin in pixels.'),
                                                          'propertyname'=>'integerbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML('[in pixels]'),
                                                           ),
                                    'xv_likeurl'    =>  array('label'=>xarML('URL to like'),
                                                          'description'=>xarML('Leave blank for page url'),
                                                          'propertyname'=>'url',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML('[Default if empty - page url]'),
                                                           )
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
                          'id'         => 2101,
                          'name'       => 'facebooklike',
                          'label'      => 'Share - Facebook Like',
                          'format'     => '2101',
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