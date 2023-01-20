<?php

class Response {
    private $_success;
    private $_httpStatusCode;
    private $_messages = array();
    private $_toCache = false;
    private $_data;
    private $_responseData = array();

    public function setSuccess($success) {
        $this->_success = $success;
    }

    public function setHttpStatusCode($httpStatusCode) {
        $this->_httpStatusCode = $httpStatusCode;
    }

    public function addMessage($message) {
        $this->_messages[] = $message;
    }

    public function setToCache($toCache) {
        $this->_toCache = $toCache;
    }
    
    public function setData($data) {
        $this->_data = $data;
    }

    public function send() {
        header('content-type: application/json;charset=utf-8');

        if (!$this->_toCache) {
            header('cache-control: no-store');
        }
        elseif ($this->_toCache) {
            header('cache-control: max-age=60');
        }

        if (!is_numeric($this->_httpStatusCode) || ($this->_success !== false && $this->_success !== true)) {
            http_response_code(500);
            $this->_responseData['status'] = 500;
            $this->_responseData['success'] = false;
            $this->addMessage('Failed to create response - try again');
            $this->_responseData['messages'] = $this->_messages;
        }
        else {
            http_response_code($this->_httpStatusCode);
            $this->_responseData['status'] = $this->_httpStatusCode;
            $this->_responseData['success'] = $this->_success;
            $this->_responseData['mensagens'] = $this->_messages;
            $this->_responseData['data'] = $this->_data;
        }

        echo json_encode($this->_responseData);
    }
}
