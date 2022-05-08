<?php

namespace WebtoonLike\Site\utils\DataTesting;


class DataVerification
{

    private function __construct(
        private readonly DataField $field
    ) {
    }

    /**
     * Call the right set of test depending on the types.
     *
     * @param DataField $field
     *
     * @return bool|void
     */
    public static function verify(DataField $field) {
        $instance = new DataVerification($field);

        switch ($field->getType()) {
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

    /**
     * Tests strings
     *
     * @return bool
     */
    private function verifyString(): bool {
        $str = $this->field->getData();

        if ($this->field->getNullable() && empty($str)) return true;

        if ($this->field->getMinLength() !== null && strlen($str) < $this->field->getMinLength()) return false;

        if ($this->field->getMaxLength() !== null && strlen($str) > $this->field->getMaxLength()) return false;

        if (!$this->field->getNullable() && empty($str)) return false;

        if (!is_null($this->field->getRegex()) && preg_match($this->field->getRegex(), $str) === 0) return false;

        return true;
    }

    /**
     * Tests emails.
     *
     * @return bool
     */
    private function verifyEmail(): bool {
        $email = $this->field->getData();

        if ($this->field->getNullable() && empty($email)) return true;

        if (!$this->field->getNullable() && empty($email)) return false;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;

        if (!is_null($this->field->getRegex()) && preg_match($this->field->getRegex(), $email) === 0) return false;

        return true;
    }

    /**
     * Tests d'entiers.
     *
     * @return bool
     */
    private function verifyInt(): bool {
        $int = $this->field->getData();

        if ($this->field->getNullable() && empty($int)) return true;

        if (!$this->field->getNullable() && empty($int)) return false;

        if (!is_null($this->field->getRegex()) && preg_match($this->field->getRegex(), $int) === 0) return false;

        return true;
    }

    /**
     * Test de décimaux
     *
     * @return bool
     */
    private function verifyFloat(): bool {
        $float = $this->field->getData();

        if ($this->field->getNullable() && empty($float)) return true;

        if (!$this->field->getNullable() && empty($float)) return false;

        if (!is_null($this->field->getRegex()) && preg_match($this->field->getRegex(), $float) === 0) return false;

        return true;
    }

    /**
     * Tests de booleans.
     *
     * @return bool
     */
    private function verifyBool(): bool {
        $bool = $this->field->getData();
        return $this->field->getNullable() || is_bool($bool);
    }

    /**
     * Tests de dates.
     *
     * @return bool
     */
    private function verifyDate(): bool {
        $date = $this->field->getData();

        if ($this->field->getNullable() && empty($date)) return true;

        if (!$this->field->getNullable() && empty($date)) return false;

        if (!is_null($this->field->getRegex()) && preg_match($this->field->getRegex(), $date) === 0) return false;

        return true;
    }

}
