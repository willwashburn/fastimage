<?php namespace FastImage\Transports;


/**
 * Interface TransportInterface
 *
 * Opens up a stream to a file and gets the bits
 *
 * @package FastImage\Transports
 */
interface TransportInterface {

    /**
     * Opens the connection to the file
     *
     * @param $url
     */
    public function open($url);

    /**
     * Closes the connection to the file
     *
     * @return mixed
     */
    public function close();

    /**
     * Reads more characters of the file
     * @param $characters
     *
     * @return mixed
     */
    public function read($characters);

    /**
     * Resets the pointer where we are reading in the file
     *
     * @return mixed
     */
    public function resetReadPointer();

}