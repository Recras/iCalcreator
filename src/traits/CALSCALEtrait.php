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
 * CALSCALE property functions
 *
 * @author Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @since 2.22.23 - 2017-02-02
 */
trait CALSCALEtrait {
/**
 * @var string calendar property CALSCALE
 * @access protected
 */
  protected $calscale = null;
/**
 * Return formatted output for calendar property calscale
 *
 * @uses vcalendar::$calscale
 * @return string
 */
  public function createCalscale() {
    return ( empty( $this->calscale ))
           ? null
           : sprintf( self::$FMTICAL, util::$CALSCALE,
                                      $this->calscale );
  }
/**
 * Set calendar property calscale
 *
 * @param string $value
 * @uses vcalendar::$calscale
 */
  public function setCalscale( $value ) {
    if( empty( $value ))
      return false;
    $this->calscale = $value;
  }
}