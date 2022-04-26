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

    }

    public function verifyEmail(string $email): bool {
        return true;
    }

    public function verifyInt(int $int): bool {
        return true;
    }

    public function verifyFloat(float $float): bool {
        return true;
    }

    public function verifyDate(Datetime $date): bool {
        return true;
    }

}