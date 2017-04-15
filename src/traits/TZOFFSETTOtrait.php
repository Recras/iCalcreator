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
 * TZOFFSETTO property functions
 *
 * @author Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @since 2.22.23 - 2017-02-02
 */
trait TZOFFSETTOtrait {
/**
 * @var array component property TZOFFSETTO value
 * @access protected
 */
  protected $tzoffsetto = null;
/**
 * Return formatted output for calendar component property tzoffsetto
 *
 * @return string
 * @uses calendarComponent::getConfig()
 * @uses util::createElement()
 * @uses util::createParams()
 */
  public function createTzoffsetto() {
    if( empty( $this->tzoffsetto ))
      return null;
    if( empty( $this->tzoffsetto[util::$LCvalue] ))
      return ( $this->getConfig( util::$ALLOWEMPTY )) ? util::createElement( util::$TZOFFSETTO ) : null;
    return util::createElement( util::$TZOFFSETTO,
                                util::createParams( $this->tzoffsetto[util::$LCparams] ),
                                $this->tzoffsetto[util::$LCvalue] );
  }
/**
 * Set calendar component property tzoffsetto
 *
 * @param string  $value
 * @param array   $params
 * @return bool
 * @uses calendarComponent::getConfig()
 * @uses util::setParams()
 */
  public function setTzoffsetto( $value, $params=null ) {
    if( empty( $value )) {
      if( $this->getConfig( util::$ALLOWEMPTY ))
        $value = util::$EMPTYPROPERTY;
      else
        return false;
    }
    $this->tzoffsetto = array( util::$LCvalue  => $value,
                               util::$LCparams => util::setParams( $params ));
    return true;
  }
}