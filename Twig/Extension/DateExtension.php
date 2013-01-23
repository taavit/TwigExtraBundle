<?php
namespace Taavit\TwigExtraBundle\Twig\Extension;

use Symfony\Component\Translation\Translator;

use Twig_Extension;
use Twig_Filter_Method;

/**
 * @author Dawid Królak [taavit@gmail.com]
 * 
 */
class DateExtension extends Twig_Extension{
    
    protected $translator;
    
    public function __construct(Translator $translator){
        $this->_translator = $translator;
    }
    
    public function getFilters(){
        return array(
            'prettify' => new Twig_Filter_Method($this, 'prettify'),
        );
    }
    
    public function prettify(\DateTime $date){
        $date = $date->getTimestamp();
        $diff = time()-$date;
        if ($diff > 0) {
            if ($diff<60) return $this->_translator->trans('Just now');
            if ($diff<3600){
                $minutes = floor($diff/60);
                return $this->_translator->transChoice('One minute ago|%minutes% minutes ago',$minutes,array('%minutes%'=>$minutes),'taavit');
            }
            if ($diff<86400) {
                $hours = floor($diff/3600);
                return $this->_translator->transChoice('One hour ago|%hours% hours ago',$hours,array('%hours%'=>$hours),'taavit');
            }
            if ($diff<2592000) {
                $days = floor($diff/86400);
                return $this->_translator->transChoice('One day ago|%days% days ago',$days,array('%days%'=>$days),'taavit');
            }
            if ($diff<31536000) {
                $months = floor($diff/2592000);
                return $this->_translator->transChoice('One month ago|%months% months ago',$months,array('%months%'=>$months),'taavit');
            }
            $years = floor($diff/31536000);
            return $this->_translator->transChoice('One year ago|%years% years ago',$years,array('%years%'=>$years),'taavit');
        
        } else {
            $diff = abs($diff);
            if ($diff > 31536000) {
                $years = floor($diff/31536000);
                return $this->_translator->transChoice('In one year|In %years% years',$years,array('%years%'=>$years),'taavit');
            } elseif ($diff > 2592000) {
                $months = floor($diff/2592000);
                return $this->_translator->transChoice('In one month ago|In %months% months',$months,array('%months%'=>$months),'taavit');
            } elseif ($diff > 86400) {
                $days = floor($diff/86400);
                return $this->_translator->transChoice('In one day|In %days% days',$days,array('%days%'=>$days),'taavit');
            } elseif ($diff > 3600) {
                $hours = floor($diff/3600);
                return $this->_translator->transChoice('In one hour|In %hours% hours',$hours,array('%hours%'=>$hours),'taavit');
            } elseif ($diff > 60) {
                $minutes = floor($diff/60);
                return $this->_translator->transChoice('In one minute|In %minutes% minutes',$minutes,array('%minutes%'=>$minutes),'taavit');
            } else {
                return $this->_translator->trans('Just now');
            }
        }
    }
    
    public function getName(){
        return 'date_extension';
    }
    
}
