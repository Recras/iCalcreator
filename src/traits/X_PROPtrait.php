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
 * X-property functions
 *
 * @author Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @since 2.22.23 - 2017-02-02
 */
trait X_PROPtrait {
/**
 *  @var array component property X-property value
 *  @access protected
 */
  protected $xprop = null;
/**
 * Return formatted output for calendar/component property x-prop
 *
 * @uses iCalBase::$xprop
 * @uses calendarComponent::getConfig()
 * @uses util::createElement()
 * @uses util::createParams()
 * @uses util::strrep()
 * @uses util::trimTrailNL()
 * @return string
 */
  public function createXprop() {
    if( empty( $this->xprop ) || !is_array( $this->xprop ))
      return null;
    $output        = null;
    $lang          = $this->getConfig( util::$LANGUAGE );
    foreach( $this->xprop as $label => $xpropPart ) {
      if( ! isset( $xpropPart[util::$LCvalue]) ||
          ( empty( $xpropPart[util::$LCvalue] ) && ! is_numeric( $xpropPart[util::$LCvalue] ))) {
        if( $this->getConfig( util::$ALLOWEMPTY ))
          $output .= util::createElement( $label );
        continue;
      }
      if( is_array( $xpropPart[util::$LCvalue] )) {
        foreach( $xpropPart[util::$LCvalue] as $pix => $theXpart )
          $xpropPart[util::$LCvalue][$pix] = util::strrep( $theXpart );
        $xpropPart[util::$LCvalue]  = implode( util::$COMMA, $xpropPart[util::$LCvalue] );
      }
      else
        $xpropPart[util::$LCvalue] = util::strrep( $xpropPart[util::$LCvalue] );
      $output     .= util::createElement( $label,
                                          util::createParams( $xpropPart[util::$LCparams],
                                                              array( util::$LANGUAGE ),
                                                              $lang ),
                                          util::trimTrailNL( $xpropPart[util::$LCvalue] ));
    }
    return $output;
  }
/**
 * Set calendar property x-prop
 *
 * @param string $label
 * @param string $value
 * @param array $params optional
 * @return bool
 * @uses util::isXprefixed()
 * @uses calendarComponent::getConfig()
 * @uses util::setParams()
 * @uses iCalBase::$xprop
 */
  public function setXprop( $label, $value, $params=false ) {
    if( empty( $label ) || ! util::isXprefixed( $label ))
      return false;
    if( empty( $value ) && ! is_numeric( $value )) {
      if( $this->getConfig( util::$ALLOWEMPTY ))
        $value     = util::$EMPTYPROPERTY;
      else
        return false;
    }
    $xprop         = array( util::$LCvalue => $value );
    $xprop[util::$LCparams] = util::setParams( $params );
    if( ! is_array( $this->xprop ))
      $this->xprop = array();
    $this->xprop[strtoupper( $label )] = $xprop;
    return true;
  }
/**
 * Delete component property X-prop value
 *
 * @param string $propName
 * @param array  $xProp     component X-property
 * @param int    $propix    removal counter
 * $param array  $propdelix
 * @access protected
 * @static
 */
  protected static function deleteXproperty( $propName=null, & $xProp, & $propix, & $propdelix ) {
    $reduced = array();
    if( $propName != util::$X_PROP ) {
      if( ! isset( $xProp[$propName] )) {
        unset( $propdelix[$propName] );
        return false;
      }
      foreach( $xProp as $k => $xValue ) {
        if(( $k != $propName ) && ! empty( $xValue ))
          $reduced[$k] = $xValue;
      }
    }
    else {
      if( count( $xProp ) <= $propix ) {
        unset( $propdelix[$propName] );
        return false;
      }
      $xpropno = 0;
      foreach( $xProp as $xPropKey => $xPropValue ) {
        if( $propix != $xpropno )
          $reduced[$xPropKey] = $xPropValue;
        $xpropno++;
      }
    }
    $xProp = $reduced;
    if( empty( $xProp )) {
      $xProp = null;
      unset( $propdelix[$propName] );
      return false;
    }
    return true;
  }
}