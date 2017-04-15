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
 * COMMENT property functions
 *
 * @author Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @since 2.22.23 - 2017-02-02
 */
trait COMMENTtrait {
/**
 * @var array component property COMMENT value
 * @access protected
 */
  protected $comment = null;
/**
 * Return formatted output for calendar component property comment
 *
 * @return string
 * @uses calendarComponent::getConfig()
 * @uses util::createElement()
 * @uses util::createParams()
 * @uses util::strrep()
 */
  public function createComment() {
    if( empty( $this->comment ))
      return null;
    $output = null;
    $lang   = $this->getConfig( util::$LANGUAGE );
    foreach( $this->comment as $cx => $commentPart ) {
      if( empty( $commentPart[util::$LCvalue] )) {
        if( $this->getConfig( util::$ALLOWEMPTY ))
          $output .= util::createElement( util::$COMMENT );
        continue;
      }
      $output     .= util::createElement( util::$COMMENT,
                                          util::createParams( $commentPart[util::$LCparams],
                                                              util::$ALTRPLANGARR,
                                                              $lang ),
                                          util::strrep( $commentPart[util::$LCvalue] ));
    }
    return $output;
  }
/**
 * Set calendar component property comment
 *
 * @param string  $value
 * @param array   $params
 * @param integer $index
 * @return bool
 * @uses calendarComponent::getConfig()
 * @uses util::setMval()
 */
  public function setComment( $value, $params=null, $index=null ) {
    if( empty( $value )) {
      if( $this->getConfig( util::$ALLOWEMPTY ))
        $value = util::$EMPTYPROPERTY;
      else
        return false;
    }
    util::setMval( $this->comment,
                    $value,
                    $params,
                    false,
                    $index );
    return true;
  }
}