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
 * LOCATION property functions
 *
 * @author Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @since 2.22.23 - 2017-02-17
 */
trait LOCATIONtrait {
/**
 * @var array component property LOCATION value
 * @access protected
 */
  protected $location = null;
/**
 * Return formatted output for calendar component property location
 *
 * @return string
 * @uses calendarComponent::getConfig()
 * @uses util::createElement()
 * @uses util::createParams()
 * @uses util::strrep()
 */
  public function createLocation() {
    if( empty( $this->location ))
      return null;
    if( empty( $this->location[util::$LCvalue] ))
      return ( $this->getConfig( util::$ALLOWEMPTY )) ? util::createElement( util::$LOCATION ) : null;
    return util::createElement( util::$LOCATION,
                                 util::createParams( $this->location[util::$LCparams],
                                                     util::$ALTRPLANGARR,
                                                     $this->getConfig( util::$LANGUAGE )),
                                 util::strrep( $this->location[util::$LCvalue] ));
  }
/**
 * Set calendar component property location
 *
 * @param string  $value
 * @param array   $params
 * @return bool
 * @uses calendarComponent::getConfig()
 * @uses util::trimTrailNL()
 * @uses util::setParams()
 */
  public function setLocation( $value, $params=null ) {
    if( empty( $value )) {
      if( $this->getConfig( util::$ALLOWEMPTY ))
        $value = util::$EMPTYPROPERTY;
      else
        return false;
    }
    $this->location = array( util::$LCvalue  => util::trimTrailNL( $value ),
                             util::$LCparams => util::setParams( $params ));
    return true;
  }
}