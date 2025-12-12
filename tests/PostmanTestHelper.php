<?php

/**
 * Postman Test Helper
 * 
 * Script ini membantu testing API endpoints
 * Bisa dijalankan via command line atau digunakan sebagai referensi untuk Postman
 */

class PostmanTestHelper
{
    private $baseUrl;
    private $sessionCookie;
    private $csrfToken;

    public function __construct($baseUrl = 'http://127.0.0.1:8000')
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Test GET /api/notifications
     */
    public function testGetNotifications()
    {
        echo "=== Testing GET /api/notifications ===\n";
        
        $ch = curl_init($this->baseUrl . '/api/notifications');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Cookie: ' . $this->sessionCookie,
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo "HTTP Code: $httpCode\n";
        echo "Response: $response\n\n";

        $data = json_decode($response, true);
        
        // Validations
        if ($httpCode === 200) {
            echo "✅ Status Code: PASS\n";
        } else {
            echo "❌ Status Code: FAIL (Expected 200, got $httpCode)\n";
        }

        if (isset($data['notifications']) && is_array($data['notifications'])) {
            echo "✅ Response Structure: PASS\n";
        } else {
            echo "❌ Response Structure: FAIL\n";
        }

        if (isset($data['count']) && is_numeric($data['count'])) {
            echo "✅ Count Field: PASS\n";
        } else {
            echo "❌ Count Field: FAIL\n";
        }

        return $data;
    }

    /**
     * Test POST /api/notifications/{id}/update
     */
    public function testUpdateNotification($permohonanId, $status = 'Menunggu', $menghubungi = null, $keterangan = null)
    {
        echo "=== Testing POST /api/notifications/$permohonanId/update ===\n";

        $data = [
            'status' => $status,
        ];

        if ($menghubungi) {
            $data['menghubungi'] = $menghubungi;
        }

        if ($keterangan) {
            $data['keterangan_menghubungi'] = $keterangan;
        }

        $ch = curl_init($this->baseUrl . "/api/notifications/$permohonanId/update");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'X-CSRF-TOKEN: ' . $this->csrfToken,
                'Cookie: ' . $this->sessionCookie,
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo "HTTP Code: $httpCode\n";
        echo "Request Data: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
        echo "Response: $response\n\n";

        $responseData = json_decode($response, true);

        // Validations
        if ($httpCode === 200) {
            echo "✅ Status Code: PASS\n";
        } else {
            echo "❌ Status Code: FAIL (Expected 200, got $httpCode)\n";
        }

        if (isset($responseData['success']) && $responseData['success'] === true) {
            echo "✅ Success Field: PASS\n";
        } else {
            echo "❌ Success Field: FAIL\n";
        }

        if (isset($responseData['permohonan'])) {
            echo "✅ Permohonan Data: PASS\n";
        } else {
            echo "❌ Permohonan Data: FAIL\n";
        }

        return $responseData;
    }

    /**
     * Test with invalid data (should fail)
     */
    public function testUpdateNotificationInvalid($permohonanId)
    {
        echo "=== Testing POST /api/notifications/$permohonanId/update (Invalid Status) ===\n";

        $data = [
            'status' => 'InvalidStatus', // Invalid status
        ];

        $ch = curl_init($this->baseUrl . "/api/notifications/$permohonanId/update");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'X-CSRF-TOKEN: ' . $this->csrfToken,
                'Cookie: ' . $this->sessionCookie,
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        echo "HTTP Code: $httpCode\n";
        echo "Response: $response\n\n";

        // Should return 422 (Validation Error)
        if ($httpCode === 422) {
            echo "✅ Validation Error: PASS (Correctly rejected invalid data)\n";
        } else {
            echo "❌ Validation Error: FAIL (Expected 422, got $httpCode)\n";
        }

        return json_decode($response, true);
    }

    /**
     * Set session cookie (from browser after login)
     */
    public function setSessionCookie($cookie)
    {
        $this->sessionCookie = $cookie;
    }

    /**
     * Set CSRF token (from page source after login)
     */
    public function setCsrfToken($token)
    {
        $this->csrfToken = $token;
    }
}

// Usage example (uncomment to run):
/*
$tester = new PostmanTestHelper('http://127.0.0.1:8000');

// Set these after logging in via browser
$tester->setSessionCookie('laravel_session=YOUR_SESSION_COOKIE_VALUE');
$tester->setCsrfToken('YOUR_CSRF_TOKEN');

// Run tests
$tester->testGetNotifications();
$tester->testUpdateNotification(1, 'Menunggu', '2024-12-20', 'Sudah dihubungi');
$tester->testUpdateNotificationInvalid(1);
*/

