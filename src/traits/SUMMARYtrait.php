<?php
/**
 * iCalcreator, a PHP rfc2445/rfc5545 solution.
 *
 * @copyright 2007-2017 Kjell-Inge Gustafsson, kigkonsult, All rights reserved
 * @link      http://kigkonsult.se/iCalcreator/index.php
 * @package   iCalcreator
 * @version   2.23.7
 * @license   Part 1. This software is for
 *                    individual evaluation use and evaluation result use only;
 *                    non assignable, non-transferable, non-distributable,
 *                    non-commercial and non-public rights, use and result use.
 *            Part 2. Creative Commons
 *                    Attribution-NonCommercial-NoDerivatives 4.0 International License
 *                    (http://creativecommons.org/licenses/by-nc-nd/4.0/)
 *            In case of conflict, Part 1 supercede Part 2.
 *
 * This file is a part of iCalcreator.
 */
namespace kigkonsult\iCalcreator\traits;
use kigkonsult\iCalcreator\util\util;
/**
 * SUMMARY property functions
 *
 * @author Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @since 2.22.23 - 2017-02-02
 */
trait SUMMARYtrait {
/**
 * @var array component property SUMMARY value
 * @access protected
 */
  protected $summary = null;
/**
 * Return formatted output for calendar component property summary
 *
 * @return string
 * @uses calendarComponent::getConfig()
 * @uses util::createElement()
 * @uses util::createParams()
 * @uses util::strrep()
 */
  public function createSummary() {
    if( empty( $this->summary ))
      return null;
    if( empty( $this->summary[util::$LCvalue] ))
      return ( $this->getConfig( util::$ALLOWEMPTY )) ? util::createElement( util::$SUMMARY ) : null;
    return util::createElement( util::$SUMMARY,
                                util::createParams( $this->summary[util::$LCparams],
                                                    util::$ALTRPLANGARR,
                                                    $this->getConfig( util::$LANGUAGE )),
                                util::strrep( $this->summary[util::$LCvalue] ));
  }
/**
 * Set calendar component property summary
 *
 * @param string  $value
 * @param string  $params
 * @return bool
 * @uses calendarComponent::getConfig()
 * @uses util::setParams()
 */
  public function setSummary( $value, $params=null ) {
    if( empty( $value )) {
      if( $this->getConfig( util::$ALLOWEMPTY ))
        $value = util::$EMPTYPROPERTY;
      else
       return false;
    }
    $this->summary = array( util::$LCvalue  => $value,
                            util::$LCparams => util::setParams( $params ));
    return true;
  }
}