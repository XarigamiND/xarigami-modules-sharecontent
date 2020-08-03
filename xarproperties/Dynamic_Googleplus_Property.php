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
class Dynamic_Googleplus_Property extends Dynamic_Property
{
    public $id         = 2103;
    public $name       = 'googleplus';
    public $desc       = 'Google plus One';
    public $reqmodules = array('sharecontent');

    public $xv_plusurl = '';
    public $xv_displaywidth = 450; //in pixels
    public $xv_buttonsize = 'standard';
    public $xv_annotation = 'bubble';
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

        if (!isset($validationargs['plusurl'])) $validationargs['plusurl'] = $this->xv_plusurl;

        $data['buttonsize'] = isset($buttonsize) && !empty($buttonsize)? $buttonsize:(isset($validationargs['buttonsize'])?$validationargs['buttonsize']:$this->xv_buttonsize);
        $data['annotation'] = isset($annotation) && !empty($annotation)? $annotation:(isset($validationargs['annotation'])?$validationargs['annotation']:$this->xv_annotation);
        $data['displaywidth'] = isset($displaywidth) && !empty($displaywidth)? $displaywidth:(isset($validationargs['displaywidth'])?$validationargs['displaywidth']:$this->xv_displaywidth);
        $data['plusurl'] = isset($plusurl) && !empty($plusurl)? $plusurl:$validationargs['plusurl'];
        if (empty($data['plusurl'])) $data['plusurl'] = xarServerGetCurrentURL();

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
        $data['title'] = !empty($data['tweettext']) ?$data['tweettext']: $title;

        if (!isset($template)) {
            $template = 'googleplus';
        }

        $data['template'] = $template;
        return parent::showOutput($data);
    }


    public function getBaseValidationInfo()
    {
        static $validationarray = array();
        if (empty($validationarray)) {
            $parentvalidation = parent::getBaseValidationInfo();
        $buttonsize = array('options' =>array(
                                                    array('id'=>'small',  'name' =>xarML('Small')),
                                                    array('id'=>'standard',  'name' =>xarML('Standard')),
                                                    array('id'=>'medium',  'name' =>xarML('Medium')),
                                                     array('id'=>'tall',  'name' =>xarML('Tall')),
                                                      )
                                                      );
        $annotationops = array('options' =>array(
                                                    array('id'=>'bubble',  'name' =>xarML('Bubble')),
                                                    array('id'=>'inline',  'name' =>xarML('Inline text')),
                                                    array('id'=>'none',  'name' =>xarML('None'))
                                                      )
                                                      );
            $validations = array(
                                'xv_buttonsize'    =>  array('label'=>xarML('Size of button'),
                                                          'description'=>xarML('Size of google plus one button.'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => $buttonsize,
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                'xv_annotation'    =>  array('label'=>xarML('Text annotation'),
                                                          'description'=>xarML('Type of annotation.'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => $annotationops,
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_displaywidth'    =>  array('label'=>xarML('Display width'),
                                                          'description'=>xarML('Width of widget'),
                                                          'propertyname'=>'integerbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                           'configinfo'    => xarML('[in pixels]'),
                                                           ),
                                            'xv_plusurl'    =>  array('label'=>xarML('URL to share'),
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
                          'id'         => 2103,
                          'name'       => 'googleplus',
                          'label'      => 'Share - Google +1',
                          'format'     => '2103',
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