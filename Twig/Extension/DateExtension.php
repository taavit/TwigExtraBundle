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
    public function __construct(Translator $translator, $time = null)
    {
        $this->translator = $translator;
        $this->setTime($time);
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
        return '<abbr class="timestamp" data-utime="' . $timestamp . '" title="' . date("Y-m-d H:i:s", $timestamp) . '">' . $string . '</abbr>';
    }

    /**
     * @param \DateTime $date
     *
     * @return string
     */
    public function prettify(\DateTime $date)
    {
        $date = $date->getTimestamp();
        $diff = $this->time - $date;
        if ($diff > 0) {
            return $this->abbr($this->handlePast($diff), $date);
        }
        return $this->abbr($this->handleFuture($diff), $date);
    }

    public function getName()
    {
        return 'date_extension';
    }

    public function setTime($time = null)
    {
        if (null === $time) {
            $time = time();
        }
        $this->time = $time;
    }

    protected function handlePast($diff)
    {
        if ($diff < 60) {
            return $this->translator->trans('Just now');
        }
        if ($diff < 3600) {
            $minutes = floor($diff / 60);

            return $this
                ->translator
                ->transChoice(
                    'One minute ago|%minutes% minutes ago',
                    $minutes,
                    array('%minutes%' => $minutes),
                    'taavit'
                );
        }
        if ($diff < 86400) {
            $hours = floor($diff / 3600);

            return $this
                ->translator
                ->transChoice(
                    'One hour ago|%hours% hours ago',
                    $hours,
                    array('%hours%' => $hours),
                    'taavit'
                );
        }
        if ($diff < 2592000) {
            $days = floor($diff / 86400);
            return $this
                ->translator
                ->transChoice(
                    'One day ago|%days% days ago',
                    $days,
                    array('%days%' => $days),
                    'taavit'
                );
        }
        if ($diff < 31536000) {
            $months = floor($diff / 2592000);

            return $this
                ->translator
                ->transChoice(
                    'One month ago|%months% months ago',
                    $months,
                    array('%months%' => $months),
                    'taavit'
                );
        }
        $years = floor($diff / 31536000);

        return $this
            ->translator
            ->transChoice(
                'One year ago|%years% years ago',
                $years,
                array('%years%' => $years),
                'taavit'
            );
    }

    protected function handleFuture($diff)
    {
        $diff = abs($diff);
        if ($diff > 31536000) {
            $years = floor($diff / 31536000);

            return $this
                ->translator
                ->transChoice(
                    'In one year|In %years% years',
                    $years,
                    array('%years%' => $years),
                    'taavit'
                );
        }
        if ($diff > 2592000) {
            $months = floor($diff / 2592000);

            return $this
                ->translator
                ->transChoice(
                    'In one month ago|In %months% months',
                    $months,
                    array('%months%' => $months),
                    'taavit'
                );
        }
        if ($diff > 86400) {
            $days = floor($diff / 86400);

            return $this
                ->translator
                ->transChoice(
                    'In one day|In %days% days',
                    $days,
                    array('%days%' => $days),
                    'taavit'
                );
        }
        if ($diff > 3600) {
            $hours = floor($diff / 3600);

            return $this
                ->translator
                ->transChoice(
                    'In one hour|In %hours% hours',
                    $hours,
                    array('%hours%' => $hours),
                    'taavit'
                );
        }
        if ($diff > 60) {
            $minutes = floor($diff / 60);

            return $this
                ->translator
                ->transChoice(
                    'In one minute|In %minutes% minutes',
                    $minutes,
                    array('%minutes%' => $minutes),
                    'taavit'
                );
        }
        return $this->translator->trans('Just now');
    }
}
