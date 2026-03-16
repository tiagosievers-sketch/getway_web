<?php

namespace App\Helpers;

class HUBResponseHelper
{
    /**
     * Interpret the response code from the RIDP or FARS services.
     *
     * @param string $code
     * @return string
     */
    public static function interpretResponseCode(string $code): string
    {
        $messages = [
            // Common HTTP Status Codes
            '200' => 'Success: The request was processed successfully.',
            '400' => 'Bad Request: The request could not be understood or was missing required parameters.',
            '401' => 'Unauthorized: Authentication failed or user does not have permissions for the desired action.',
            '403' => 'Forbidden: Authentication succeeded, but authenticated user does not have access to the resource.',
            '404' => 'Not Found: The requested resource could not be found.',
            '500' => 'Internal Server Error: An error occurred on the server.',
            '503' => 'Service Unavailable: The service is temporarily unavailable.',

            // RIDP Specific Codes (Section 5.1)
            'HE000050' => 'Cannot formulate questions for this consumer.',
            'HE009999' => 'Unexpected System Exception at Experian.',
            'HE200026' => 'Required field missing.',
            'HE200027' => 'The information provided does not match what is in the system.',
            'HE200040' => 'Input validation error, verify data validation rules.',
            'HE200041' => 'Session timeout.',
            'HX005001' => 'Internal Server Error at Precise ID system.',
            'HS000000' => 'Successful: The request was processed successfully.',
            'HX009000' => 'Unexpected System Exception at Hub.',
            'HE007000' => 'Schema Validation Failure.',
            'HE007004' => 'Invalid content type! Content-Type must be application/json.',
            'HE007005' => 'Required header missing/invalid.',

            // FARS Specific Codes (Section 5.2)
            'HE200006' => 'Reference Number does not exist in hub.',
            'HE200045' => 'Data Not Found for the Applicant.',
        ];

        return $messages[$code] ?? 'Unknown response code: ' . $code;
    }

    /**
     * Determine if the response code indicates a successful operation.
     *
     * @param string $code
     * @return bool
     */
    public static function isSuccess(string $code): bool
    {
        return $code === 'HS000000';
    }

    /**
     * Determine if the response code indicates a client error (4xx).
     *
     * @param string $code
     * @return bool
     */
    public static function isClientError(string $code): bool
    {
        return in_array($code, ['400', '401', '403', '404', 'HE200026', 'HE200027', 'HE200040', 'HE200041', 'HE007000', 'HE007004', 'HE007005', 'HE200006', 'HE200045'], true);
    }

    /**
     * Determine if the response code indicates a server error (5xx).
     *
     * @param string $code
     * @return bool
     */
    public static function isServerError(string $code): bool
    {
        return in_array($code, ['500', '503', 'HX005001', 'HX009000', 'HE009999'], true);
    }
}
