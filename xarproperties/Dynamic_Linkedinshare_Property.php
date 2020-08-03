<?php
/**
 * Xarigami Sharecontent Module
 *
 * @package modules
 * @copyright (C) 2010-2011 2skies.com
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
class Dynamic_Linkedinshare_Property extends Dynamic_Property
{
    public $id         = 2104;
    public $name       = 'linkedinshare';
    public $desc       = 'LinkedIn Share';
    public $reqmodules = array('sharecontent');
    public $xv_shareurl = '';
    public $xv_countertype = 'right';
    public $xv_memberdisplay = 'hover';
    public $xv_showcount = true;
    public $xv_companyid = '';
    public $xv_productid = '';
     public $xv_intype= 'Member Profile';

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
        if (!isset($validationargs['memberdisplay'])) $validationargs['memberdisplay'] = $this->xv_memberdisplay;
        if (!isset($validationargs['productid'])) $validationargs['productid'] = $this->xv_productid;
        if (!isset($validationargs['showcount'])) $validationargs['showcount'] = $this->xv_showcount;
        if (!isset($validationargs['companyid'])) $validationargs['companyid'] = $this->xv_companyid;
        if (!isset($validationargs['shareurl'])) $validationargs['shareurl'] = $this->xv_shareurl;
        if (!isset($validationargs['countertype'])) $validationargs['countertype'] = $this->xv_countertype;
        if (!isset($validationargs['intype'])) $validationargs['intype'] = $this->xv_intype;
        $data['memberdisplay'] = isset($memberdisplay) && !empty($memberdisplay)? $memberdisplay:$validationargs['memberdisplay'];
        $data['productid'] = isset($productid) && !empty($productid)? $productid:$validationargs['productid'];
        $data['showcount'] = isset($showcount) && !empty($showcount)? 'true':(isset($validationargs['showcount']) && !empty($validationargs['showcount']) ? 'true':'false');
        $data['companyid'] = isset($companyid) && !empty($companyid)? $companyid:$validationargs['companyid'];
        $data['countertype'] = isset($countertype) && !empty($countertype)? $countertype:$validationargs['countertype'];
        $data['intype'] = isset($intype) && !empty($intype)? $intype:$validationargs['intype'];
        $data['shareurl'] = isset($shareurl) && !empty($shareurl)? $shareurl:$validationargs['shareurl'];
        if (empty($data['shareurl'])) $data['shareurl'] = xarServerGetCurrentURL();


        $data['shareurl']  = rawurlencode($data['shareurl']);

        if (!isset($template)) {
            $template = 'linkedinshare';
        }

        $data['template'] = $template;
        return parent::showOutput($data);
    }


    public function getBaseValidationInfo()
    {
        static $validationarray = array();
        if (empty($validationarray)) {
            $parentvalidation = parent::getBaseValidationInfo();
            $memberdisplayoptions = array('options' =>array(
                                                    array('id'=>'inline',  'name' =>xarML('Inline')),
                                                    array('id'=>'hover',  'name' =>xarML('Hover')),
                                                    array('id'=>'click',  'name' =>xarML('Click'))
                                                      )
                                                      );

            $counteroptions = array('options' =>array(
                                                    array('id'=>'right',  'name' =>xarML('Position right')),
                                                    array('id'=>'top',  'name' =>xarML('Position top')),
                                                    array('id'=>'',  'name' =>xarML('No counter'))
                                                      )
                                                      );
            $buttonoptions = array('options' =>array(
                                                    array('id'=>'MemberProfile',  'name' =>xarML('Member Profile')),
                                                    array('id'=>'Share',  'name' =>xarML('Share URL')),
                                                    array('id'=> 'RecommendProduct', 'name' => xarML('Recommend')),
                                                    array('id'=>'CompanyInsider',  'name' =>xarML('Company Profile'))
                                                      )
                                                      );
            $validations = array(
                                    'xv_intype'    =>  array('label'=>xarML('Type of button'),
                                                          'description'=>xarML('Select type of button to display'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => $buttonoptions,
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_countertype'    =>  array('label'=>xarML('Style of counter'),
                                                          'description'=>xarML('Display of counter and position'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => $counteroptions,
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_memberdisplay'    =>  array('label'=>xarML('Display options'),
                                                          'description'=>xarML('Display format can be on click only, or on hover or inline'),
                                                          'propertyname'=>'dropdown',
                                                          'propargs' => $memberdisplayoptions,
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                     'xv_showcount'    =>  array('label'=>xarML('Show count or related links?'),
                                                          'description'=>xarML('Show count or other related links.'),
                                                          'propertyname'=>'checkbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                       'xv_productid'    =>  array('label'=>xarML('Product ID'),
                                                          'description'=>xarML('Id of Product to recommend.'),
                                                          'propertyname'=>'textbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML("[For Product Recommend only]"),
                                                           ),
                                    'xv_companyid'    =>  array('label'=>xarML('Company name or id'),
                                                          'description'=>xarML('Company name or id to recommend or profile.'),
                                                          'propertyname'=>'textbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML('[For Company Recommend or Company Insider]'),
                                                           ),
                                    'xv_shareurl'    =>  array('label'=>xarML('URL to share or profile URL'),
                                                          'description'=>xarML('Leave blank for page url or enter share URL or profile URL for profile share'),
                                                          'propertyname'=>'url',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition',
                                                          'configinfo'    => xarML('[Default:page URL if empty] Add personal profile URL or other URL to share]'),
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
                          'id'         => 2104,
                          'name'       => 'linkedinshare',
                          'label'      => 'Share - LinkedIn',
                          'format'     => '2104',
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