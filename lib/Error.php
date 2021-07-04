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

  /**
   * The code of not directory
   */
  const NOT_DIRECTORY = 0x03;

  /**
   * The code of an invalid pattern
   */
  const INVALID_PATTERN = 0x04;

  /**
   * The code of an invalid extension
   */
  const INVALID_EXTENSION = 0x05;

  /**
   * The code of an invalid namespace
   */
  const INVALID_NAMESPACE = 0x06;

  /**
   * The code of an invalid var name
   */
  const INVALID_VARNAME = 0x07;
}
