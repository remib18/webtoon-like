<?php

namespace WebtoonLike\Site\utils\DataTesting;

use GPBMetadata\Google\Type\Datetime;

class DataVerification {

    private function __construct(
        private DataField $field
    ) {}

    public static function verify(DataField $field, mixed $data) {
        $instance = new DataVerification($field);

        switch ( $field->getType() ) {
            case Data::string:
                return $instance->verifyString($data);
            case Data::email:
                return $instance->verifyEmail($data);
            case Data::int:
                return $instance->verifyInt($data);
            case Data::float:
                return $instance->verifyFloat($data;
            case Data::bool:
                return $instance->verifyBool($data);
            case Data::date:
                return $instance->verifyDate($data);
        }
    }

    public function verifyString(string $str): bool {
        if($this->field->getMinLength() !== null && strlen($str) < $this->field->getMinLength()) {
            return false;
        }

        if($this->field->getMaxLength() !== null && strlen($str) > $this->field->getMaxLength()) {
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

    public function verifyEmail(string $email): bool {
        if($this->field->getMinLength() !== null && strlen($email) < $this->field->getMinLength()) {
            return false;
        }

        if($this->field->getMaxLength() !== null && strlen($email) > $this->field->getMaxLength()) {
            return false;
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

    public function verifyInt(int $int): bool {

        if($this->field->getNullable() === false && empty($int) === true) {
            return false;
        }

        if($this->field->getRegex() !== null && preg_match($this->field->getRegex(),$int) === 0) {
            return false;
        }

        return true;
    }

    public function verifyFloat(float $float): bool {

        if($this->field->getNullable() === false && empty($float) === true) {
            return false;
        }

        if($this->field->getRegex() !== null && preg_match($this->field->getRegex(),$float) === 0) {
            return false;
        }

        return true;
    }

    public function verifyDate(Datetime $date): bool {

        if($this->field->getNullable() === false && empty($float) === true) {
            return false;
        }

        if($this->field->getRegex() !== null && preg_match($this->field->getRegex(),$float) === 0) {
            return false;
        }

        // Todo: validate the date using its format.

        return true;
    }

}