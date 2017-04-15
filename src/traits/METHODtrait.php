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
 * METHOD property functions
 *
 * @author Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @since 2.22.23 - 2017-02-02
 */
trait METHODtrait {
/**
 * @var string calendar property METHOD
 * @access protected
 */
  protected $method = null;
/**
 * Return formatted output for calendar property method
 *
 * @return string
 */
  public function createMethod() {
    return ( empty( $this->method ))
           ? null
           : sprintf( self::$FMTICAL, util::$METHOD,
                                      $this->method );
  }
/**
 * Set calendar property method
 *
 * @param string $value
 * @return bool
 */
  public function setMethod( $value ) {
    if( empty( $value ))
      return false;
    $this->method = $value;
    return true;
  }
}