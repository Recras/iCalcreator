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
namespace kigkonsult\iCalcreator;
use kigkonsult\iCalcreator\util\util;
/**
 * iCalcreator vcalendarSortHandler class
 *
 * @author Kjell-Inge Gustafsson, kigkonsult <ical@kigkonsult.se>
 * @since 2.23.5 - 2017-04-13
 */
class vcalendarSortHandler {
/**
 * vcalendar sort callback function
 *
 * @param array $a
 * @param array $b
 * @return int
 * @static
 */
  public static function cmpfcn( $a, $b ) {
    static $SORTKEYS = array( 'year', 'month', 'day', 'hour', 'min', 'dec' );
    if(        empty( $a ))                        return -1;
    if(        empty( $b ))                        return  1;
    if( util::$LCVTIMEZONE == $a->objName ) {
      if( util::$LCVTIMEZONE != $b->objName )      return -1;
      elseif( $a->srtk[0] <= $b->srtk[0] )         return -1;
      else                                         return  1;
    }
    elseif( util::$LCVTIMEZONE == $b->objName )    return  1;
    for( $k = 0; $k < 4 ; $k++ ) {
      if(        empty( $a->srtk[$k] ))            return -1;
      elseif(    empty( $b->srtk[$k] ))            return  1;
      if( is_array( $a->srtk[$k] )) {
        if( is_array( $b->srtk[$k] )) {
          foreach( $SORTKEYS as $key ) {
            if    ( ! isset( $a->srtk[$k][$key] )) return -1;
            elseif( ! isset( $b->srtk[$k][$key] )) return  1;
            if    (  empty( $a->srtk[$k][$key] ))  return -1;
            elseif(  empty( $b->srtk[$k][$key] ))  return  1;
            if    (         $a->srtk[$k][$key] == $b->srtk[$k][$key])
                                                   continue;
            if    ((  (int) $a->srtk[$k][$key] ) < ((int) $b->srtk[$k][$key] ))
                                                   return -1;
            elseif((  (int) $a->srtk[$k][$key] ) > ((int) $b->srtk[$k][$key] ))
                                                   return  1;
          }
        }
        else                                       return -1;
      }
      elseif( is_array( $b->srtk[$k] ))            return  1;
      elseif( $a->srtk[$k] < $b->srtk[$k] )        return -1;
      elseif( $a->srtk[$k] > $b->srtk[$k] )        return  1;
    }
    return 0;
  }
/**
 * Set sort arguments/parameters in component
 *
 * @param object $c       valendar component
 * @param string $sortArg
 * @uses calendarComponent::$getProperty()
 * @uses calendarComponent::getProperties()
 * @uses util::date2strdate()
 * @uses util::strDate2ArrayDate()
 * @static
 */
  public static function setSortArgs( $c, $sortArg=null ) {
    static $INITARR = array( '0', '0', '0', '0' );
    $c->srtk = $INITARR;
    if( util::$LCVTIMEZONE == $c->objName ) {
      if( false === ( $c->srtk[0] = $c->getProperty( util::$TZID )))
        $c->srtk[0] = 0;
      return;
    }
    elseif( ! is_null( $sortArg )) {
      if( in_array( $sortArg, util::$MPROPS1 )) {
        $propValues = array();
        $c->getProperties( $sortArg, $propValues );
        if( ! empty( $propValues )) {
          $sk         = array_keys( $propValues );
          $c->srtk[0] = $sk[0];
          if( util::$RELATED_TO  == $sortArg )
            $c->srtk[0] .= $c->getProperty( util::$UID );
        }
        elseif( util::$RELATED_TO  == $sortArg )
          $c->srtk[0] = $c->getProperty( util::$UID );
      }
      elseif( false !== ( $d = $c->getProperty( $sortArg ))) {
        $c->srtk[0] = $d;
        if( util::$UID == $sortArg ) {
          if( false !== ( $d = $c->getProperty( util::$RECURRENCE_ID ))) {
            $c->srtk[1] = util::date2strdate( $d );
            if( false === ( $c->srtk[2] = $c->getProperty( util::$SEQUENCE )))
              $c->srtk[2] = PHP_INT_MAX;
          }
          else
            $c->srtk[1] = $c->srtk[2] = PHP_INT_MAX;
        }
      }
      return;
    } // end elseif( $sortArg )
    if( false !== ( $d = $c->getProperty( util::$X_CURRENT_DTSTART ))) {
      $c->srtk[0] = util::strDate2ArrayDate( $d[1] );
      unset( $c->srtk[0][util::$UNPARSEDTEXT] );
    }
    elseif( false === ( $c->srtk[0] = $c->getProperty( util::$DTSTART )))
      $c->srtk[0] = 0;                                                 // sortkey 0 : dtstart
    if( false !== ( $d = $c->getProperty( util::$X_CURRENT_DTEND ))) {
      $c->srtk[1] = util::strDate2ArrayDate( $d[1] );                 // sortkey 1 : dtend/due(/duration)
      unset( $c->srtk[1][util::$UNPARSEDTEXT] );
    }
    elseif( false === ( $c->srtk[1] = $c->getProperty( util::$DTEND ))) {
      if( false !== ( $d = $c->getProperty( util::$X_CURRENT_DUE ))) {
        $c->srtk[1] = util::strDate2ArrayDate( $d[1] );
        unset( $c->srtk[1][util::$UNPARSEDTEXT] );
      }
      elseif( false === ( $c->srtk[1] = $c->getProperty( util::$DUE )))
        if( false === ( $c->srtk[1] = $c->getProperty( util::$DURATION, false, false, true )))
          $c->srtk[1] = 0;
    }
    if( false === ( $c->srtk[2] = $c->getProperty( util::$CREATED )))  // sortkey 2 : created/dtstamp
      if( false === ( $c->srtk[2] = $c->getProperty( util::$DTSTAMP )))
        $c->srtk[2] = 0;
    if( false === ( $c->srtk[3] = $c->getProperty( util::$UID )))      // sortkey 3 : uid
      $c->srtk[3] = 0;
  }
/**
 * Sort callback function for exdate
 *
 * @param array $a
 * @param array $b
 * @return int
 * @static
 */
  public static function sortExdate1( $a, $b ) {
    $as  = sprintf( util::$YMD, (int) $a[util::$LCYEAR],
                                (int) $a[util::$LCMONTH],
                                (int) $a[util::$LCDAY] );
    $as .= ( isset( $a[util::$LCHOUR] )) ? sprintf( util::$HIS, (int) $a[util::$LCHOUR],
                                                                (int) $a[util::$LCMIN],
                                                                (int) $a[util::$LCSEC] )
                                         : null;
    $bs  = sprintf( util::$YMD, (int) $b[util::$LCYEAR],
                                (int) $b[util::$LCMONTH],
                                (int) $b[util::$LCDAY] );
    $bs .= ( isset( $b[util::$LCHOUR] )) ? sprintf( util::$HIS, (int) $b[util::$LCHOUR],
                                                                (int) $b[util::$LCMIN],
                                                                (int) $b[util::$LCSEC] )
                                         : null;
    return strcmp( $as, $bs );
  }
/**
 * Sort callback function for exdate
 *
 * @param array $a
 * @param array $b
 * @return int
 * @static
 */
  public static function sortExdate2( $a, $b ) {
    $val = reset( $a[util::$LCvalue] );
    $as  = sprintf( util::$YMD, (int) $val[util::$LCYEAR],
                                (int) $val[util::$LCMONTH],
                                (int) $val[util::$LCDAY] );
    $as .= ( isset( $val[util::$LCHOUR] )) ? sprintf( util::$HIS, (int) $val[util::$LCHOUR],
                                                                  (int) $val[util::$LCMIN],
                                                                  (int) $val[util::$LCSEC] )
                                           : null;
    $val = reset( $b[util::$LCvalue] );
    $bs  = sprintf( util::$YMD, (int) $val[util::$LCYEAR],
                                      (int) $val[util::$LCMONTH],
                                      (int) $val[util::$LCDAY] );
    $bs .= ( isset( $val[util::$LCHOUR] )) ? sprintf( util::$HIS, (int) $val[util::$LCHOUR],
                                                                  (int) $val[util::$LCMIN],
                                                                  (int) $val[util::$LCSEC] )
                                           : null;
    return strcmp( $as, $bs );
  }
/**
 * Sort callback function for freebusy and rdate, sort single property (inside values)
 *
 * @param array $a
 * @param array $b
 * @return int
 * @uses vcalendarSortHandler::formatdatePart()
 * @static
 */
  public static function sortRdate1( $a, $b ) {
    $as    = null;
    if( isset( $a[util::$LCYEAR] ))
      $as  = self::formatdatePart( $a );
    elseif( isset( $a[0][util::$LCYEAR] )) {
      $as  = self::formatdatePart( $a[0] );
      $as .= self::formatdatePart( $a[1] );
    }
    else
      return 1;
    $bs    = null;
    if( isset( $b[util::$LCYEAR] ))
      $bs  = self::formatdatePart( $b );
    elseif( isset( $b[0][util::$LCYEAR] )) {
      $bs  = self::formatdatePart( $b[0] );
      $bs .= self::formatdatePart( $b[1] );
    }
    else
      return -1;
    return strcmp( $as, $bs );
  }
/**
 * Sort callback function for rdate, sort multiple RDATEs in order (after 1st datetime/date/period)
 *
 * @param array $a
 * @param array $b
 * @return int
 * @uses vcalendarSortHandler::formatdatePart()
 * @static
 */
  public static function sortRdate2( $a, $b ) {
    $as    = null;
    if( isset( $a[util::$LCvalue][0][util::$LCYEAR] ))
      $as  = self::formatdatePart( $a[util::$LCvalue][0] );
    elseif( isset( $a[util::$LCvalue][0][0][util::$LCYEAR] )) {
      $as  = self::formatdatePart( $a[util::$LCvalue][0][0] );
      $as .= self::formatdatePart( $a[util::$LCvalue][0][1] );
    }
    else
      return 1;
    $bs    = null;
    if( isset( $b[util::$LCvalue][0][util::$LCYEAR] ))
      $bs  = self::formatdatePart( $b[util::$LCvalue][0] );
    elseif( isset( $a[util::$LCvalue][0][0][util::$LCYEAR] )) {
      $bs  = self::formatdatePart( $b[util::$LCvalue][0][0] );
      $bs .= self::formatdatePart( $b[util::$LCvalue][0][1] );
    }
    else
      return -1;
    return strcmp( $as, $bs );
  }
  private static function formatdatePart( $part ) {
    if( isset( $part[util::$LCYEAR] )) {
      $str  = sprintf( util::$YMD, (int) $part[util::$LCYEAR],
                                   (int) $part[util::$LCMONTH],
                                   (int) $part[util::$LCDAY] );
      $str .= ( isset( $part[util::$LCHOUR] )) ? sprintf( util::$HIS, (int) $part[util::$LCHOUR],
                                                                      (int) $part[util::$LCMIN],
                                                                      (int) $part[util::$LCSEC] )
                                               : null;
    }
    else
      $str  = util::duration2str( $part );
    return $str;
  }
}