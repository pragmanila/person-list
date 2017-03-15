<?php //-->
/**
 * This file is part of a Custom Project
 * (c) 2017-2019 Acme Inc
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
namespace Cradle\Module\Profile;

use Cradle\Module\Profile\Service as ProfileService;

use Cradle\Module\Utility\Validator as UtilityValidator;

/**
 * Validator layer
 *
 * @vendor   Acme
 * @package  profile
 * @author   John Doe <john@acme.com>
 * @standard PSR-2
 */
class Validator
{
    /**
     * Returns Create Errors
     *
     * @param *array $data
     * @param array  $errors
     *
     * @return array
     */
    public static function getCreateErrors(array $data, array $errors = [])
    {
        if (!isset($data['profile_first']) || empty($data['profile_first'])) {
            $errors['profile_first'] = 'First name is missing.';
        }
        
        if (!isset($data['profile_last']) || empty($data['profile_last'])) {
            $errors['profile_last'] = 'Last name is missing.';
        }
        
        if (!isset($data['profile_email']) || empty($data['profile_email'])) {
            $errors['profile_email'][] = 'Email is missing.';
        }
        
        return self::getOptionalErrors($data, $errors);
    }
    
    /**
     * Returns Update Errors
     *
     * @param *array $data
     * @param array  $errors
     *
     * @return array
     */
    public static function getUpdateErrors(array $data, array $errors = [])
    {
        if (!isset($data['profile_id']) || !is_numeric($data['profile_id'])) {
            $errors['profile_id'] = 'Invalid ID';
        }

        if (isset($data['profile_first']) && empty($data['profile_first'])) {
            $errors['profile_first'] = 'First name is missing.';
        }
        
        if (isset($data['profile_last']) && empty($data['profile_last'])) {
            $errors['profile_last'] = 'Last name is missing.';
        }
        
        if (isset($data['profile_email']) && empty($data['profile_email'])) {
            $errors['profile_email'][] = 'Email is missing.';
        }

        return self::getOptionalErrors($data, $errors);
    }

    /**
     * Returns Optional Errors
     *
     * @param *array $data
     * @param array  $errors
     *
     * @return array
     */
    public static function getOptionalErrors(array $data, array $errors = [])
    {
        //validations
        if (isset($data['profile_email']) && !preg_match(
            '/^(?:(?:(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|\x5c(?=[@,"\[\]'.
            '\x5c\x00-\x20\x7f-\xff]))(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]'.
            '\x5c\x00-\x20\x7f-\xff]|\x5c(?=[@,"\[\]\x5c\x00-\x20\x7f-\xff])|\.(?=[^\.])){1,62'.
            '}(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]\x5c\x00-\x20\x7f-\xff])|'.
            '[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]{1,2})|"(?:[^"]|(?<=\x5c)"){1,62}")@(?:(?!.{64})'.
            '(?:[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.?|[a-zA-Z0-9]\.?)+\.(?:xn--[a-zA-Z0-9]'.
            '+|[a-zA-Z]{2,6})|\[(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])(?:\.(?:[0-1]?\d?\d|2[0-4]\d|25'.
            '[0-5])){3}\])$/',
            $data['profile_email']
        )
        ) {
            $errors['profile_email'][] = 'Email has an invalid format.';
        }

        return $errors;
    }
}
