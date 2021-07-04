<?php namespace SIKessEm\Organizer;

/**
 * The error class
 *
 * @author SIGUI Kessé Emmanuel
 * @package sikessem/organizer
 * @license Apache-2.0
 */
class Error extends \Error {

  /**
   * The getter error code
   */
  const GET_PROPERTY = 0x01;

  /**
   * The setter error code
   */
  const SET_PROPERTY = 0x02;
}
