<?php
    namespace JoonWeb;
    
    class Helper
    {
        public static function sanitizeDomain(string $domain): ?string
        {
            $domain = trim($domain);
            if (empty($domain)) {
                return null;
            }

              // Remove any protocol (http:// or https://)
            $domain = preg_replace('/^https?:\/\//', '', $domain);

            // Remove any trailing slashes
            $domain = rtrim($domain, '/');


            $allowedDomains = ["myjoonweb.com"];

            $allowedDomainsRegexp = "(" . implode("|", $allowedDomains) . ")";

            if (!preg_match($allowedDomainsRegexp, $domain) && (strpos($domain, ".") === false)) {
                $domain .= '.' . ($myshopifyDomain ?? 'myshopify.com');
            }
            $domain = preg_replace("/\A(https?\:\/\/)/", '', $domain);

            if (preg_match("/\A[a-zA-Z0-9][a-zA-Z0-9\-]*\.{$allowedDomainsRegexp}\z/", (string) $domain)) {
                return $domain;
            } else {
                return null;
            }

            
                return $domain;
        }

        public function verifyHmac(string $params, string $secret) {
            $hmac = $params['hmac'] ?? '';
            unset($params['hmac']);
            
            ksort($params);
            $message = http_build_query($params);
            $calculated_hmac = hash_hmac('sha256', $message, $secret);

            return hash_equals($hmac, $calculated_hmac);
        }

        public static function decodeSessionToken(string $jw_token){
            $id_token = json_decode(base64_decode($jw_token), true);
            if ($id_token && $id_token['exp'] > time()) {
                // Valid session - get token from database using site parameter
                $token_data = getStoredTokenFromDatabase($_GET['site']);
                
                if ($token_data) {
                    $session->startSession($_GET['site'], $token_data);
                    // Store JoonWeb session info
                    $_SESSION['joonweb_session'] = $_GET['session'];
                    $_SESSION['joonweb_user'] = $id_token['sub'] ?? null;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }