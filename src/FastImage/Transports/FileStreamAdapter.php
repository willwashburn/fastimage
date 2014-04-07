<?php namespace FastImage\Transports;

/**
 * Class FileStreamAdapter
 *
 * Untested port, but should work like the original
 *
 * @package FastImage\Transports
 */
class FileStreamAdapter implements TransportInterface {

    /**
     * @var resource
     */
    protected $handle;

    /**
     * @var int
     */
    protected $strpos = 0;

    /**
     * The string from the file
     *
     * @var string
     */
    protected $str = '';

    /**
     * Original open from Tom Moor's class
     * @param $uri
     *
     * @return $this
     */
    public function open($uri) {

        $this->close();

        $this->handle =  fopen($uri,'r');

        return $this;
    }

    /**
     * Closes the handle/connection
     *
     * @return $this
     */
    public function close() {

        if ($this->handle) {
          fclose($this->handle);
        }

        return $this;
    }

    /**
     * Reads characters from the file
     *
     * @param $characters
     *
     * @throws \InvalidArgumentException
     *
     * @return bool | string
     */
    public function read($characters) {

        if (!is_numeric($characters)) {
            throw new \InvalidArgumentException('"Read" expects a number');
        }

        $n = $characters;

        $response = null;

        // do we need more data?
        if ($this->strpos + $n -1 >= strlen($this->str))
        {
            $end = ($this->strpos + $n);

            while (strlen($this->str) < $end && $response !== false)
            {
                // read more from the file handle
                $need = $end - ftell($this->handle);

                $response = fread($this->handle, $need);

                if (!$response)
                {
                    return false;
                }

                $this->str .= $response;
            }
        }

        $result = substr($this->str, $this->strpos, $n);
        $this->strpos += $n;

        return $result;

        // we are dealing with bytes here, so force the encoding
        //return mb_convert_encoding($result, "8BIT");
    }

    /**
     * Returns the pointer to the start
     *
     * @return mixed|void
     */
    public function resetReadPointer() {
        $this->strpos = 0;
    }
}