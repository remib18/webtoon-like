<?php

namespace WebtoonLike\Site\utils\DataTesting;


use DateTime;

class DataVerification {

    private function __construct(
        private DataField $field
    ) {}

    public static function verify(DataField $field) {
        $instance = new DataVerification($field);

        switch ( $field->getType() ) {
            case DataType::string:
                return $instance->verifyString();
            case DataType::email:
                return $instance->verifyEmail();
            case DataType::int:
                return $instance->verifyInt();
            case DataType::float:
                return $instance->verifyFloat();
            case DataType::bool:
                return $instance->verifyBool();
            case DataType::date:
                return $instance->verifyDate();
        }
    }

    public function verifyString(): bool {
        $str = $this->field->getData();

        if($this->field->getNullable() === true && empty($email) === true) {
            return true;
        }


        if($this->field->getMinLength() !== null && strlen($str) <= $this->field->getMinLength()) {
            return false;
        }

        if($this->field->getMaxLength() !== null && strlen($str) >= $this->field->getMaxLength()) {
            return false;
        }

        if($this->field->getNullable() === false && empty($str) === true) {
            return false;
        }

        if($this->field->getRegex() !== null && preg_match($this->field->getRegex(),$str) === 0) {
            return false;
        }

        return true;
    }

    public function verifyEmail(): bool {
        $email = $this->field->getData();

        if($this->field->getNullable() === true && empty($email) === true) {
            return true;
        }


        if($this->field->getNullable() === false && empty($email) === true) {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if($this->field->getRegex() !== null && preg_match($this->field->getRegex(), $email) === 0) {
            return false;
        }

        return true;
    }

    public function verifyInt(): bool {
        $int = $this->field->getData();

        if($this->field->getNullable() === true && empty($int) === true) {
            return true;
        }


        if($this->field->getNullable() === false && empty($int) === true) {
            return false;
        }

        if($this->field->getRegex() !== null && preg_match($this->field->getRegex(),$int) === 0) {
            return false;
        }

        return true;
    }

    public function verifyFloat(): bool {
        $float = $this->field->getData();

        if($this->field->getNullable() === true && empty($float) === true) {
            return true;
        }


        if($this->field->getNullable() === false && empty($float) === true) {
            return false;
        }

        if($this->field->getRegex() !== null && preg_match($this->field->getRegex(),$float) === 0) {
            return false;
        }

        return true;
    }

    public function verifyDate(): bool {
        $date = $this->field->getData();

        if($this->field->getNullable() === true && empty($date) === true) {
            return true;
        }

        if($this->field->getNullable() === false && empty($date) === true) {
            return false;
        }

        // Todo: Validate date
        // Is it even necessary? Isn't PHP handling it in all cases?
        // Users would
        // using the regex would leave more flexibility. 

        if($this->field->getRegex() !== null && preg_match($this->field->getRegex(), $date) === 0) {
            return false;
        }

        return True;

    }

}