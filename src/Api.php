<?php

namespace Language;

use Language\ApiCall;

class Api 
{
    private $response;

    public function execute($target, $mode, $getParameters, $postParameters)
    {
        $this->response = ApiCall::call(
            $target,
            $mode, 
            $getParameters,
            $postParameters
        );
		
        $this->check4Error();
    }

    private function check4Error()
    {
        // Error during the api call.
		if ($this->response === false || !isset($this->response['status'])) {
			throw new \Exception('Error during the api call');
		}
		// Wrong response.
		if ($this->response['status'] != 'OK') {
			throw new \Exception('Wrong response: '
				. (!empty($this->response['error_type']) ? 'Type(' . $this->response['error_type'] . ') ' : '')
				. (!empty($this->response['error_code']) ? 'Code(' . $this->response['error_code'] . ') ' : '')
				. ((string)$this->response['data']));
		}
		// Wrong content.
		if ($this->response['data'] === false) {
			throw new \Exception('Wrong content!');
		}
    }

    public function getResponse()
    {
        return $this->response;
    }
}