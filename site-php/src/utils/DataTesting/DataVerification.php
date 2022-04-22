<?php

namespace WebtoonLike\Site\utils\DataTesting;

class DataVerification {

    private function __construct(
        private DataField $field
    ) {}

    public static function verify(DataField $field) {
        $instance = new DataVerification($field);

        switch ( $field->getType() ) {
            case Data::string:
                return $instance->verifyString();
            case Data::email:
                return $instance->verifyEmail();
            case Data::int:
                return $instance->verifyInt();
            case Data::float:
                return $instance->verifyFloat();
            case Data::bool:
                return $instance->verifyBool();
            case Data::date:
                return $instance->verifyDate();
        }
    }

    public function verifyString(): bool {
        return true;
    }

    public function verifyEmail(): bool {
        return true;
    }

    public function verifyInt(): bool {
        return true;
    }

    public function verifyFloat(): bool {
        return true;
    }

    public function verifyDate(): bool {
        return true;
    }

}