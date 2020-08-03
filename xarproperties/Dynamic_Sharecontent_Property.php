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
class Dynamic_Sharecontent_Property extends Dynamic_Property
{
    public $id         = 2100;
    public $name       = 'sharecontent';
    public $desc       = 'Share Content';
    public $reqmodules = array('sharecontent');
    public $xv_showname = FALSE;
    public $xv_usejs  = FALSE;
    public $xv_displayvertical = FALSE;
    public $xv_websitelist = array();

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

            if (isset($validationargs['websitelist']) && is_array($validationargs['websitelist'])) {
                $websitevalues = $validationargs['websitelist'];
            } elseif (isset($validationargs['websitelist'])) {
                $websitevalues = @unserialize($validationargs['websitelist']);
            } else {
                $websitevalues = array();
            }
         if (isset($data['websitelist']) && is_array($data['websitelist']) && empty($websitevalues)) $websitevalues = $data['websitelist'];
        if (empty($websitevalues)) {

            //get the default from the configuration of the module
            $websiteinfo = xarModAPIFunc('sharecontent','user','get',array('active'=>1));
            $websitevalues = array_keys($websiteinfo);
        }

        list($module,$data['modtype'], $data['func']) = xarRequestGetInfo();
        $data['module'] = $module;
        $data['itemtype'] = xarRequestGetVar('itemtype');
        $data['itemid'] = xarRequestGetVar('itemid');
        $data['objectid'] = xarRequestGetVar('objectid');
         $data['vartitle'] = xarRequestGetVar('title'); //standard i guess for most things but ....
        //jojo - well this is ugly, not usable for all modules, but what else are we going to do
        //unlike hooks we are not handed over the info and have to make too many assumptions
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

        $info= array();
        if (isset($data['itemid']) && !empty($data['itemid'])) {
            $argslist = array('itemtype'=>$data['itemtype'],'itemids'=>array($data['itemid']));
            $info = xarModAPIFunc($data['module'],'user','getitemlinks',$argslist);
            if (is_array($info)) {
                $info= current($info);
            }
        }
        $data['info'] = $info;
        $info['label'] = isset($info['label']) ?$info['label']:xarML('Item');
        $returnurl = isset($info['url'])?$info['url']:xarServerGetCurrentURL();
        $dataurl = $returnurl;
        $title =  (!isset($vartitle) && empty($vartitle) && isset($info['title']))?$info['title']:$info['label'];
        $data['title'] = $title;

        $enablemail = isset($validationargs['enablemail'])?$validationargs['enablemail']:0;
        $data['shownames'] = isset($data['shownames']) ? $data['shownames']:( isset($validationargs['shownames'])?$validationargs['shownames']:0);
        $data['usejs'] = isset($data['usejs']) ? $data['usejs']: (isset($validationargs['usejs'])?$validationargs['usejs']:0);
        $data['displayvertical'] = isset($data['displayvertical']) ? $data['displayvertical']: (isset($validationargs['displayvertical'])?$validationargs['displayvertical']:0);
        $weblist= xarModAPIFunc('sharecontent', 'user', 'get');

        $websites = array();
        $weblistkeys = array_keys($weblist);

        foreach($websitevalues as $key) {

            if (in_array($key,$weblistkeys)) {
                $websites[$key] = $weblist[$key];
                $submiturl =  $weblist[$key]['submiturl'];
                $submiturl = preg_replace('/#URL#/',$dataurl,$submiturl);
                if (isset($title)) {
                    // needs to do it twice for some sites
                    $submiturl = preg_replace('/#TITLE#/',$title,$submiturl);
                    $submiturl = preg_replace('/#TITLE#/',$title,$submiturl);
                }
                $websites[$key]['submiturl']=$submiturl;

            }
       }

       //now for emails
       $data['returnurl'] = $returnurl;
        if (($enablemail == TRUE) && xarSecurityCheck('SendSharecontentMail', 0, 'Mail', $module))
        {
            $data['authid'] = xarSecGenAuthKey('sharecontent');
            $data['usercansend'] = '1';
            //use same terminology as hook so we can reuse functions/templates
            $extrainfo = array('module'=>$module,
                               'itemtype'=> $data['itemtype'],
                               'title'=> $title,
                               'modid'=>xarModGetIDFromName($module)
                                );
            $data['extrainfo'] = serialize($extrainfo);
        } else {
            $data['usercansend'] = '0';
        }

        if (xarSecurityCheck('ReadSharecontentWeb', 0, 'All', $module)) {
            $data['websites'] = $websites;
        }  else {
            $data['websites'] = array();
        }

        return parent::showOutput($data);
    }


/**
     * Show the current validation rule in a specific form for this property type
     *
     * @param $args['name'] name of the field (default is 'dd_NN' with NN the property id)
     * @param $args['validation'] validation rule (default is the current validation)
     * @param $args['id'] id of the field
     * @param $args['tabindex'] tab index of the field
     * @returns string
     * @return string containing the HTML (or other) text to output in the BL template
     */
    function showValidation(Array $args = array())
    {
        extract($args);

        $data = array();
        $data['name']       = !empty($name) ? $name : 'dd_'.$this->id;
        $data['id']         = !empty($id)   ? $id   : 'dd_'.$this->id;
        $data['tabindex']   = !empty($tabindex) ? $tabindex : 0;
        $data['invalid']    = !empty($this->invalid) ? xarML('Invalid #(1)', $this->invalid) :'';
        $data['size']       = !empty($size) ? $size : 50;

        if (isset($validation)) {
            $this->validation = $validation;
        }
        if (!is_array($this->validation)) {
            $validationargs = @unserialize($this->validation);
        } else {
             $validationargs = $this->validation;
        }
        if (isset($websitelist) && !empty($websitelist) && is_array($websitelist))
        {
            $websitevalues = $websitelist;
        } elseif  (isset($validationargs['websitelist']) && is_array($validationargs['websitelist'])){
            $websitevalues = $validationargs['websitelist'];
        } elseif (isset($validationargs['websitelist'])) {
            $websitevalues = unserialize(  $validationargs['websitelist']);
        } else {
             $websitevalues = array();
        }
        $websitevalues = array_values($websitevalues);
        $enablemail = isset($validationargs['enablemail'])?$validationargs['enablemail']:false;
        $websites = xarModAPIFunc('sharecontent', 'user', 'get');
        $websitearray= array();
        $websitevaluearray = array();
        foreach($websites as $key=>$info) {
            $websitearray[$key] = '<img src="'.$info['image'].'" alt="'.$info['title'].'" /> '.$info['title'];
        }
        $data['websitevalues'] = implode(',',$websitevalues);
        $data['websitearray'] = $websitearray;
        $data['websites'] = $websites;
        $data['websitenum'] = count($websites);
        $data['enablemail'] = $enablemail;
        $data['shownames'] = isset($validationargs['shownames'])?$validationargs['shownames']:0;
        $data['usejs'] = isset($validationargs['usejs'])?$validationargs['usejs']:0;
         $data['displayvertical'] = isset($validationargs['displayvertical'])?$validationargs['displayvertical']:0;
        if (!isset($template)) {
            $template = 'sharecontent';
        }

        $data['template'] = $template;
        return xarTplProperty('sharecontent', 'sharecontent', 'validation', $data);
    }
    /**
     * Update the current validation rule in a specific way for each property type
     *
     * @param $args['name'] name of the field (default is 'dd_NN' with NN the property id)
     * @param $args['validation'] new validation rule
     * @param $args['id'] id of the field
     * @return bool true if the validation rule could be processed, false otherwise
     */

     function updateValidation(Array $args = array())
     {
         extract($args);

         // in case we need to process additional input fields based on the name
         if (empty($name)) {
             $name = 'dd_'.$this->id;
         }
         if (isset( $validation['websitelist']) && is_array( $validation['websitelist'])) {
             $validation['websitelist'] = serialize( $validation['websitelist']);
         }
         // do something with the validation and save it in $this->validation
         if (isset($validation)) {
             if (is_array($validation)) {
                     $this->validation = serialize($validation);
             } else {
                 $this->validation = $validation;
             }
         }
        $this->value = $this->validation;
         // tell the calling function that everything is OK
         return true;
     }

    public function getBaseValidationInfo()
    {
        static $validationarray = array();
        if (empty($validationarray)) {
            $parentvalidation = parent::getBaseValidationInfo();

            $validations = array(
                                    'xv_showname'    =>  array('label'=>xarML('Display name'),
                                                          'description'=>xarML('Display share site name'),
                                                          'propertyname'=>'checkbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                     'xv_displayvertical'    =>  array('label'=>xarML('Display vertical'),
                                                          'description'=>xarML('Display as vertical list'),
                                                          'propertyname'=>'checkbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_usejs'    =>  array('label'=>xarML('Use javascript?'),
                                                          'description'=>xarML('Use enhanced javascript display for share sites that support it.'),
                                                          'propertyname'=>'checkbox',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
                                                           ),
                                    'xv_websitelist'    =>  array('label'=>xarML('Website list'),
                                                          'description'=>xarML('List of websites to display'),
                                                          'propertyname'=>'checkboxlist',
                                                          'ignore_empty'  =>1,
                                                          'ctype'=>'definition'
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
                          'id'         => 2100,
                          'name'       => 'sharecontent',
                          'label'      => 'Share content',
                          'format'     => '2100',
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