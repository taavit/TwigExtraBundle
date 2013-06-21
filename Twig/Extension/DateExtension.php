<?php
namespace Taavit\TwigExtraBundle\Twig\Extension;

use Symfony\Component\Translation\Translator;

use Twig_Extension;
use Twig_Filter_Method;

/**
 * @author Dawid Królak <taavit@gmail.com>
 *
 */
class DateExtension extends Twig_Extension
{
    /**
     * @var
     */
    protected $translator;

    /**
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->_translator = $translator;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'prettify' => new Twig_Filter_Method($this, 'prettify', array('is_safe' => array('html'))),
        );
    }

    /**
     * Append HTML data to the timestamp
     *
     * @param string  $string
     * @param integer $timestamp
     *
     * @author Robert Lord <robert@codepeak.se>
     *
     * @return string
     */
    public function abbr($string, $timestamp)
    {
        return '<abbr class="timestamp" data-utime="' . $timestamp . '">' . $string . '</abbr>';
    }

    /**
     * @param \DateTime $date
     *
     * @return string
     */
    public function prettify(\DateTime $date)
    {
        $date = $date->getTimestamp();
        $diff = time() - $date;
        if ($diff > 0) {
            if ($diff < 60) {
                return $this->abbr($this->_translator->trans('Just now'), $date);
            }
            if ($diff < 3600) {
                $minutes = floor($diff / 60);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'One minute ago|%minutes% minutes ago',
                        $minutes,
                        array('%minutes%' => $minutes),
                        'taavit'
                    ), $date);
            }
            if ($diff < 86400) {
                $hours = floor($diff / 3600);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'One hour ago|%hours% hours ago',
                        $hours,
                        array('%hours%' => $hours),
                        'taavit'
                    ), $date);
            }
            if ($diff < 2592000) {
                $days = floor($diff / 86400);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'One day ago|%days% days ago',
                        $days,
                        array('%days%' => $days),
                        'taavit'
                    ), $date);
            }
            if ($diff < 31536000) {
                $months = floor($diff / 2592000);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'One month ago|%months% months ago',
                        $months,
                        array('%months%' => $months),
                        'taavit'
                    ), $date);
            }
            $years = floor($diff / 31536000);

            return $this->abbr($this
                ->_translator
                ->transChoice(
                    'One year ago|%years% years ago',
                    $years,
                    array('%years%' => $years),
                    'taavit'
                ), $date);
        } else {
            $diff = abs($diff);
            if ($diff > 31536000) {
                $years = floor($diff / 31536000);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'In one year|In %years% years',
                        $years,
                        array('%years%' => $years),
                        'taavit'
                    ), $date);
            } elseif ($diff > 2592000) {
                $months = floor($diff / 2592000);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'In one month ago|In %months% months',
                        $months,
                        array('%months%' => $months),
                        'taavit'
                    ), $date);
            } elseif ($diff > 86400) {
                $days = floor($diff / 86400);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'In one day|In %days% days',
                        $days,
                        array('%days%' => $days),
                        'taavit'
                    ), $date);
            } elseif ($diff > 3600) {
                $hours = floor($diff / 3600);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'In one hour|In %hours% hours',
                        $hours,
                        array('%hours%' => $hours),
                        'taavit'
                    ), $date);
            } elseif ($diff > 60) {
                $minutes = floor($diff / 60);

                return $this->abbr($this
                    ->_translator
                    ->transChoice(
                        'In one minute|In %minutes% minutes',
                        $minutes,
                        array('%minutes%' => $minutes),
                        'taavit'
                    ), $date);
            } else {
                return $this->abbr($this->_translator->trans('Just now'), time());
            }
        }
    }

    public function getName()
    {
        return 'date_extension';
    }
}
