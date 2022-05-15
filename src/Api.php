<?php

namespace Language;

use Language\ApiCall;

class Api 
{
    private $result;

    public function execute($target, $mode, $getParameters, $postParameters)
    {
        $this->result = ApiCall::call(
            $target,
            $mode, 
            $getParameters,
            $postParameters
        );
		
        $this->check4ErrorResult();
    }

    public function check4ErrorResult()
    {
        // Error during the api call.
		if ($this->result === false || !isset($this->result['status'])) {
			throw new \Exception('Error during the api call');
		}
		// Wrong response.
		if ($this->result['status'] != 'OK') {
			throw new \Exception('Wrong response: '
				. (!empty($this->result['error_type']) ? 'Type(' . $this->result['error_type'] . ') ' : '')
				. (!empty($this->result['error_code']) ? 'Code(' . $this->result['error_code'] . ') ' : '')
				. ((string)$this->result['data']));
		}
		// Wrong content.
		if ($this->result['data'] === false) {
			throw new \Exception('Wrong content!');
		}
    }
}